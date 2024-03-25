namespace ccxt.pro;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code


public partial class bitopro { public bitopro(object args = null) : base(args) { } }
public partial class bitopro : ccxt.bitopro
{
    public override object describe()
    {
        return this.deepExtend(base.describe(), new Dictionary<string, object>() {
            { "has", new Dictionary<string, object>() {
                { "ws", true },
                { "watchBalance", true },
                { "watchMyTrades", true },
                { "watchOHLCV", false },
                { "watchOrderBook", true },
                { "watchOrders", false },
                { "watchTicker", true },
                { "watchTickers", false },
                { "watchTrades", true },
            } },
            { "urls", new Dictionary<string, object>() {
                { "ws", new Dictionary<string, object>() {
                    { "public", "wss://stream.bitopro.com:443/ws/v1/pub" },
                    { "private", "wss://stream.bitopro.com:443/ws/v1/pub/auth" },
                } },
            } },
            { "requiredCredentials", new Dictionary<string, object>() {
                { "apiKey", true },
                { "secret", true },
                { "login", true },
            } },
            { "options", new Dictionary<string, object>() {
                { "tradesLimit", 1000 },
                { "ordersLimit", 1000 },
                { "ws", new Dictionary<string, object>() {
                    { "options", new Dictionary<string, object>() {
                        { "headers", new Dictionary<string, object>() {} },
                    } },
                } },
            } },
        });
    }

    public async virtual Task<object> watchPublic(object path, object messageHash, object marketId)
    {
        object url = add(add(add(add(getValue(getValue(this.urls, "ws"), "public"), "/"), path), "/"), marketId);
        return await this.watch(url, messageHash, null, messageHash);
    }

    public async override Task<object> watchOrderBook(object symbol, object limit = null, object parameters = null)
    {
        /**
        * @method
        * @name bitopro#watchOrderBook
        * @description watches information on open orders with bid (buy) and ask (sell) prices, volumes and other data
        * @see https://github.com/bitoex/bitopro-offical-api-docs/blob/master/ws/public/order_book_stream.md
        * @param {string} symbol unified symbol of the market to fetch the order book for
        * @param {int} [limit] the maximum amount of order book entries to return
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} A dictionary of [order book structures]{@link https://docs.ccxt.com/#/?id=order-book-structure} indexed by market symbols
        */
        parameters ??= new Dictionary<string, object>();
        if (isTrue(!isEqual(limit, null)))
        {
            if (isTrue(isTrue(isTrue(isTrue(isTrue(isTrue(isTrue((!isEqual(limit, 5))) && isTrue((!isEqual(limit, 10)))) && isTrue((!isEqual(limit, 20)))) && isTrue((!isEqual(limit, 50)))) && isTrue((!isEqual(limit, 100)))) && isTrue((!isEqual(limit, 500)))) && isTrue((!isEqual(limit, 1000)))))
            {
                throw new ExchangeError ((string)add(this.id, " watchOrderBook limit argument must be undefined, 5, 10, 20, 50, 100, 500 or 1000")) ;
            }
        }
        await this.loadMarkets();
        object market = this.market(symbol);
        symbol = getValue(market, "symbol");
        object messageHash = add(add("ORDER_BOOK", ":"), symbol);
        object endPart = null;
        if (isTrue(isEqual(limit, null)))
        {
            endPart = getValue(market, "id");
        } else
        {
            endPart = add(add(getValue(market, "id"), ":"), limit);
        }
        object orderbook = await this.watchPublic("order-books", messageHash, endPart);
        return (orderbook as IOrderBook).limit();
    }

    public virtual void handleOrderBook(WebSocketClient client, object message)
    {
        //
        //     {
        //         "event": "ORDER_BOOK",
        //         "timestamp": 1650121915308,
        //         "datetime": "2022-04-16T15:11:55.308Z",
        //         "pair": "BTC_TWD",
        //         "limit": 5,
        //         "scale": 0,
        //         "bids": [
        //             { price: "1188178", amount: '0.0425', count: 1, total: "0.0425" },
        //         ],
        //         "asks": [
        //             {
        //                 "price": "1190740",
        //                 "amount": "0.40943964",
        //                 "count": 1,
        //                 "total": "0.40943964"
        //             },
        //         ]
        //     }
        //
        object marketId = this.safeString(message, "pair");
        object market = this.safeMarket(marketId, null, "_");
        object symbol = getValue(market, "symbol");
        object eventVar = this.safeString(message, "event");
        object messageHash = add(add(eventVar, ":"), symbol);
        object orderbook = this.safeValue(this.orderbooks, symbol);
        if (isTrue(isEqual(orderbook, null)))
        {
            orderbook = this.orderBook(new Dictionary<string, object>() {});
        }
        object timestamp = this.safeInteger(message, "timestamp");
        object snapshot = this.parseOrderBook(message, symbol, timestamp, "bids", "asks", "price", "amount");
        (orderbook as IOrderBook).reset(snapshot);
        callDynamically(client as WebSocketClient, "resolve", new object[] {orderbook, messageHash});
    }

    public async override Task<object> watchTrades(object symbol, object since = null, object limit = null, object parameters = null)
    {
        /**
        * @method
        * @name bitopro#watchTrades
        * @description get the list of most recent trades for a particular symbol
        * @see https://github.com/bitoex/bitopro-offical-api-docs/blob/master/ws/public/trade_stream.md
        * @param {string} symbol unified symbol of the market to fetch trades for
        * @param {int} [since] timestamp in ms of the earliest trade to fetch
        * @param {int} [limit] the maximum amount of trades to fetch
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object[]} a list of [trade structures]{@link https://docs.ccxt.com/#/?id=public-trades}
        */
        parameters ??= new Dictionary<string, object>();
        await this.loadMarkets();
        object market = this.market(symbol);
        symbol = getValue(market, "symbol");
        object messageHash = add(add("TRADE", ":"), symbol);
        object trades = await this.watchPublic("trades", messageHash, getValue(market, "id"));
        if (isTrue(this.newUpdates))
        {
            limit = callDynamically(trades, "getLimit", new object[] {symbol, limit});
        }
        return this.filterBySinceLimit(trades, since, limit, "timestamp", true);
    }

    public virtual void handleTrade(WebSocketClient client, object message)
    {
        //
        //     {
        //         "event": "TRADE",
        //         "timestamp": 1650116346665,
        //         "datetime": "2022-04-16T13:39:06.665Z",
        //         "pair": "BTC_TWD",
        //         "data": [
        //             {
        //                 "event": '',
        //                 "datetime": '',
        //                 "pair": '',
        //                 "timestamp": 1650116227,
        //                 "price": "1189429",
        //                 "amount": "0.0153127",
        //                 "isBuyer": true
        //             },
        //         ]
        //     }
        //
        object marketId = this.safeString(message, "pair");
        object market = this.safeMarket(marketId, null, "_");
        object symbol = getValue(market, "symbol");
        object eventVar = this.safeString(message, "event");
        object messageHash = add(add(eventVar, ":"), symbol);
        object rawData = this.safeValue(message, "data", new List<object>() {});
        object trades = this.parseTrades(rawData, market);
        object tradesCache = this.safeValue(this.trades, symbol);
        if (isTrue(isEqual(tradesCache, null)))
        {
            object limit = this.safeInteger(this.options, "tradesLimit", 1000);
            tradesCache = new ArrayCache(limit);
        }
        for (object i = 0; isLessThan(i, getArrayLength(trades)); postFixIncrement(ref i))
        {
            callDynamically(tradesCache, "append", new object[] {getValue(trades, i)});
        }
        ((IDictionary<string,object>)this.trades)[(string)symbol] = tradesCache;
        callDynamically(client as WebSocketClient, "resolve", new object[] {tradesCache, messageHash});
    }

    public async override Task<object> watchMyTrades(object symbol = null, object since = null, object limit = null, object parameters = null)
    {
        /**
        * @method
        * @name bitopro#watchMyTrades
        * @description watches information on multiple trades made by the user
        * @see https://github.com/bitoex/bitopro-offical-api-docs/blob/master/ws/private/matches_stream.md
        * @param {string} symbol unified market symbol of the market trades were made in
        * @param {int} [since] the earliest time in ms to fetch trades for
        * @param {int} [limit] the maximum number of trade structures to retrieve
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object[]} a list of [trade structures]{@link https://docs.ccxt.com/#/?id=trade-structure
        */
        parameters ??= new Dictionary<string, object>();
        this.checkRequiredCredentials();
        await this.loadMarkets();
        object messageHash = "USER_TRADE";
        if (isTrue(!isEqual(symbol, null)))
        {
            object market = this.market(symbol);
            messageHash = add(add(messageHash, ":"), getValue(market, "symbol"));
        }
        object url = add(add(getValue(getValue(this.urls, "ws"), "private"), "/"), "user-trades");
        this.authenticate(url);
        object trades = await this.watch(url, messageHash, null, messageHash);
        if (isTrue(this.newUpdates))
        {
            limit = callDynamically(trades, "getLimit", new object[] {symbol, limit});
        }
        return this.filterBySinceLimit(trades, since, limit, "timestamp", true);
    }

    public virtual void handleMyTrade(WebSocketClient client, object message)
    {
        //
        //     {
        //         "event": "USER_TRADE",
        //         "timestamp": 1694667358782,
        //         "datetime": "2023-09-14T12:55:58.782Z",
        //         "data": {
        //             "base": "usdt",
        //             "quote": "twd",
        //             "side": "ask",
        //             "price": "32.039",
        //             "volume": "1",
        //             "fee": "6407800",
        //             "feeCurrency": "twd",
        //             "transactionTimestamp": 1694667358,
        //             "eventTimestamp": 1694667358,
        //             "orderID": 390733918,
        //             "orderType": "LIMIT",
        //             "matchID": "bd07673a-94b1-419e-b5ee-d7b723261a5d",
        //             "isMarket": false,
        //             "isMaker": false
        //         }
        //     }
        //
        object data = this.safeValue(message, "data", new Dictionary<string, object>() {});
        object baseId = this.safeString(data, "base");
        object quoteId = this.safeString(data, "quote");
        object bs = this.safeCurrencyCode(baseId);
        object quote = this.safeCurrencyCode(quoteId);
        object symbol = this.symbol(add(add(bs, "/"), quote));
        object messageHash = this.safeString(message, "event");
        if (isTrue(isEqual(this.myTrades, null)))
        {
            object limit = this.safeInteger(this.options, "tradesLimit", 1000);
            this.myTrades = new ArrayCacheBySymbolById(limit);
        }
        object trades = this.myTrades;
        object parsed = this.parseWsTrade(data);
        callDynamically(trades, "append", new object[] {parsed});
        callDynamically(client as WebSocketClient, "resolve", new object[] {trades, messageHash});
        callDynamically(client as WebSocketClient, "resolve", new object[] {trades, add(add(messageHash, ":"), symbol)});
    }

    public override object parseWsTrade(object trade, object market = null)
    {
        //
        //     {
        //         "base": "usdt",
        //         "quote": "twd",
        //         "side": "ask",
        //         "price": "32.039",
        //         "volume": "1",
        //         "fee": "6407800",
        //         "feeCurrency": "twd",
        //         "transactionTimestamp": 1694667358,
        //         "eventTimestamp": 1694667358,
        //         "orderID": 390733918,
        //         "orderType": "LIMIT",
        //         "matchID": "bd07673a-94b1-419e-b5ee-d7b723261a5d",
        //         "isMarket": false,
        //         "isMaker": false
        //     }
        //
        object id = this.safeString(trade, "matchID");
        object orderId = this.safeString(trade, "orderID");
        object timestamp = this.safeTimestamp(trade, "transactionTimestamp");
        object baseId = this.safeString(trade, "base");
        object quoteId = this.safeString(trade, "quote");
        object bs = this.safeCurrencyCode(baseId);
        object quote = this.safeCurrencyCode(quoteId);
        object symbol = this.symbol(add(add(bs, "/"), quote));
        market = this.safeMarket(symbol, market);
        object price = this.safeString(trade, "price");
        object type = this.safeStringLower(trade, "orderType");
        object side = this.safeString(trade, "side");
        if (isTrue(!isEqual(side, null)))
        {
            if (isTrue(isEqual(side, "ask")))
            {
                side = "sell";
            } else if (isTrue(isEqual(side, "bid")))
            {
                side = "buy";
            }
        }
        object amount = this.safeString(trade, "volume");
        object fee = null;
        object feeAmount = this.safeString(trade, "fee");
        object feeSymbol = this.safeCurrencyCode(this.safeString(trade, "feeCurrency"));
        if (isTrue(!isEqual(feeAmount, null)))
        {
            fee = new Dictionary<string, object>() {
                { "cost", feeAmount },
                { "currency", feeSymbol },
                { "rate", null },
            };
        }
        object isMaker = this.safeValue(trade, "isMaker");
        object takerOrMaker = null;
        if (isTrue(!isEqual(isMaker, null)))
        {
            if (isTrue(isMaker))
            {
                takerOrMaker = "maker";
            } else
            {
                takerOrMaker = "taker";
            }
        }
        return this.safeTrade(new Dictionary<string, object>() {
            { "id", id },
            { "info", trade },
            { "order", orderId },
            { "timestamp", timestamp },
            { "datetime", this.iso8601(timestamp) },
            { "symbol", symbol },
            { "takerOrMaker", takerOrMaker },
            { "type", type },
            { "side", side },
            { "price", price },
            { "amount", amount },
            { "cost", null },
            { "fee", fee },
        }, market);
    }

    public async override Task<object> watchTicker(object symbol, object parameters = null)
    {
        /**
        * @method
        * @name bitopro#watchTicker
        * @description watches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
        * @see https://github.com/bitoex/bitopro-offical-api-docs/blob/master/ws/public/ticker_stream.md
        * @param {string} symbol unified symbol of the market to fetch the ticker for
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} a [ticker structure]{@link https://docs.ccxt.com/#/?id=ticker-structure}
        */
        parameters ??= new Dictionary<string, object>();
        await this.loadMarkets();
        object market = this.market(symbol);
        symbol = getValue(market, "symbol");
        object messageHash = add(add("TICKER", ":"), symbol);
        return await this.watchPublic("tickers", messageHash, getValue(market, "id"));
    }

    public virtual void handleTicker(WebSocketClient client, object message)
    {
        //
        //     {
        //         "event": "TICKER",
        //         "timestamp": 1650119165710,
        //         "datetime": "2022-04-16T14:26:05.710Z",
        //         "pair": "BTC_TWD",
        //         "lastPrice": "1189110",
        //         "lastPriceUSD": "40919.1328",
        //         "lastPriceTWD": "1189110",
        //         "isBuyer": true,
        //         "priceChange24hr": "1.23",
        //         "volume24hr": "7.2090",
        //         "volume24hrUSD": "294985.5375",
        //         "volume24hrTWD": "8572279",
        //         "high24hr": "1193656",
        //         "low24hr": "1179321"
        //     }
        //
        object marketId = this.safeString(message, "pair");
        object market = this.safeMarket(marketId, null, "_");
        object symbol = getValue(market, "symbol");
        object eventVar = this.safeString(message, "event");
        object messageHash = add(add(eventVar, ":"), symbol);
        object result = this.parseTicker(message);
        object timestamp = this.safeInteger(message, "timestamp");
        object datetime = this.safeString(message, "datetime");
        ((IDictionary<string,object>)result)["timestamp"] = timestamp;
        ((IDictionary<string,object>)result)["datetime"] = datetime;
        ((IDictionary<string,object>)this.tickers)[(string)symbol] = result;
        callDynamically(client as WebSocketClient, "resolve", new object[] {result, messageHash});
    }

    public virtual void authenticate(object url)
    {
        if (isTrue(isTrue((!isEqual(this.clients, null))) && isTrue((inOp(this.clients, url)))))
        {
            return;
        }
        this.checkRequiredCredentials();
        object nonce = this.milliseconds();
        object rawData = this.json(new Dictionary<string, object>() {
            { "nonce", nonce },
            { "identity", this.login },
        });
        object payload = this.stringToBase64(rawData);
        object signature = this.hmac(this.encode(payload), this.encode(this.secret), sha384);
        object defaultOptions = new Dictionary<string, object>() {
            { "ws", new Dictionary<string, object>() {
                { "options", new Dictionary<string, object>() {
                    { "headers", new Dictionary<string, object>() {} },
                } },
            } },
        };
        // this.options = this.extend (defaultOptions, this.options);
        this.extendExchangeOptions(defaultOptions);
        object originalHeaders = getValue(getValue(getValue(this.options, "ws"), "options"), "headers");
        object headers = new Dictionary<string, object>() {
            { "X-BITOPRO-API", "ccxt" },
            { "X-BITOPRO-APIKEY", this.apiKey },
            { "X-BITOPRO-PAYLOAD", payload },
            { "X-BITOPRO-SIGNATURE", signature },
        };
        ((IDictionary<string,object>)getValue(getValue(this.options, "ws"), "options"))["headers"] = headers;
        // instantiate client
        this.client(url);
        ((IDictionary<string,object>)getValue(getValue(this.options, "ws"), "options"))["headers"] = originalHeaders;
    }

    public async override Task<object> watchBalance(object parameters = null)
    {
        /**
        * @method
        * @name bitopro#watchBalance
        * @description watch balance and get the amount of funds available for trading or funds locked in orders
        * @see https://github.com/bitoex/bitopro-offical-api-docs/blob/master/ws/private/user_balance_stream.md
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} a [balance structure]{@link https://docs.ccxt.com/#/?id=balance-structure}
        */
        parameters ??= new Dictionary<string, object>();
        this.checkRequiredCredentials();
        await this.loadMarkets();
        object messageHash = "ACCOUNT_BALANCE";
        object url = add(add(getValue(getValue(this.urls, "ws"), "private"), "/"), "account-balance");
        this.authenticate(url);
        return await this.watch(url, messageHash, null, messageHash);
    }

    public virtual void handleBalance(WebSocketClient client, object message)
    {
        //
        //     {
        //         "event": "ACCOUNT_BALANCE",
        //         "timestamp": 1650450505715,
        //         "datetime": "2022-04-20T10:28:25.715Z",
        //         "data": {
        //           "ADA": {
        //             "currency": "ADA",
        //             "amount": "0",
        //             "available": "0",
        //             "stake": "0",
        //             "tradable": true
        //           },
        //         }
        //     }
        //
        object eventVar = this.safeString(message, "event");
        object data = this.safeValue(message, "data");
        object timestamp = this.safeInteger(message, "timestamp");
        object datetime = this.safeString(message, "datetime");
        object currencies = new List<object>(((IDictionary<string,object>)data).Keys);
        object result = new Dictionary<string, object>() {
            { "info", data },
            { "timestamp", timestamp },
            { "datetime", datetime },
        };
        for (object i = 0; isLessThan(i, getArrayLength(currencies)); postFixIncrement(ref i))
        {
            object currency = this.safeString(currencies, i);
            object balance = this.safeValue(data, currency);
            object currencyId = this.safeString(balance, "currency");
            object code = this.safeCurrencyCode(currencyId);
            object account = this.account();
            ((IDictionary<string,object>)account)["free"] = this.safeString(balance, "available");
            ((IDictionary<string,object>)account)["total"] = this.safeString(balance, "amount");
            ((IDictionary<string,object>)result)[(string)code] = account;
        }
        this.balance = this.safeBalance(result);
        callDynamically(client as WebSocketClient, "resolve", new object[] {this.balance, eventVar});
    }

    public override void handleMessage(WebSocketClient client, object message)
    {
        object methods = new Dictionary<string, object>() {
            { "TRADE", this.handleTrade },
            { "TICKER", this.handleTicker },
            { "ORDER_BOOK", this.handleOrderBook },
            { "ACCOUNT_BALANCE", this.handleBalance },
            { "USER_TRADE", this.handleMyTrade },
        };
        object eventVar = this.safeString(message, "event");
        object method = this.safeValue(methods, eventVar);
        if (isTrue(!isEqual(method, null)))
        {
            DynamicInvoker.InvokeMethod(method, new object[] { client, message});
        }
    }
}
