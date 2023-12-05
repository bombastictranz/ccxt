# -*- coding: utf-8 -*-

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

from ccxt.base.exchange import Exchange
from ccxt.abstract.btcalpha import ImplicitAPI
import hashlib
from ccxt.base.types import Balances, Currency, Int, Market, Order, OrderBook, OrderSide, OrderType, Str, Strings, Ticker, Tickers, Trade, Transaction
from typing import List
from ccxt.base.errors import ExchangeError
from ccxt.base.errors import InsufficientFunds
from ccxt.base.errors import InvalidOrder
from ccxt.base.errors import DDoSProtection
from ccxt.base.errors import AuthenticationError
from ccxt.base.decimal_to_precision import TICK_SIZE
from ccxt.base.precise import Precise


class btcalpha(Exchange, ImplicitAPI):

    def describe(self):
        return self.deep_extend(super(btcalpha, self).describe(), {
            'id': 'btcalpha',
            'name': 'BTC-Alpha',
            'countries': ['US'],
            'version': 'v1',
            'has': {
                'CORS': None,
                'spot': True,
                'margin': False,
                'swap': False,
                'future': False,
                'option': False,
                'addMargin': False,
                'cancelOrder': True,
                'closeAllPositions': False,
                'closePosition': False,
                'createOrder': True,
                'createReduceOnlyOrder': False,
                'createStopLimitOrder': False,
                'createStopMarketOrder': False,
                'createStopOrder': False,
                'fetchBalance': True,
                'fetchBorrowRateHistories': False,
                'fetchBorrowRateHistory': False,
                'fetchClosedOrders': True,
                'fetchCrossBorrowRate': False,
                'fetchCrossBorrowRates': False,
                'fetchDeposit': False,
                'fetchDeposits': True,
                'fetchFundingHistory': False,
                'fetchFundingRate': False,
                'fetchFundingRateHistory': False,
                'fetchFundingRates': False,
                'fetchIndexOHLCV': False,
                'fetchIsolatedBorrowRate': False,
                'fetchIsolatedBorrowRates': False,
                'fetchL2OrderBook': True,
                'fetchLeverage': False,
                'fetchMarginMode': False,
                'fetchMarkets': True,
                'fetchMarkOHLCV': False,
                'fetchMyTrades': True,
                'fetchOHLCV': True,
                'fetchOpenInterestHistory': False,
                'fetchOpenOrders': True,
                'fetchOrder': True,
                'fetchOrderBook': True,
                'fetchOrders': True,
                'fetchPosition': False,
                'fetchPositionMode': False,
                'fetchPositions': False,
                'fetchPositionsRisk': False,
                'fetchPremiumIndexOHLCV': False,
                'fetchTicker': True,
                'fetchTickers': True,
                'fetchTrades': True,
                'fetchTradingFee': False,
                'fetchTradingFees': False,
                'fetchTransfer': False,
                'fetchTransfers': False,
                'fetchWithdrawal': False,
                'fetchWithdrawals': True,
                'reduceMargin': False,
                'setLeverage': False,
                'setMarginMode': False,
                'setPositionMode': False,
                'transfer': False,
                'withdraw': False,
            },
            'timeframes': {
                '5m': '5',
                '15m': '15',
                '30m': '30',
                '1h': '60',
                '4h': '240',
                '1d': 'D',
            },
            'urls': {
                'logo': 'https://user-images.githubusercontent.com/1294454/42625213-dabaa5da-85cf-11e8-8f99-aa8f8f7699f0.jpg',
                'api': {
                    'rest': 'https://btc-alpha.com/api',
                },
                'www': 'https://btc-alpha.com',
                'doc': 'https://btc-alpha.github.io/api-docs',
                'fees': 'https://btc-alpha.com/fees/',
                'referral': 'https://btc-alpha.com/?r=123788',
            },
            'api': {
                'public': {
                    'get': [
                        'currencies/',
                        'pairs/',
                        'orderbook/{pair_name}',
                        'exchanges/',
                        'charts/{pair}/{type}/chart/',
                        'ticker/',
                    ],
                },
                'private': {
                    'get': [
                        'wallets/',
                        'orders/own/',
                        'order/{id}/',
                        'exchanges/own/',
                        'deposits/',
                        'withdraws/',
                    ],
                    'post': [
                        'order/',
                        'order-cancel/',
                    ],
                },
            },
            'fees': {
                'trading': {
                    'maker': self.parse_number('0.002'),
                    'taker': self.parse_number('0.002'),
                },
                'funding': {
                    'withdraw': {},
                },
            },
            'commonCurrencies': {
                'CBC': 'Cashbery',
            },
            'precisionMode': TICK_SIZE,
            'exceptions': {
                'exact': {},
                'broad': {
                    'Out of balance': InsufficientFunds,  # {"date":1570599531.4814300537,"error":"Out of balance -9.99243661 BTC"}
                },
            },
        })

    def fetch_markets(self, params={}):
        """
        retrieves data on all markets for btcalpha
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict[]: an array of objects representing market data
        """
        response = self.publicGetPairs(params)
        #
        #    [
        #        {
        #            "name": "1INCH_USDT",
        #            "currency1": "1INCH",
        #            "currency2": "USDT",
        #            "price_precision": 4,
        #            "amount_precision": 2,
        #            "minimum_order_size": "0.01000000",
        #            "maximum_order_size": "900000.00000000",
        #            "minimum_order_value": "10.00000000",
        #            "liquidity_type": 10
        #        },
        #    ]
        #
        return self.parse_markets(response)

    def parse_market(self, market) -> Market:
        id = self.safe_string(market, 'name')
        baseId = self.safe_string(market, 'currency1')
        quoteId = self.safe_string(market, 'currency2')
        base = self.safe_currency_code(baseId)
        quote = self.safe_currency_code(quoteId)
        pricePrecision = self.safe_string(market, 'price_precision')
        priceLimit = self.parse_precision(pricePrecision)
        amountLimit = self.safe_string(market, 'minimum_order_size')
        return {
            'id': id,
            'symbol': base + '/' + quote,
            'base': base,
            'quote': quote,
            'settle': None,
            'baseId': baseId,
            'quoteId': quoteId,
            'settleId': None,
            'type': 'spot',
            'spot': True,
            'margin': False,
            'swap': False,
            'future': False,
            'option': False,
            'active': True,
            'contract': False,
            'linear': None,
            'inverse': None,
            'contractSize': None,
            'expiry': None,
            'expiryDatetime': None,
            'strike': None,
            'optionType': None,
            'precision': {
                'amount': self.parse_number(self.parse_precision(self.safe_string(market, 'amount_precision'))),
                'price': self.parse_number(self.parse_precision((pricePrecision))),
            },
            'limits': {
                'leverage': {
                    'min': None,
                    'max': None,
                },
                'amount': {
                    'min': self.parse_number(amountLimit),
                    'max': self.safe_number(market, 'maximum_order_size'),
                },
                'price': {
                    'min': self.parse_number(priceLimit),
                    'max': None,
                },
                'cost': {
                    'min': self.parse_number(Precise.string_mul(priceLimit, amountLimit)),
                    'max': None,
                },
            },
            'created': None,
            'info': market,
        }

    def fetch_tickers(self, symbols: Strings = None, params={}) -> Tickers:
        """
        :see: https://btc-alpha.github.io/api-docs/#tickers
        fetches price tickers for multiple markets, statistical information calculated over the past 24 hours for each market
        :param str[]|None symbols: unified symbols of the markets to fetch the ticker for, all market tickers are returned if not assigned
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: a dictionary of `ticker structures <https://docs.ccxt.com/#/?id=ticker-structure>`
        """
        self.load_markets()
        response = self.publicGetTicker(params)
        #
        #    [
        #        {
        #            "timestamp": "1674658.445272",
        #            "pair": "BTC_USDT",
        #            "last": "22476.85",
        #            "diff": "458.96",
        #            "vol": "6660.847784",
        #            "high": "23106.08",
        #            "low": "22348.29",
        #            "buy": "22508.46",
        #            "sell": "22521.11"
        #        },
        #        ...
        #    ]
        #
        return self.parse_tickers(response, symbols)

    def fetch_ticker(self, symbol: str, params={}) -> Ticker:
        """
        :see: https://btc-alpha.github.io/api-docs/#tickers
        fetches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
        :param str symbol: unified symbol of the market to fetch the ticker for
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: a `ticker structure <https://docs.ccxt.com/#/?id=ticker-structure>`
        """
        self.load_markets()
        market = self.market(symbol)
        request = {
            'pair': market['id'],
        }
        response = self.publicGetTicker(self.extend(request, params))
        #
        #    {
        #        "timestamp": "1674658.445272",
        #        "pair": "BTC_USDT",
        #        "last": "22476.85",
        #        "diff": "458.96",
        #        "vol": "6660.847784",
        #        "high": "23106.08",
        #        "low": "22348.29",
        #        "buy": "22508.46",
        #        "sell": "22521.11"
        #    }
        #
        return self.parse_ticker(response, market)

    def parse_ticker(self, ticker, market: Market = None) -> Ticker:
        #
        #    {
        #        "timestamp": "1674658.445272",
        #        "pair": "BTC_USDT",
        #        "last": "22476.85",
        #        "diff": "458.96",
        #        "vol": "6660.847784",
        #        "high": "23106.08",
        #        "low": "22348.29",
        #        "buy": "22508.46",
        #        "sell": "22521.11"
        #    }
        #
        timestampStr = self.safe_string(ticker, 'timestamp')
        timestamp = int(Precise.string_mul(timestampStr, '1000000'))
        marketId = self.safe_string(ticker, 'pair')
        market = self.safe_market(marketId, market, '_')
        last = self.safe_string(ticker, 'last')
        return self.safe_ticker({
            'info': ticker,
            'symbol': market['symbol'],
            'timestamp': timestamp,
            'datetime': self.iso8601(timestamp),
            'high': self.safe_string(ticker, 'high'),
            'low': self.safe_string(ticker, 'low'),
            'bid': self.safe_string(ticker, 'buy'),
            'bidVolume': None,
            'ask': self.safe_string(ticker, 'sell'),
            'askVolume': None,
            'vwap': None,
            'open': None,
            'close': last,
            'last': last,
            'previousClose': None,
            'change': self.safe_string(ticker, 'diff'),
            'percentage': None,
            'average': None,
            'baseVolume': None,
            'quoteVolume': self.safe_string(ticker, 'vol'),
        }, market)

    def fetch_order_book(self, symbol: str, limit: Int = None, params={}) -> OrderBook:
        """
        :see: https://btc-alpha.github.io/api-docs/#get-orderbook
        fetches information on open orders with bid(buy) and ask(sell) prices, volumes and other data
        :param str symbol: unified symbol of the market to fetch the order book for
        :param int [limit]: the maximum amount of order book entries to return
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: A dictionary of `order book structures <https://docs.ccxt.com/#/?id=order-book-structure>` indexed by market symbols
        """
        self.load_markets()
        market = self.market(symbol)
        request = {
            'pair_name': market['id'],
        }
        if limit:
            request['limit_sell'] = limit
            request['limit_buy'] = limit
        response = self.publicGetOrderbookPairName(self.extend(request, params))
        return self.parse_order_book(response, market['symbol'], None, 'buy', 'sell', 'price', 'amount')

    def parse_bids_asks(self, bidasks, priceKey=0, amountKey=1):
        result = []
        for i in range(0, len(bidasks)):
            bidask = bidasks[i]
            if bidask:
                result.append(self.parse_bid_ask(bidask, priceKey, amountKey))
        return result

    def parse_trade(self, trade, market: Market = None) -> Trade:
        #
        # fetchTrades(public)
        #
        #      {
        #          "id": "202203440",
        #          "timestamp": "1637856276.264215",
        #          "pair": "AAVE_USDT",
        #          "price": "320.79900000",
        #          "amount": "0.05000000",
        #          "type": "buy"
        #      }
        #
        # fetchMyTrades(private)
        #
        #      {
        #          "id": "202203440",
        #          "timestamp": "1637856276.264215",
        #          "pair": "AAVE_USDT",
        #          "price": "320.79900000",
        #          "amount": "0.05000000",
        #          "type": "buy",
        #          "my_side": "buy"
        #      }
        #
        marketId = self.safe_string(trade, 'pair')
        market = self.safe_market(marketId, market, '_')
        timestampRaw = self.safe_string(trade, 'timestamp')
        timestamp = self.parse_to_int(Precise.string_mul(timestampRaw, '1000000'))
        priceString = self.safe_string(trade, 'price')
        amountString = self.safe_string(trade, 'amount')
        id = self.safe_string(trade, 'id')
        side = self.safe_string_2(trade, 'my_side', 'type')
        return self.safe_trade({
            'id': id,
            'info': trade,
            'timestamp': timestamp,
            'datetime': self.iso8601(timestamp),
            'symbol': market['symbol'],
            'order': id,
            'type': 'limit',
            'side': side,
            'takerOrMaker': None,
            'price': priceString,
            'amount': amountString,
            'cost': None,
            'fee': None,
        }, market)

    def fetch_trades(self, symbol: str, since: Int = None, limit: Int = None, params={}) -> List[Trade]:
        """
        get the list of most recent trades for a particular symbol
        :param str symbol: unified symbol of the market to fetch trades for
        :param int [since]: timestamp in ms of the earliest trade to fetch
        :param int [limit]: the maximum amount of trades to fetch
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns Trade[]: a list of `trade structures <https://docs.ccxt.com/#/?id=public-trades>`
        """
        self.load_markets()
        market = None
        request = {}
        if symbol is not None:
            market = self.market(symbol)
            request['pair'] = market['id']
        if limit is not None:
            request['limit'] = limit
        trades = self.publicGetExchanges(self.extend(request, params))
        return self.parse_trades(trades, market, since, limit)

    def fetch_deposits(self, code: Str = None, since: Int = None, limit: Int = None, params={}) -> List[Transaction]:
        """
        fetch all deposits made to an account
        :param str code: unified currency code
        :param int [since]: the earliest time in ms to fetch deposits for
        :param int [limit]: the maximum number of deposits structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict[]: a list of `transaction structures <https://docs.ccxt.com/#/?id=transaction-structure>`
        """
        self.load_markets()
        currency = None
        if code is not None:
            currency = self.currency(code)
        response = self.privateGetDeposits(params)
        #
        #     [
        #         {
        #             "timestamp": 1485363039.18359,
        #             "id": 317,
        #             "currency": "BTC",
        #             "amount": 530.00000000
        #         }
        #     ]
        #
        return self.parse_transactions(response, currency, since, limit, {'type': 'deposit'})

    def fetch_withdrawals(self, code: Str = None, since: Int = None, limit: Int = None, params={}) -> List[Transaction]:
        """
        fetch all withdrawals made from an account
        :param str code: unified currency code
        :param int [since]: the earliest time in ms to fetch withdrawals for
        :param int [limit]: the maximum number of withdrawals structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict[]: a list of `transaction structures <https://docs.ccxt.com/#/?id=transaction-structure>`
        """
        self.load_markets()
        currency = None
        request = {}
        if code is not None:
            currency = self.currency(code)
            request['currency_id'] = currency['id']
        response = self.privateGetWithdraws(self.extend(request, params))
        #
        #     [
        #         {
        #             "id": 403,
        #             "timestamp": 1485363466.868539,
        #             "currency": "BTC",
        #             "amount": 0.53000000,
        #             "status": 20
        #         }
        #     ]
        #
        return self.parse_transactions(response, currency, since, limit, {'type': 'withdrawal'})

    def parse_transaction(self, transaction, currency: Currency = None) -> Transaction:
        #
        #  deposit
        #      {
        #          "timestamp": 1485363039.18359,
        #          "id": 317,
        #          "currency": "BTC",
        #          "amount": 530.00000000
        #      }
        #
        #  withdrawal
        #      {
        #          "id": 403,
        #          "timestamp": 1485363466.868539,
        #          "currency": "BTC",
        #          "amount": 0.53000000,
        #          "status": 20
        #      }
        #
        timestamp = self.safe_timestamp(transaction, 'timestamp')
        currencyId = self.safe_string(transaction, 'currency')
        statusId = self.safe_string(transaction, 'status')
        return {
            'id': self.safe_string(transaction, 'id'),
            'info': transaction,
            'timestamp': timestamp,
            'datetime': self.iso8601(timestamp),
            'network': None,
            'address': None,
            'addressTo': None,
            'addressFrom': None,
            'tag': None,
            'tagTo': None,
            'tagFrom': None,
            'currency': self.safe_currency_code(currencyId, currency),
            'amount': self.safe_number(transaction, 'amount'),
            'txid': None,
            'type': None,
            'status': self.parse_transaction_status(statusId),
            'comment': None,
            'internal': None,
            'fee': None,
            'updated': None,
        }

    def parse_transaction_status(self, status):
        statuses = {
            '10': 'pending',  # New
            '20': 'pending',  # Verified, waiting for approving
            '30': 'ok',       # Approved by moderator
            '40': 'failed',   # Refused by moderator. See your email for more details
            '50': 'canceled',  # Cancelled by user
        }
        return self.safe_string(statuses, status, status)

    def parse_ohlcv(self, ohlcv, market: Market = None) -> list:
        #
        #     {
        #         "time":1591296000,
        #         "open":0.024746,
        #         "close":0.024728,
        #         "low":0.024728,
        #         "high":0.024753,
        #         "volume":16.624
        #     }
        #
        return [
            self.safe_timestamp(ohlcv, 'time'),
            self.safe_number(ohlcv, 'open'),
            self.safe_number(ohlcv, 'high'),
            self.safe_number(ohlcv, 'low'),
            self.safe_number(ohlcv, 'close'),
            self.safe_number(ohlcv, 'volume'),
        ]

    def fetch_ohlcv(self, symbol: str, timeframe='5m', since: Int = None, limit: Int = None, params={}) -> List[list]:
        """
        fetches historical candlestick data containing the open, high, low, and close price, and the volume of a market
        :param str symbol: unified symbol of the market to fetch OHLCV data for
        :param str timeframe: the length of time each candle represents
        :param int [since]: timestamp in ms of the earliest candle to fetch
        :param int [limit]: the maximum amount of candles to fetch
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns int[][]: A list of candles ordered, open, high, low, close, volume
        """
        self.load_markets()
        market = self.market(symbol)
        request = {
            'pair': market['id'],
            'type': self.safe_string(self.timeframes, timeframe, timeframe),
        }
        if limit is not None:
            request['limit'] = limit
        if since is not None:
            request['since'] = self.parse_to_int(since / 1000)
        response = self.publicGetChartsPairTypeChart(self.extend(request, params))
        #
        #     [
        #         {"time":1591296000,"open":0.024746,"close":0.024728,"low":0.024728,"high":0.024753,"volume":16.624},
        #         {"time":1591295700,"open":0.024718,"close":0.02475,"low":0.024711,"high":0.02475,"volume":31.645},
        #         {"time":1591295400,"open":0.024721,"close":0.024717,"low":0.024711,"high":0.02473,"volume":65.071}
        #     ]
        #
        return self.parse_ohlcvs(response, market, timeframe, since, limit)

    def parse_balance(self, response) -> Balances:
        result = {'info': response}
        for i in range(0, len(response)):
            balance = response[i]
            currencyId = self.safe_string(balance, 'currency')
            code = self.safe_currency_code(currencyId)
            account = self.account()
            account['used'] = self.safe_string(balance, 'reserve')
            account['total'] = self.safe_string(balance, 'balance')
            result[code] = account
        return self.safe_balance(result)

    def fetch_balance(self, params={}) -> Balances:
        """
        query for balance and get the amount of funds available for trading or funds locked in orders
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: a `balance structure <https://docs.ccxt.com/#/?id=balance-structure>`
        """
        self.load_markets()
        response = self.privateGetWallets(params)
        return self.parse_balance(response)

    def parse_order_status(self, status):
        statuses = {
            '1': 'open',
            '2': 'canceled',
            '3': 'closed',
        }
        return self.safe_string(statuses, status, status)

    def parse_order(self, order, market: Market = None) -> Order:
        #
        # fetchClosedOrders / fetchOrder
        #     {
        #       "id": "923763073",
        #       "date": "1635451090368",
        #       "type": "sell",
        #       "pair": "XRP_USDT",
        #       "price": "1.00000000",
        #       "amount": "0.00000000",
        #       "status": "3",
        #       "amount_filled": "10.00000000",
        #       "amount_original": "10.0"
        #       "trades": [],
        #     }
        #
        # createOrder
        #     {
        #       "success": True,
        #       "date": "1635451754.497541",
        #       "type": "sell",
        #       "oid": "923776755",
        #       "price": "1.0",
        #       "amount": "10.0",
        #       "amount_filled": "0.0",
        #       "amount_original": "10.0",
        #       "trades": []
        #     }
        #
        marketId = self.safe_string(order, 'pair')
        market = self.safe_market(marketId, market, '_')
        symbol = market['symbol']
        success = self.safe_value(order, 'success', False)
        timestamp = None
        if success:
            timestamp = self.safe_timestamp(order, 'date')
        else:
            timestamp = self.safe_integer(order, 'date')
        price = self.safe_string(order, 'price')
        remaining = self.safe_string(order, 'amount')
        filled = self.safe_string(order, 'amount_filled')
        amount = self.safe_string(order, 'amount_original')
        status = self.parse_order_status(self.safe_string(order, 'status'))
        id = self.safe_string_2(order, 'oid', 'id')
        trades = self.safe_value(order, 'trades')
        side = self.safe_string_2(order, 'my_side', 'type')
        return self.safe_order({
            'id': id,
            'clientOrderId': None,
            'datetime': self.iso8601(timestamp),
            'timestamp': timestamp,
            'status': status,
            'symbol': symbol,
            'type': 'limit',
            'timeInForce': None,
            'postOnly': None,
            'side': side,
            'price': price,
            'stopPrice': None,
            'triggerPrice': None,
            'cost': None,
            'amount': amount,
            'filled': filled,
            'remaining': remaining,
            'trades': trades,
            'fee': None,
            'info': order,
            'lastTradeTimestamp': None,
            'average': None,
        }, market)

    def create_order(self, symbol: str, type: OrderType, side: OrderSide, amount, price=None, params={}):
        """
        :see: https://btc-alpha.github.io/api-docs/#create-order
        create a trade order
        :param str symbol: unified symbol of the market to create an order in
        :param str type: 'limit'
        :param str side: 'buy' or 'sell'
        :param float amount: how much of currency you want to trade in units of base currency
        :param float [price]: the price at which the order is to be fullfilled, in units of the quote currency, ignored in market orders
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: an `order structure <https://docs.ccxt.com/#/?id=order-structure>`
        """
        if type == 'market':
            raise InvalidOrder(self.id + ' only limits orders are supported')
        self.load_markets()
        market = self.market(symbol)
        request = {
            'pair': market['id'],
            'type': side,
            'amount': amount,
            'price': self.price_to_precision(symbol, price),
        }
        response = self.privatePostOrder(self.extend(request, params))
        if not response['success']:
            raise InvalidOrder(self.id + ' ' + self.json(response))
        order = self.parse_order(response, market)
        orderAmount = str(order['amount'])
        amount = order['amount'] if Precise.string_gt(orderAmount, '0') else amount
        order['amount'] = self.parse_number(amount)
        return order

    def cancel_order(self, id: str, symbol: Str = None, params={}):
        """
        :see: https://btc-alpha.github.io/api-docs/#cancel-order
        cancels an open order
        :param str id: order id
        :param str symbol: unified symbol of the market the order was made in
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: An `order structure <https://docs.ccxt.com/#/?id=order-structure>`
        """
        request = {
            'order': id,
        }
        response = self.privatePostOrderCancel(self.extend(request, params))
        return response

    def fetch_order(self, id: str, symbol: Str = None, params={}):
        """
        :see: https://btc-alpha.github.io/api-docs/#retrieve-single-order
        fetches information on an order made by the user
        :param str symbol: not used by btcalpha fetchOrder
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns dict: An `order structure <https://docs.ccxt.com/#/?id=order-structure>`
        """
        self.load_markets()
        request = {
            'id': id,
        }
        order = self.privateGetOrderId(self.extend(request, params))
        return self.parse_order(order)

    def fetch_orders(self, symbol: Str = None, since: Int = None, limit: Int = None, params={}) -> List[Order]:
        """
        :see: https://btc-alpha.github.io/api-docs/#list-own-orders
        fetches information on multiple orders made by the user
        :param str symbol: unified market symbol of the market orders were made in
        :param int [since]: the earliest time in ms to fetch orders for
        :param int [limit]: the maximum number of  orde structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns Order[]: a list of `order structures <https://docs.ccxt.com/#/?id=order-structure>`
        """
        self.load_markets()
        request = {}
        market = None
        if symbol is not None:
            market = self.market(symbol)
            request['pair'] = market['id']
        if limit is not None:
            request['limit'] = limit
        orders = self.privateGetOrdersOwn(self.extend(request, params))
        return self.parse_orders(orders, market, since, limit)

    def fetch_open_orders(self, symbol: Str = None, since: Int = None, limit: Int = None, params={}) -> List[Order]:
        """
        fetch all unfilled currently open orders
        :param str symbol: unified market symbol
        :param int [since]: the earliest time in ms to fetch open orders for
        :param int [limit]: the maximum number of  open orders structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns Order[]: a list of `order structures <https://docs.ccxt.com/#/?id=order-structure>`
        """
        request = {
            'status': '1',
        }
        return self.fetch_orders(symbol, since, limit, self.extend(request, params))

    def fetch_closed_orders(self, symbol: Str = None, since: Int = None, limit: Int = None, params={}) -> List[Order]:
        """
        fetches information on multiple closed orders made by the user
        :param str symbol: unified market symbol of the market orders were made in
        :param int [since]: the earliest time in ms to fetch orders for
        :param int [limit]: the maximum number of  orde structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns Order[]: a list of `order structures <https://docs.ccxt.com/#/?id=order-structure>`
        """
        request = {
            'status': '3',
        }
        return self.fetch_orders(symbol, since, limit, self.extend(request, params))

    def fetch_my_trades(self, symbol: Str = None, since: Int = None, limit: Int = None, params={}):
        """
        fetch all trades made by the user
        :param str symbol: unified market symbol
        :param int [since]: the earliest time in ms to fetch trades for
        :param int [limit]: the maximum number of trades structures to retrieve
        :param dict [params]: extra parameters specific to the exchange API endpoint
        :returns Trade[]: a list of `trade structures <https://docs.ccxt.com/#/?id=trade-structure>`
        """
        self.load_markets()
        request = {}
        if symbol is not None:
            market = self.market(symbol)
            request['pair'] = market['id']
        if limit is not None:
            request['limit'] = limit
        trades = self.privateGetExchangesOwn(self.extend(request, params))
        return self.parse_trades(trades, None, since, limit)

    def nonce(self):
        return self.milliseconds()

    def sign(self, path, api='public', method='GET', params={}, headers=None, body=None):
        query = self.urlencode(self.keysort(self.omit(params, self.extract_params(path))))
        url = self.urls['api']['rest'] + '/'
        if path != 'charts/{pair}/{type}/chart/':
            url += 'v1/'
        url += self.implode_params(path, params)
        headers = {'Accept': 'application/json'}
        if api == 'public':
            if len(query):
                url += '?' + query
        else:
            self.check_required_credentials()
            payload = self.apiKey
            if method == 'POST':
                headers['Content-Type'] = 'application/x-www-form-urlencoded'
                body = query
                payload += body
            elif len(query):
                url += '?' + query
            headers['X-KEY'] = self.apiKey
            headers['X-SIGN'] = self.hmac(self.encode(payload), self.encode(self.secret), hashlib.sha256)
            headers['X-NONCE'] = str(self.nonce())
        return {'url': url, 'method': method, 'body': body, 'headers': headers}

    def handle_errors(self, code, reason, url, method, headers, body, response, requestHeaders, requestBody):
        if response is None:
            return None  # fallback to default error handler
        #
        #     {"date":1570599531.4814300537,"error":"Out of balance -9.99243661 BTC"}
        #
        error = self.safe_string(response, 'error')
        feedback = self.id + ' ' + body
        if error is not None:
            self.throw_exactly_matched_exception(self.exceptions['exact'], error, feedback)
            self.throw_broadly_matched_exception(self.exceptions['broad'], error, feedback)
        if code == 401 or code == 403:
            raise AuthenticationError(feedback)
        elif code == 429:
            raise DDoSProtection(feedback)
        if code < 400:
            return None
        raise ExchangeError(feedback)
