namespace ccxt;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

public partial class bl3p : Exchange
{
    public override object describe()
    {
        return this.deepExtend(base.describe(), new Dictionary<string, object>() {
            { "id", "bl3p" },
            { "name", "BL3P" },
            { "countries", new List<object>() {"NL"} },
            { "rateLimit", 1000 },
            { "version", "1" },
            { "comment", "An exchange market by BitonicNL" },
            { "pro", false },
            { "has", new Dictionary<string, object>() {
                { "CORS", null },
                { "spot", true },
                { "margin", false },
                { "swap", false },
                { "future", false },
                { "option", false },
                { "addMargin", false },
                { "cancelOrder", true },
                { "closeAllPositions", false },
                { "closePosition", false },
                { "createDepositAddress", true },
                { "createOrder", true },
                { "createReduceOnlyOrder", false },
                { "createStopLimitOrder", false },
                { "createStopMarketOrder", false },
                { "createStopOrder", false },
                { "fetchBalance", true },
                { "fetchBorrowRateHistories", false },
                { "fetchBorrowRateHistory", false },
                { "fetchCrossBorrowRate", false },
                { "fetchCrossBorrowRates", false },
                { "fetchDepositAddress", false },
                { "fetchDepositAddresses", false },
                { "fetchDepositAddressesByNetwork", false },
                { "fetchFundingHistory", false },
                { "fetchFundingRate", false },
                { "fetchFundingRateHistory", false },
                { "fetchFundingRates", false },
                { "fetchIndexOHLCV", false },
                { "fetchIsolatedBorrowRate", false },
                { "fetchIsolatedBorrowRates", false },
                { "fetchLeverage", false },
                { "fetchMarginMode", false },
                { "fetchMarkOHLCV", false },
                { "fetchOpenInterestHistory", false },
                { "fetchOrderBook", true },
                { "fetchPosition", false },
                { "fetchPositionMode", false },
                { "fetchPositions", false },
                { "fetchPositionsRisk", false },
                { "fetchPremiumIndexOHLCV", false },
                { "fetchTicker", true },
                { "fetchTrades", true },
                { "fetchTradingFee", false },
                { "fetchTradingFees", true },
                { "fetchTransfer", false },
                { "fetchTransfers", false },
                { "reduceMargin", false },
                { "setLeverage", false },
                { "setMarginMode", false },
                { "setPositionMode", false },
                { "transfer", false },
                { "ws", false },
            } },
            { "urls", new Dictionary<string, object>() {
                { "logo", "https://user-images.githubusercontent.com/1294454/28501752-60c21b82-6feb-11e7-818b-055ee6d0e754.jpg" },
                { "api", new Dictionary<string, object>() {
                    { "rest", "https://api.bl3p.eu" },
                } },
                { "www", "https://bl3p.eu" },
                { "doc", new List<object>() {"https://github.com/BitonicNL/bl3p-api/tree/master/docs", "https://bl3p.eu/api", "https://bitonic.nl/en/api"} },
            } },
            { "api", new Dictionary<string, object>() {
                { "public", new Dictionary<string, object>() {
                    { "get", new List<object>() {"{market}/ticker", "{market}/orderbook", "{market}/trades"} },
                } },
                { "private", new Dictionary<string, object>() {
                    { "post", new List<object>() {"{market}/money/depth/full", "{market}/money/order/add", "{market}/money/order/cancel", "{market}/money/order/result", "{market}/money/orders", "{market}/money/orders/history", "{market}/money/trades/fetch", "GENMKT/money/info", "GENMKT/money/deposit_address", "GENMKT/money/new_deposit_address", "GENMKT/money/wallet/history", "GENMKT/money/withdraw"} },
                } },
            } },
            { "markets", new Dictionary<string, object>() {
                { "BTC/EUR", this.safeMarketStructure(new Dictionary<string, object>() {
                    { "id", "BTCEUR" },
                    { "symbol", "BTC/EUR" },
                    { "base", "BTC" },
                    { "quote", "EUR" },
                    { "baseId", "BTC" },
                    { "quoteId", "EUR" },
                    { "maker", 0.0025 },
                    { "taker", 0.0025 },
                    { "type", "spot" },
                    { "spot", true },
                }) },
            } },
            { "precisionMode", TICK_SIZE },
        });
    }

    public override object parseBalance(object response)
    {
        object data = this.safeValue(response, "data", new Dictionary<string, object>() {});
        object wallets = this.safeValue(data, "wallets", new Dictionary<string, object>() {});
        object result = new Dictionary<string, object>() {
            { "info", data },
        };
        object codes = new List<object>(((IDictionary<string,object>)this.currencies).Keys);
        for (object i = 0; isLessThan(i, getArrayLength(codes)); postFixIncrement(ref i))
        {
            object code = getValue(codes, i);
            object currency = this.currency(code);
            object currencyId = getValue(currency, "id");
            object wallet = this.safeValue(wallets, currencyId, new Dictionary<string, object>() {});
            object available = this.safeValue(wallet, "available", new Dictionary<string, object>() {});
            object balance = this.safeValue(wallet, "balance", new Dictionary<string, object>() {});
            object account = this.account();
            ((IDictionary<string,object>)account)["free"] = this.safeString(available, "value");
            ((IDictionary<string,object>)account)["total"] = this.safeString(balance, "value");
            ((IDictionary<string,object>)result)[(string)code] = account;
        }
        return this.safeBalance(result);
    }

    public async override Task<object> fetchBalance(object parameters = null)
    {
        /**
        * @method
        * @name bl3p#fetchBalance
        * @description query for balance and get the amount of funds available for trading or funds locked in orders
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/authenticated_api/http.md#35---get-account-info--balance
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} a [balance structure]{@link https://docs.ccxt.com/#/?id=balance-structure}
        */
        parameters ??= new Dictionary<string, object>();
        await this.loadMarkets();
        object response = await this.privatePostGENMKTMoneyInfo(parameters);
        return this.parseBalance(response);
    }

    public override object parseBidAsk(object bidask, object priceKey = null, object amountKey = null, object countOrIdKey = null)
    {
        priceKey ??= 0;
        amountKey ??= 1;
        countOrIdKey ??= 2;
        object price = this.safeString(bidask, priceKey);
        object size = this.safeString(bidask, amountKey);
        return new List<object> {this.parseNumber(Precise.stringDiv(price, "100000.0")), this.parseNumber(Precise.stringDiv(size, "100000000.0"))};
    }

    public async override Task<object> fetchOrderBook(object symbol, object limit = null, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#fetchOrderBook
        * @description fetches information on open orders with bid (buy) and ask (sell) prices, volumes and other data
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/public_api/http.md#22---orderbook
        * @param {string} symbol unified symbol of the market to fetch the order book for
        * @param {int} [limit] the maximum amount of order book entries to return
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} A dictionary of [order book structures]{@link https://docs.ccxt.com/#/?id=order-book-structure} indexed by market symbols
        */
        parameters ??= new Dictionary<string, object>();
        object market = this.market(symbol);
        object request = new Dictionary<string, object>() {
            { "market", getValue(market, "id") },
        };
        object response = await this.publicGetMarketOrderbook(this.extend(request, parameters));
        object orderbook = this.safeValue(response, "data");
        return this.parseOrderBook(orderbook, getValue(market, "symbol"), null, "bids", "asks", "price_int", "amount_int");
    }

    public override object parseTicker(object ticker, object market = null)
    {
        //
        // {
        //     "currency":"BTC",
        //     "last":32654.55595,
        //     "bid":32552.3642,
        //     "ask":32703.58231,
        //     "high":33500,
        //     "low":31943,
        //     "timestamp":1643372789,
        //     "volume":{
        //         "24h":2.27372413,
        //         "30d":320.79375456
        //     }
        // }
        //
        object symbol = this.safeSymbol(null, market);
        object timestamp = this.safeTimestamp(ticker, "timestamp");
        object last = this.safeString(ticker, "last");
        object volume = this.safeValue(ticker, "volume", new Dictionary<string, object>() {});
        return this.safeTicker(new Dictionary<string, object>() {
            { "symbol", symbol },
            { "timestamp", timestamp },
            { "datetime", this.iso8601(timestamp) },
            { "high", this.safeString(ticker, "high") },
            { "low", this.safeString(ticker, "low") },
            { "bid", this.safeString(ticker, "bid") },
            { "bidVolume", null },
            { "ask", this.safeString(ticker, "ask") },
            { "askVolume", null },
            { "vwap", null },
            { "open", null },
            { "close", last },
            { "last", last },
            { "previousClose", null },
            { "change", null },
            { "percentage", null },
            { "average", null },
            { "baseVolume", this.safeString(volume, "24h") },
            { "quoteVolume", null },
            { "info", ticker },
        }, market);
    }

    public async override Task<object> fetchTicker(object symbol, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#fetchTicker
        * @description fetches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/public_api/http.md#21---ticker
        * @param {string} symbol unified symbol of the market to fetch the ticker for
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} a [ticker structure]{@link https://docs.ccxt.com/#/?id=ticker-structure}
        */
        parameters ??= new Dictionary<string, object>();
        object market = this.market(symbol);
        object request = new Dictionary<string, object>() {
            { "market", getValue(market, "id") },
        };
        object ticker = await this.publicGetMarketTicker(this.extend(request, parameters));
        //
        // {
        //     "currency":"BTC",
        //     "last":32654.55595,
        //     "bid":32552.3642,
        //     "ask":32703.58231,
        //     "high":33500,
        //     "low":31943,
        //     "timestamp":1643372789,
        //     "volume":{
        //         "24h":2.27372413,
        //         "30d":320.79375456
        //     }
        // }
        //
        return this.parseTicker(ticker, market);
    }

    public override object parseTrade(object trade, object market = null)
    {
        //
        // fetchTrades
        //
        //     {
        //         "trade_id": "2518789",
        //         "date": "1694348697745",
        //         "amount_int": "2959153",
        //         "price_int": "2416231440"
        //     }
        //
        object id = this.safeString(trade, "trade_id");
        object timestamp = this.safeInteger(trade, "date");
        object price = this.safeString(trade, "price_int");
        object amount = this.safeString(trade, "amount_int");
        market = this.safeMarket(null, market);
        return this.safeTrade(new Dictionary<string, object>() {
            { "id", id },
            { "info", trade },
            { "timestamp", timestamp },
            { "datetime", this.iso8601(timestamp) },
            { "symbol", getValue(market, "symbol") },
            { "type", null },
            { "side", null },
            { "order", null },
            { "takerOrMaker", null },
            { "price", Precise.stringDiv(price, "100000") },
            { "amount", Precise.stringDiv(amount, "100000000") },
            { "cost", null },
            { "fee", null },
        }, market);
    }

    public async override Task<object> fetchTrades(object symbol, object since = null, object limit = null, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#fetchTrades
        * @description get the list of most recent trades for a particular symbol
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/public_api/http.md#23---last-1000-trades
        * @param {string} symbol unified symbol of the market to fetch trades for
        * @param {int} [since] timestamp in ms of the earliest trade to fetch
        * @param {int} [limit] the maximum amount of trades to fetch
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {Trade[]} a list of [trade structures]{@link https://docs.ccxt.com/#/?id=public-trades}
        */
        parameters ??= new Dictionary<string, object>();
        object market = this.market(symbol);
        object response = await this.publicGetMarketTrades(this.extend(new Dictionary<string, object>() {
            { "market", getValue(market, "id") },
        }, parameters));
        //
        //    {
        //        "result": "success",
        //        "data": {
        //            "trades": [
        //                {
        //                    "trade_id": "2518789",
        //                    "date": "1694348697745",
        //                    "amount_int": "2959153",
        //                    "price_int": "2416231440"
        //                },
        //            ]
        //        }
        //     }
        object result = this.parseTrades(getValue(getValue(response, "data"), "trades"), market, since, limit);
        return result;
    }

    public async override Task<object> fetchTradingFees(object parameters = null)
    {
        /**
        * @method
        * @name bl3p#fetchTradingFees
        * @description fetch the trading fees for multiple markets
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/authenticated_api/http.md#35---get-account-info--balance
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} a dictionary of [fee structures]{@link https://docs.ccxt.com/#/?id=fee-structure} indexed by market symbols
        */
        parameters ??= new Dictionary<string, object>();
        await this.loadMarkets();
        object response = await this.privatePostGENMKTMoneyInfo(parameters);
        //
        //     {
        //         "result": "success",
        //         "data": {
        //             "user_id": "13396",
        //             "wallets": {
        //                 "BTC": {
        //                     "balance": {
        //                         "value_int": "0",
        //                         "display": "0.00000000 BTC",
        //                         "currency": "BTC",
        //                         "value": "0.00000000",
        //                         "display_short": "0.00 BTC"
        //                     },
        //                     "available": {
        //                         "value_int": "0",
        //                         "display": "0.00000000 BTC",
        //                         "currency": "BTC",
        //                         "value": "0.00000000",
        //                         "display_short": "0.00 BTC"
        //                     }
        //                 },
        //                 ...
        //             },
        //             "trade_fee": "0.25"
        //         }
        //     }
        //
        object data = this.safeValue(response, "data", new Dictionary<string, object>() {});
        object feeString = this.safeString(data, "trade_fee");
        object fee = this.parseNumber(Precise.stringDiv(feeString, "100"));
        object result = new Dictionary<string, object>() {};
        for (object i = 0; isLessThan(i, getArrayLength(this.symbols)); postFixIncrement(ref i))
        {
            object symbol = getValue(this.symbols, i);
            ((IDictionary<string,object>)result)[(string)symbol] = new Dictionary<string, object>() {
                { "info", data },
                { "symbol", symbol },
                { "maker", fee },
                { "taker", fee },
                { "percentage", true },
                { "tierBased", false },
            };
        }
        return result;
    }

    public async override Task<object> createOrder(object symbol, object type, object side, object amount, object price = null, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#createOrder
        * @description create a trade order
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/examples/nodejs/example.md#21---create-an-order
        * @param {string} symbol unified symbol of the market to create an order in
        * @param {string} type 'market' or 'limit'
        * @param {string} side 'buy' or 'sell'
        * @param {float} amount how much of currency you want to trade in units of base currency
        * @param {float} [price] the price at which the order is to be fullfilled, in units of the quote currency, ignored in market orders
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        *
        * EXCHANGE SPECIFIC PARAMETERS
        * @param {int} [params.amount_funds] maximal EUR amount to spend (*1e5)
        * @param {string} [params.fee_currency] 'EUR' or 'BTC'
        * @returns {object} an [order structure]{@link https://docs.ccxt.com/#/?id=order-structure}
        */
        parameters ??= new Dictionary<string, object>();
        object market = this.market(symbol);
        object amountString = this.numberToString(amount);
        object priceString = this.numberToString(price);
        object order = new Dictionary<string, object>() {
            { "market", getValue(market, "id") },
            { "amount_int", parseInt(Precise.stringMul(amountString, "100000000")) },
            { "fee_currency", getValue(market, "quote") },
            { "type", ((bool) isTrue((isEqual(side, "buy")))) ? "bid" : "ask" },
        };
        if (isTrue(isEqual(type, "limit")))
        {
            ((IDictionary<string,object>)order)["price_int"] = parseInt(Precise.stringMul(priceString, "100000.0"));
        }
        object response = await this.privatePostMarketMoneyOrderAdd(this.extend(order, parameters));
        object orderId = this.safeString(getValue(response, "data"), "order_id");
        return this.safeOrder(new Dictionary<string, object>() {
            { "info", response },
            { "id", orderId },
        }, market);
    }

    public async override Task<object> cancelOrder(object id, object symbol = null, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#cancelOrder
        * @description cancels an open order
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/authenticated_api/http.md#22---cancel-an-order
        * @param {string} id order id
        * @param {string} symbol unified symbol of the market the order was made in
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} An [order structure]{@link https://docs.ccxt.com/#/?id=order-structure}
        */
        parameters ??= new Dictionary<string, object>();
        object request = new Dictionary<string, object>() {
            { "order_id", id },
        };
        return await this.privatePostMarketMoneyOrderCancel(this.extend(request, parameters));
    }

    public async override Task<object> createDepositAddress(object code, object parameters = null)
    {
        /**
        * @method
        * @name bl3p#createDepositAddress
        * @description create a currency deposit address
        * @see https://github.com/BitonicNL/bl3p-api/blob/master/docs/authenticated_api/http.md#32---create-a-new-deposit-address
        * @param {string} code unified currency code of the currency for the deposit address
        * @param {object} [params] extra parameters specific to the exchange API endpoint
        * @returns {object} an [address structure]{@link https://docs.ccxt.com/#/?id=address-structure}
        */
        parameters ??= new Dictionary<string, object>();
        await this.loadMarkets();
        object currency = this.currency(code);
        object request = new Dictionary<string, object>() {
            { "currency", getValue(currency, "id") },
        };
        object response = await this.privatePostGENMKTMoneyNewDepositAddress(this.extend(request, parameters));
        //
        //    {
        //        "result": "success",
        //        "data": {
        //            "address": "36Udu9zi1uYicpXcJpoKfv3bewZeok5tpk"
        //        }
        //    }
        //
        object data = this.safeDict(response, "data");
        return this.parseDepositAddress(data, currency);
    }

    public override object parseDepositAddress(object depositAddress, object currency = null)
    {
        //
        //    {
        //        "address": "36Udu9zi1uYicpXcJpoKfv3bewZeok5tpk"
        //    }
        //
        object address = this.safeString(depositAddress, "address");
        this.checkAddress(address);
        return new Dictionary<string, object>() {
            { "info", depositAddress },
            { "currency", this.safeString(currency, "code") },
            { "address", address },
            { "tag", null },
            { "network", null },
        };
    }

    public override object sign(object path, object api = null, object method = null, object parameters = null, object headers = null, object body = null)
    {
        api ??= "public";
        method ??= "GET";
        parameters ??= new Dictionary<string, object>();
        object request = this.implodeParams(path, parameters);
        object url = add(add(add(add(getValue(getValue(this.urls, "api"), "rest"), "/"), this.version), "/"), request);
        object query = this.omit(parameters, this.extractParams(path));
        if (isTrue(isEqual(api, "public")))
        {
            if (isTrue(getArrayLength(new List<object>(((IDictionary<string,object>)query).Keys))))
            {
                url = add(url, add("?", this.urlencode(query)));
            }
        } else
        {
            this.checkRequiredCredentials();
            object nonce = this.nonce();
            body = this.urlencode(this.extend(new Dictionary<string, object>() {
                { "nonce", nonce },
            }, query));
            object secret = this.base64ToBinary(this.secret);
            // eslint-disable-next-line quotes
            object auth = add(add(request, " "), body);
            object signature = this.hmac(this.encode(auth), secret, sha512, "base64");
            headers = new Dictionary<string, object>() {
                { "Content-Type", "application/x-www-form-urlencoded" },
                { "Rest-Key", this.apiKey },
                { "Rest-Sign", signature },
            };
        }
        return new Dictionary<string, object>() {
            { "url", url },
            { "method", method },
            { "body", body },
            { "headers", headers },
        };
    }
}
