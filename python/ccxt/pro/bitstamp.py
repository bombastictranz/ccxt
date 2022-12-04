# -*- coding: utf-8 -*-

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

from ccxt.pro.base.exchange import Exchange
import ccxt.async_support
from ccxt.pro.base.cache import ArrayCache, ArrayCacheBySymbolById
from ccxt.base.errors import AuthenticationError
from ccxt.base.errors import ArgumentsRequired


class bitstamp(Exchange, ccxt.async_support.bitstamp):

    def describe(self):
        return self.deep_extend(super(bitstamp, self).describe(), {
            'has': {
                'ws': True,
                'watchOrderBook': True,
                'watchOrders': True,
                'watchTrades': True,
                'watchOHLCV': False,
                'watchTicker': False,
                'watchTickers': False,
            },
            'urls': {
                'api': {
                    'ws': 'wss://ws.bitstamp.net',
                },
            },
            'options': {
                'expiresIn': '',
                'userId': '',
                'wsSessionToken': '',
                'watchOrderBook': {
                    'type': 'order_book',  # detail_order_book, diff_order_book
                },
                'tradesLimit': 1000,
                'OHLCVLimit': 1000,
            },
            'exceptions': {
                'exact': {
                    '4009': AuthenticationError,
                },
            },
        })

    async def watch_order_book(self, symbol, limit=None, params={}):
        """
        watches information on open orders with bid(buy) and ask(sell) prices, volumes and other data
        :param str symbol: unified symbol of the market to fetch the order book for
        :param int|None limit: the maximum amount of order book entries to return
        :param dict params: extra parameters specific to the bitstamp api endpoint
        :returns dict: A dictionary of `order book structures <https://docs.ccxt.com/en/latest/manual.html#order-book-structure>` indexed by market symbols
        """
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        options = self.safe_value(self.options, 'watchOrderBook', {})
        type = self.safe_string(options, 'type', 'order_book')
        messageHash = type + '_' + market['id']
        url = self.urls['api']['ws']
        request = {
            'event': 'bts:subscribe',
            'data': {
                'channel': messageHash,
            },
        }
        subscription = {
            'messageHash': messageHash,
            'type': type,
            'symbol': symbol,
            'method': self.handle_order_book_subscription,
            'limit': limit,
            'params': params,
        }
        message = self.extend(request, params)
        orderbook = await self.watch(url, messageHash, message, messageHash, subscription)
        return orderbook.limit()

    async def fetch_order_book_snapshot(self, client, message, subscription):
        symbol = self.safe_string(subscription, 'symbol')
        limit = self.safe_integer(subscription, 'limit')
        params = self.safe_value(subscription, 'params')
        messageHash = self.safe_string(subscription, 'messageHash')
        # todo: self is a synch blocking call in ccxt.php - make it async
        snapshot = await self.fetch_order_book(symbol, limit, params)
        orderbook = self.safe_value(self.orderbooks, symbol)
        if orderbook is not None:
            orderbook.reset(snapshot)
            # unroll the accumulated deltas
            messages = orderbook.cache
            for i in range(0, len(messages)):
                message = messages[i]
                self.handle_order_book_message(client, message, orderbook)
            self.orderbooks[symbol] = orderbook
            client.resolve(orderbook, messageHash)

    def handle_delta(self, bookside, delta):
        price = self.safe_float(delta, 0)
        amount = self.safe_float(delta, 1)
        id = self.safe_string(delta, 2)
        if id is None:
            bookside.store(price, amount)
        else:
            bookside.store(price, amount, id)

    def handle_deltas(self, bookside, deltas):
        for i in range(0, len(deltas)):
            self.handle_delta(bookside, deltas[i])

    def handle_order_book_message(self, client, message, orderbook, nonce=None):
        data = self.safe_value(message, 'data', {})
        microtimestamp = self.safe_integer(data, 'microtimestamp')
        if (nonce is not None) and (microtimestamp <= nonce):
            return orderbook
        self.handle_deltas(orderbook['asks'], self.safe_value(data, 'asks', []))
        self.handle_deltas(orderbook['bids'], self.safe_value(data, 'bids', []))
        orderbook['nonce'] = microtimestamp
        timestamp = int(microtimestamp / 1000)
        orderbook['timestamp'] = timestamp
        orderbook['datetime'] = self.iso8601(timestamp)
        return orderbook

    def handle_order_book(self, client, message):
        #
        # initial snapshot is fetched with ccxt's fetchOrderBook
        # the feed does not include a snapshot, just the deltas
        #
        #     {
        #         data: {
        #             timestamp: '1583656800',
        #             microtimestamp: '1583656800237527',
        #             bids: [
        #                 ["8732.02", "0.00002478", "1207590500704256"],
        #                 ["8729.62", "0.01600000", "1207590502350849"],
        #                 ["8727.22", "0.01800000", "1207590504296448"],
        #             ],
        #             asks: [
        #                 ["8735.67", "2.00000000", "1207590693249024"],
        #                 ["8735.67", "0.01700000", "1207590693634048"],
        #                 ["8735.68", "1.53294500", "1207590692048896"],
        #             ],
        #         },
        #         event: 'data',
        #         channel: 'detail_order_book_btcusd'
        #     }
        #
        channel = self.safe_string(message, 'channel')
        subscription = self.safe_value(client.subscriptions, channel)
        symbol = self.safe_string(subscription, 'symbol')
        type = self.safe_string(subscription, 'type')
        orderbook = self.safe_value(self.orderbooks, symbol)
        if orderbook is None:
            return message
        if type == 'order_book':
            orderbook.reset({})
            self.handle_order_book_message(client, message, orderbook)
            client.resolve(orderbook, channel)
            # replace top bids and asks
        elif type == 'detail_order_book':
            orderbook.reset({})
            self.handle_order_book_message(client, message, orderbook)
            client.resolve(orderbook, channel)
            # replace top bids and asks
        elif type == 'diff_order_book':
            # process incremental deltas
            nonce = self.safe_integer(orderbook, 'nonce')
            if nonce is None:
                # buffer the events you receive from the stream
                orderbook.cache.append(message)
            else:
                try:
                    self.handle_order_book_message(client, message, orderbook, nonce)
                    client.resolve(orderbook, channel)
                except Exception as e:
                    if symbol in self.orderbooks:
                        del self.orderbooks[symbol]
                    if channel in client.subscriptions:
                        del client.subscriptions[channel]
                    client.reject(e, channel)

    async def watch_trades(self, symbol, since=None, limit=None, params={}):
        """
        get the list of most recent trades for a particular symbol
        :param str symbol: unified symbol of the market to fetch trades for
        :param int|None since: timestamp in ms of the earliest trade to fetch
        :param int|None limit: the maximum amount of trades to fetch
        :param dict params: extra parameters specific to the bitstamp api endpoint
        :returns [dict]: a list of `trade structures <https://docs.ccxt.com/en/latest/manual.html?#public-trades>`
        """
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        options = self.safe_value(self.options, 'watchTrades', {})
        type = self.safe_string(options, 'type', 'live_trades')
        messageHash = type + '_' + market['id']
        url = self.urls['api']['ws']
        request = {
            'event': 'bts:subscribe',
            'data': {
                'channel': messageHash,
            },
        }
        subscription = {
            'messageHash': messageHash,
            'type': type,
            'symbol': symbol,
            'limit': limit,
            'params': params,
        }
        message = self.extend(request, params)
        trades = await self.watch(url, messageHash, message, messageHash, subscription)
        if self.newUpdates:
            limit = trades.getLimit(symbol, limit)
        return self.filter_by_since_limit(trades, since, limit, 'timestamp', True)

    def parse_trade(self, trade, market=None):
        #
        #     {
        #         buy_order_id: 1211625836466176,
        #         amount_str: '1.08000000',
        #         timestamp: '1584642064',
        #         microtimestamp: '1584642064685000',
        #         id: 108637852,
        #         amount: 1.08,
        #         sell_order_id: 1211625840754689,
        #         price_str: '6294.77',
        #         type: 1,
        #         price: 6294.77
        #     }
        #
        microtimestamp = self.safe_integer(trade, 'microtimestamp')
        if microtimestamp is None:
            return super(bitstamp, self).parse_trade(trade, market)
        id = self.safe_string(trade, 'id')
        timestamp = int(microtimestamp / 1000)
        price = self.safe_float(trade, 'price')
        amount = self.safe_float(trade, 'amount')
        cost = None
        if (price is not None) and (amount is not None):
            cost = price * amount
        symbol = None
        marketId = self.safe_string(trade, 's')
        if marketId in self.markets_by_id:
            market = self.markets_by_id[marketId]
        if (symbol is None) and (market is not None):
            symbol = market['symbol']
        side = self.safe_integer(trade, 'type')
        side = 'buy' if (side == 0) else 'sell'
        return {
            'info': trade,
            'timestamp': timestamp,
            'datetime': self.iso8601(timestamp),
            'symbol': symbol,
            'id': id,
            'order': None,
            'type': None,
            'takerOrMaker': None,
            'side': side,
            'price': price,
            'amount': amount,
            'cost': cost,
            'fee': None,
        }

    def handle_trade(self, client, message):
        #
        #     {
        #         data: {
        #             buy_order_id: 1207733769326592,
        #             amount_str: "0.14406384",
        #             timestamp: "1583691851",
        #             microtimestamp: "1583691851934000",
        #             id: 106833903,
        #             amount: 0.14406384,
        #             sell_order_id: 1207733765476352,
        #             price_str: "8302.92",
        #             type: 0,
        #             price: 8302.92
        #         },
        #         event: "trade",
        #         channel: "live_trades_btcusd"
        #     }
        #
        # the trade streams push raw trade information in real-time
        # each trade has a unique buyer and seller
        channel = self.safe_string(message, 'channel')
        data = self.safe_value(message, 'data')
        subscription = self.safe_value(client.subscriptions, channel)
        symbol = self.safe_string(subscription, 'symbol')
        market = self.market(symbol)
        trade = self.parse_trade(data, market)
        tradesArray = self.safe_value(self.trades, symbol)
        if tradesArray is None:
            limit = self.safe_integer(self.options, 'tradesLimit', 1000)
            tradesArray = ArrayCache(limit)
            self.trades[symbol] = tradesArray
        tradesArray.append(trade)
        client.resolve(tradesArray, channel)

    async def watch_orders(self, symbol=None, since=None, limit=None, params={}):
        """
        watches information on multiple orders made by the user
        :param str|None symbol: unified market symbol of the market orders were made in
        :param int|None since: the earliest time in ms to fetch orders for
        :param int|None limit: the maximum number of  orde structures to retrieve
        :param dict params: extra parameters specific to the bitstamp api endpoint
        :returns [dict]: a list of `order structures <https://docs.ccxt.com/en/latest/manual.html#order-structure>`
        """
        if symbol is None:
            raise ArgumentsRequired(self.id + ' watchOrders requires a symbol argument')
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        channel = 'private-my_orders'
        messageHash = channel + '_' + market['id']
        subscription = {
            'symbol': symbol,
            'limit': limit,
            'type': channel,
            'params': params,
        }
        orders = await self.subscribe_private(subscription, messageHash, params)
        if self.newUpdates:
            limit = orders.getLimit(symbol, limit)
        return self.filter_by_since_limit(orders, since, limit, 'timestamp', True)

    def handle_orders(self, client, message):
        #
        # {
        #     "data":{
        #        "id":"1463471322288128",
        #        "id_str":"1463471322288128",
        #        "order_type":1,
        #        "datetime":"1646127778",
        #        "microtimestamp":"1646127777950000",
        #        "amount":0.05,
        #        "amount_str":"0.05000000",
        #        "price":1000,
        #        "price_str":"1000.00"
        #     },
        #     "channel":"private-my_orders_ltcusd-4848701",
        # }
        #
        channel = self.safe_string(message, 'channel')
        order = self.safe_value(message, 'data', {})
        limit = self.safe_integer(self.options, 'ordersLimit', 1000)
        if self.orders is None:
            self.orders = ArrayCacheBySymbolById(limit)
        stored = self.orders
        subscription = self.safe_value(client.subscriptions, channel)
        symbol = self.safe_string(subscription, 'symbol')
        market = self.market(symbol)
        parsed = self.parse_ws_order(order, market)
        stored.append(parsed)
        client.resolve(self.orders, channel)

    def parse_ws_order(self, order, market=None):
        #
        #   {
        #        "id":"1463471322288128",
        #        "id_str":"1463471322288128",
        #        "order_type":1,
        #        "datetime":"1646127778",
        #        "microtimestamp":"1646127777950000",
        #        "amount":0.05,
        #        "amount_str":"0.05000000",
        #        "price":1000,
        #        "price_str":"1000.00"
        #    }
        #
        id = self.safe_string(order, 'id_str')
        orderType = self.safe_string_lower(order, 'order_type')
        price = self.safe_string(order, 'price_str')
        amount = self.safe_string(order, 'amount_str')
        side = 'sell' if (orderType == '1') else 'buy'
        timestamp = self.safe_integer_product(order, 'datetime', 1000)
        market = self.safe_market(None, market)
        symbol = market['symbol']
        return self.safe_order({
            'info': order,
            'symbol': symbol,
            'id': id,
            'clientOrderId': None,
            'timestamp': timestamp,
            'datetime': self.iso8601(timestamp),
            'lastTradeTimestamp': None,
            'type': None,
            'timeInForce': None,
            'postOnly': None,
            'side': side,
            'price': price,
            'stopPrice': None,
            'amount': amount,
            'cost': None,
            'average': None,
            'filled': None,
            'remaining': None,
            'status': None,
            'fee': None,
            'trades': None,
        }, market)

    def handle_order_book_subscription(self, client, message, subscription):
        type = self.safe_string(subscription, 'type')
        symbol = self.safe_string(subscription, 'symbol')
        if symbol in self.orderbooks:
            del self.orderbooks[symbol]
        if type == 'order_book':
            limit = self.safe_integer(subscription, 'limit', 100)
            self.orderbooks[symbol] = self.order_book({}, limit)
        elif type == 'detail_order_book':
            limit = self.safe_integer(subscription, 'limit', 100)
            self.orderbooks[symbol] = self.indexed_order_book({}, limit)
        elif type == 'diff_order_book':
            limit = self.safe_integer(subscription, 'limit')
            self.orderbooks[symbol] = self.order_book({}, limit)
            # fetch the snapshot in a separate async call
            self.spawn(self.fetch_order_book_snapshot, client, message, subscription)

    def handle_subscription_status(self, client, message):
        #
        #     {
        #         'event': "bts:subscription_succeeded",
        #         'channel': "detail_order_book_btcusd",
        #         'data': {},
        #     }
        #     {
        #         event: 'bts:subscription_succeeded',
        #         channel: 'private-my_orders_ltcusd-4848701',
        #         data: {}
        #     }
        #
        channel = self.safe_string(message, 'channel')
        subscription = self.safe_value(client.subscriptions, channel, {})
        method = self.safe_value(subscription, 'method')
        if method is not None:
            method(client, message, subscription)
        return message

    def handle_subject(self, client, message):
        #
        #     {
        #         data: {
        #             timestamp: '1583656800',
        #             microtimestamp: '1583656800237527',
        #             bids: [
        #                 ["8732.02", "0.00002478", "1207590500704256"],
        #                 ["8729.62", "0.01600000", "1207590502350849"],
        #                 ["8727.22", "0.01800000", "1207590504296448"],
        #             ],
        #             asks: [
        #                 ["8735.67", "2.00000000", "1207590693249024"],
        #                 ["8735.67", "0.01700000", "1207590693634048"],
        #                 ["8735.68", "1.53294500", "1207590692048896"],
        #             ],
        #         },
        #         event: 'data',
        #         channel: 'detail_order_book_btcusd'
        #     }
        #
        # private order
        #     {
        #         "data":{
        #         "id":"1463471322288128",
        #         "id_str":"1463471322288128",
        #         "order_type":1,
        #         "datetime":"1646127778",
        #         "microtimestamp":"1646127777950000",
        #         "amount":0.05,
        #         "amount_str":"0.05000000",
        #         "price":1000,
        #         "price_str":"1000.00"
        #         },
        #         "channel":"private-my_orders_ltcusd-4848701",
        #     }
        #
        channel = self.safe_string(message, 'channel')
        subscription = self.safe_value(client.subscriptions, channel)
        type = self.safe_string(subscription, 'type')
        methods = {
            'live_trades': self.handle_trade,
            # 'live_orders': self.handle_order_book,
            'order_book': self.handle_order_book,
            'detail_order_book': self.handle_order_book,
            'diff_order_book': self.handle_order_book,
            'private-my_orders': self.handle_orders,
        }
        method = self.safe_value(methods, type)
        if method is None:
            return message
        else:
            return method(client, message)

    def handle_error_message(self, client, message):
        # {
        #     event: 'bts:error',
        #     channel: '',
        #     data: {code: 4009, message: 'Connection is unauthorized.'}
        # }
        event = self.safe_string(message, 'event')
        if event == 'bts:error':
            feedback = self.id + ' ' + self.json(message)
            data = self.safe_value(message, 'data', {})
            code = self.safe_number(data, 'code')
            self.throw_exactly_matched_exception(self.exceptions['exact'], code, feedback)
        return message

    def handle_message(self, client, message):
        if not self.handle_error_message(client, message):
            return
        #
        #     {
        #         'event': "bts:subscription_succeeded",
        #         'channel': "detail_order_book_btcusd",
        #         'data': {},
        #     }
        #
        #     {
        #         data: {
        #             timestamp: '1583656800',
        #             microtimestamp: '1583656800237527',
        #             bids: [
        #                 ["8732.02", "0.00002478", "1207590500704256"],
        #                 ["8729.62", "0.01600000", "1207590502350849"],
        #                 ["8727.22", "0.01800000", "1207590504296448"],
        #             ],
        #             asks: [
        #                 ["8735.67", "2.00000000", "1207590693249024"],
        #                 ["8735.67", "0.01700000", "1207590693634048"],
        #                 ["8735.68", "1.53294500", "1207590692048896"],
        #             ],
        #         },
        #         event: 'data',
        #         channel: 'detail_order_book_btcusd'
        #     }
        #
        #     {
        #         event: 'bts:subscription_succeeded',
        #         channel: 'private-my_orders_ltcusd-4848701',
        #         data: {}
        #     }
        #
        event = self.safe_string(message, 'event')
        if event == 'bts:subscription_succeeded':
            return self.handle_subscription_status(client, message)
        else:
            return self.handle_subject(client, message)

    async def authenticate(self, params={}):
        self.check_required_credentials()
        time = self.milliseconds()
        expiresIn = self.safe_integer(self.options, 'expiresIn')
        if time > expiresIn:
            response = await self.privatePostWebsocketsToken(params)
            #
            # {
            #     "valid_sec":60,
            #     "token":"siPaT4m6VGQCdsDCVbLBemiphHQs552e",
            #     "user_id":4848701
            # }
            #
            sessionToken = self.safe_string(response, 'token')
            if sessionToken is not None:
                userId = self.safe_number(response, 'user_id')
                validity = self.safe_integer_product(response, 'valid_sec', 1000)
                self.options['expiresIn'] = self.sum(time, validity)
                self.options['userId'] = userId
                self.options['wsSessionToken'] = sessionToken
                return response

    async def subscribe_private(self, subscription, messageHash, params={}):
        url = self.urls['api']['ws']
        await self.authenticate()
        messageHash += '-' + self.options['userId']
        request = {
            'event': 'bts:subscribe',
            'data': {
                'channel': messageHash,
                'auth': self.options['wsSessionToken'],
            },
        }
        subscription['messageHash'] = messageHash
        return await self.watch(url, messageHash, self.extend(request, params), messageHash, subscription)
