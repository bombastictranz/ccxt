<?php

namespace ccxt\async;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import
use \ccxt\ArgumentsRequired;
use \ccxt\OrderNotFound;
use \ccxt\NotSupported;

class kuna extends Exchange {

    public function describe() {
        return $this->deep_extend(parent::describe (), array(
            'id' => 'kuna',
            'name' => 'Kuna',
            'countries' => array( 'UA' ),
            'rateLimit' => 1000,
            'version' => 'v2',
            'has' => array(
                'CORS' => null,
                'spot' => true,
                'margin' => null,
                'swap' => false,
                'future' => false,
                'option' => false,
                'cancelOrder' => true,
                'createOrder' => true,
                'fetchBalance' => true,
                'fetchFundingHistory' => false,
                'fetchFundingRate' => false,
                'fetchFundingRateHistory' => false,
                'fetchFundingRates' => false,
                'fetchIndexOHLCV' => false,
                'fetchL3OrderBook' => true,
                'fetchLeverage' => false,
                'fetchMarkets' => true,
                'fetchMarkOHLCV' => false,
                'fetchMyTrades' => true,
                'fetchOHLCV' => 'emulated',
                'fetchOpenInterestHistory' => false,
                'fetchOpenOrders' => true,
                'fetchOrder' => true,
                'fetchOrderBook' => true,
                'fetchPositions' => false,
                'fetchPositionsRisk' => false,
                'fetchPremiumIndexOHLCV' => false,
                'fetchTicker' => true,
                'fetchTickers' => true,
                'fetchTime' => true,
                'fetchTrades' => true,
                'fetchTradingFee' => false,
                'fetchTradingFees' => false,
                'reduceMargin' => false,
                'setLeverage' => false,
                'setPositionMode' => false,
                'withdraw' => null,
            ),
            'timeframes' => null,
            'urls' => array(
                'extension' => '.json',
                'referral' => 'https://kuna.io?r=kunaid-gvfihe8az7o4',
                'logo' => 'https://user-images.githubusercontent.com/51840849/87153927-f0578b80-c2c0-11ea-84b6-74612568e9e1.jpg',
                'api' => array(
                    'xreserve' => 'https://api.xreserve.fund',
                    'v3' => 'https://api.kuna.io',
                    'public' => 'https://kuna.io', // v2
                    'private' => 'https://kuna.io', // v2
                ),
                'www' => 'https://kuna.io',
                'doc' => 'https://kuna.io/documents/api',
                'fees' => 'https://kuna.io/documents/api',
            ),
            'api' => array(
                'xreserve' => array(
                    'get' => array(
                        'nonce' => 1,
                        'fee' => 1,
                        'delegated-transactions' => 1,
                    ),
                    'post' => array(
                        'delegate-transfer' => 1,
                    ),
                ),
                'v3' => array(
                    'public' => array(
                        'get' => array(
                            'timestamp' => 1,
                            'currencies' => 1,
                            'markets' => 1,
                            'tickers' => 1,
                            'k' => 1,
                            'trades_history' => 1,
                            'fees' => 1,
                            'exchange-rates' => 1,
                            'exchange-rates/currency' => 1,
                            'book/market' => 1,
                            'kuna_codes/code/check' => 1,
                            'landing_page_statistic' => 1,
                            'translations/locale' => 1,
                            'trades/market/hist' => 1,
                        ),
                        'post' => array(
                            'http_test' => 1,
                            'deposit_channels' => 1,
                            'withdraw_channels' => 1,
                            'subscription_plans' => 1,
                            'send_to' => 1,
                            'confirm_token' => 1,
                            'kunaid' => 1,
                            'withdraw/prerequest' => 1,
                            'deposit/prerequest' => 1,
                            'deposit/exchange-rates' => 1,
                        ),
                    ),
                    'sign' => array(
                        'get' => array(
                            'reset_password/token' => 1,
                        ),
                        'post' => array(
                            'signup/google' => 1,
                            'signup/resend_confirmation' => 1,
                            'signup' => 1,
                            'signin' => 1,
                            'signin/two_factor' => 1,
                            'signin/resend_confirm_device' => 1,
                            'signin/confirm_device' => 1,
                            'reset_password' => 1,
                            'cool-signin' => 1,
                        ),
                        'put' => array(
                            'reset_password/token' => 1,
                            'signup/code/confirm' => 1,
                        ),
                    ),
                    'private' => array(
                        'post' => array(
                            'auth/w/order/submit' => 1,
                            'auth/r/orders' => 1,
                            'auth/r/orders/market' => 1,
                            'auth/r/orders/markets' => 1,
                            'auth/api_tokens/delete' => 1,
                            'auth/api_tokens/create' => 1,
                            'auth/api_tokens' => 1,
                            'auth/signin_history/uniq' => 1,
                            'auth/signin_history' => 1,
                            'auth/disable_withdraw_confirmation' => 1,
                            'auth/change_password' => 1,
                            'auth/deposit_address' => 1,
                            'auth/announcements/accept' => 1,
                            'auth/announcements/unaccepted' => 1,
                            'auth/otp/deactivate' => 1,
                            'auth/otp/activate' => 1,
                            'auth/otp/secret' => 1,
                            'auth/r/order/market/:order_id/trades' => 1,
                            'auth/r/orders/market/hist' => 1,
                            'auth/r/orders/hist' => 1,
                            'auth/r/orders/hist/markets' => 1,
                            'auth/r/orders/details' => 1,
                            'auth/assets-history' => 1,
                            'auth/assets-history/withdraws' => 1,
                            'auth/assets-history/deposits' => 1,
                            'auth/r/wallets' => 1,
                            'auth/markets/favorites' => 1,
                            'auth/markets/favorites/list' => 1,
                            'auth/me/update' => 1,
                            'auth/me' => 1,
                            'auth/fund_sources' => 1,
                            'auth/fund_sources/list' => 1,
                            'auth/withdraw/resend_confirmation' => 1,
                            'auth/withdraw' => 1,
                            'auth/withdraw/details' => 1,
                            'auth/withdraw/info' => 1,
                            'auth/payment_addresses' => 1,
                            'auth/deposit/prerequest' => 1,
                            'auth/deposit/exchange-rates' => 1,
                            'auth/deposit' => 1,
                            'auth/deposit/details' => 1,
                            'auth/deposit/info' => 1,
                            'auth/kuna_codes/count' => 1,
                            'auth/kuna_codes/details' => 1,
                            'auth/kuna_codes/edit' => 1,
                            'auth/kuna_codes/send-pdf' => 1,
                            'auth/kuna_codes' => 1,
                            'auth/kuna_codes/redeemed-by-me' => 1,
                            'auth/kuna_codes/issued-by-me' => 1,
                            'auth/payment_requests/invoice' => 1,
                            'auth/payment_requests/type' => 1,
                            'auth/referral_program/weekly_earnings' => 1,
                            'auth/referral_program/stats' => 1,
                            'auth/merchant/payout_services' => 1,
                            'auth/merchant/withdraw' => 1,
                            'auth/merchant/payment_services' => 1,
                            'auth/merchant/deposit' => 1,
                            'auth/verification/auth_token' => 1,
                            'auth/kunaid_purchase/create' => 1,
                            'auth/devices/list' => 1,
                            'auth/sessions/list' => 1,
                            'auth/subscriptions/reactivate' => 1,
                            'auth/subscriptions/cancel' => 1,
                            'auth/subscriptions/prolong' => 1,
                            'auth/subscriptions/create' => 1,
                            'auth/subscriptions/list' => 1,
                            'auth/kuna_ids/list' => 1,
                            'order/cancel/multi' => 1,
                            'order/cancel' => 1,
                        ),
                        'put' => array(
                            'auth/fund_sources/id' => 1,
                            'auth/kuna_codes/redeem' => 1,
                        ),
                        'delete' => array(
                            'auth/markets/favorites' => 1,
                            'auth/fund_sources' => 1,
                            'auth/devices' => 1,
                            'auth/devices/list' => 1,
                            'auth/sessions/list' => 1,
                            'auth/sessions' => 1,
                        ),
                    ),
                ),
                'public' => array(
                    'get' => array(
                        'depth', // Get depth or specified market Both asks and bids are sorted from highest price to lowest.
                        'k_with_pending_trades', // Get K data with pending trades, which are the trades not included in K data yet, because there's delay between trade generated and processed by K data generator
                        'k', // Get OHLC(k line) of specific market
                        'markets', // Get all available markets
                        'order_book', // Get the order book of specified market
                        'order_book/{market}',
                        'tickers', // Get ticker of all markets
                        'tickers/{market}', // Get ticker of specific market
                        'timestamp', // Get server current time, in seconds since Unix epoch
                        'trades', // Get recent trades on market, each trade is included only once Trades are sorted in reverse creation order.
                        'trades/{market}',
                    ),
                ),
                'private' => array(
                    'get' => array(
                        'members/me', // Get your profile and accounts info
                        'deposits', // Get your deposits history
                        'deposit', // Get details of specific deposit
                        'deposit_address', // Where to deposit The address field could be empty when a new address is generating (e.g. for bitcoin), you should try again later in that case.
                        'orders', // Get your orders, results is paginated
                        'order', // Get information of specified order
                        'trades/my', // Get your executed trades Trades are sorted in reverse creation order.
                        'withdraws', // Get your cryptocurrency withdraws
                        'withdraw', // Get your cryptocurrency withdraw
                    ),
                    'post' => array(
                        'orders', // Create a Sell/Buy order
                        'orders/multi', // Create multiple sell/buy orders
                        'orders/clear', // Cancel all my orders
                        'order/delete', // Cancel an order
                        'withdraw', // Create a withdraw
                    ),
                ),
            ),
            'fees' => array(
                'trading' => array(
                    'tierBased' => false,
                    'percentage' => true,
                    'taker' => $this->parse_number('0.0025'),
                    'maker' => $this->parse_number('0.0025'),
                ),
                'funding' => array(
                    'withdraw' => array(
                        'UAH' => '1%',
                        'BTC' => 0.001,
                        'BCH' => 0.001,
                        'ETH' => 0.01,
                        'WAVES' => 0.01,
                        'GOL' => 0.0,
                        'GBG' => 0.0,
                        // 'RMC' => 0.001 BTC
                        // 'ARN' => 0.01 ETH
                        // 'R' => 0.01 ETH
                        // 'EVR' => 0.01 ETH
                    ),
                    'deposit' => array(
                        // 'UAH' => (amount) => amount * 0.001 + 5
                    ),
                ),
            ),
            'commonCurrencies' => array(
                'PLA' => 'Plair',
            ),
            'exceptions' => array(
                '2002' => '\\ccxt\\InsufficientFunds',
                '2003' => '\\ccxt\\OrderNotFound',
            ),
        ));
    }

    public function fetch_time($params = array ()) {
        /**
         * fetches the current integer timestamp in milliseconds from the exchange server
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {int} the current integer timestamp in milliseconds from the exchange server
         */
        $response = yield $this->publicGetTimestamp ($params);
        //
        //     1594911427
        //
        return $response * 1000;
    }

    public function fetch_markets($params = array ()) {
        /**
         * retrieves data on all $markets for kuna
         * @param {dict} $params extra parameters specific to the exchange api endpoint
         * @return {[dict]} an array of objects representing market data
         */
        $quotes = array( 'btc', 'rub', 'uah', 'usd', 'usdt', 'usdc' );
        $markets = array();
        $response = yield $this->publicGetTickers ($params);
        //
        //    {
        //        shibuah => {
        //            at => '1644463685',
        //            ticker => {
        //                buy => '0.000911',
        //                sell => '0.00092',
        //                low => '0.000872',
        //                high => '0.000963',
        //                last => '0.000911',
        //                vol => '1539278096.0',
        //                price => '1434244.211249'
        //            }
        //        }
        //    }
        //
        $ids = is_array($response) ? array_keys($response) : array();
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            for ($j = 0; $j < count($quotes); $j++) {
                $quoteId = $quotes[$j];
                // usd gets matched before usdt in usdtusd USDT/USD
                // https://github.com/ccxt/ccxt/issues/9868
                $slicedId = mb_substr($id, 1);
                $index = mb_strpos($slicedId, $quoteId);
                $slice = mb_substr($slicedId, $index);
                if (($index > 0) && ($slice === $quoteId)) {
                    // usd gets matched before usdt in usdtusd USDT/USD
                    // https://github.com/ccxt/ccxt/issues/9868
                    $baseId = $id[0] . str_replace($quoteId, '', $slicedId);
                    $base = $this->safe_currency_code($baseId);
                    $quote = $this->safe_currency_code($quoteId);
                    $markets[] = array(
                        'id' => $id,
                        'symbol' => $base . '/' . $quote,
                        'base' => $base,
                        'quote' => $quote,
                        'settle' => null,
                        'baseId' => $baseId,
                        'quoteId' => $quoteId,
                        'settleId' => null,
                        'type' => 'spot',
                        'spot' => true,
                        'margin' => false,
                        'swap' => false,
                        'future' => false,
                        'option' => false,
                        'active' => null,
                        'contract' => false,
                        'linear' => null,
                        'inverse' => null,
                        'contractSize' => null,
                        'expiry' => null,
                        'expiryDatetime' => null,
                        'strike' => null,
                        'optionType' => null,
                        'precision' => array(
                            'amount' => null,
                            'price' => null,
                        ),
                        'limits' => array(
                            'leverage' => array(
                                'min' => null,
                                'max' => null,
                            ),
                            'amount' => array(
                                'min' => null,
                                'max' => null,
                            ),
                            'price' => array(
                                'min' => null,
                                'max' => null,
                            ),
                            'cost' => array(
                                'min' => null,
                                'max' => null,
                            ),
                        ),
                        'info' => null,
                    );
                }
            }
        }
        return $markets;
    }

    public function fetch_order_book($symbol, $limit = null, $params = array ()) {
        /**
         * fetches information on open orders with bid (buy) and ask (sell) prices, volumes and other data
         * @param {str} $symbol unified $symbol of the $market to fetch the order book for
         * @param {int|null} $limit the maximum amount of order book entries to return
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} A dictionary of {@link https://docs.ccxt.com/en/latest/manual.html#order-book-structure order book structures} indexed by $market symbols
         */
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'market' => $market['id'],
        );
        if ($limit !== null) {
            $request['limit'] = $limit; // default = 300
        }
        $orderbook = yield $this->publicGetDepth (array_merge($request, $params));
        $timestamp = $this->safe_timestamp($orderbook, 'timestamp');
        return $this->parse_order_book($orderbook, $symbol, $timestamp);
    }

    public function parse_ticker($ticker, $market = null) {
        $timestamp = $this->safe_timestamp($ticker, 'at');
        $ticker = $ticker['ticker'];
        $symbol = $this->safe_symbol(null, $market);
        $last = $this->safe_string($ticker, 'last');
        return $this->safe_ticker(array(
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'high' => $this->safe_string($ticker, 'high'),
            'low' => $this->safe_string($ticker, 'low'),
            'bid' => $this->safe_string($ticker, 'buy'),
            'bidVolume' => null,
            'ask' => $this->safe_string($ticker, 'sell'),
            'askVolume' => null,
            'vwap' => null,
            'open' => $this->safe_string($ticker, 'open'),
            'close' => $last,
            'last' => $last,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => null,
            'baseVolume' => $this->safe_string($ticker, 'vol'),
            'quoteVolume' => null,
            'info' => $ticker,
        ), $market);
    }

    public function fetch_tickers($symbols = null, $params = array ()) {
        /**
         * fetches price tickers for multiple markets, statistical calculations with the information calculated over the past 24 hours each $market
         * @param {[str]|null} $symbols unified $symbols of the markets to fetch the ticker for, all $market tickers are returned if not assigned
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} an array of {@link https://docs.ccxt.com/en/latest/manual.html#ticker-structure ticker structures}
         */
        yield $this->load_markets();
        $response = yield $this->publicGetTickers ($params);
        $ids = is_array($response) ? array_keys($response) : array();
        $result = array();
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $market = null;
            $symbol = $id;
            if (is_array($this->markets_by_id) && array_key_exists($id, $this->markets_by_id)) {
                $market = $this->markets_by_id[$id];
                $symbol = $market['symbol'];
            } else {
                $base = mb_substr($id, 0, 3 - 0);
                $quote = mb_substr($id, 3, 6 - 3);
                $base = strtoupper($base);
                $quote = strtoupper($quote);
                $base = $this->safe_currency_code($base);
                $quote = $this->safe_currency_code($quote);
                $symbol = $base . '/' . $quote;
            }
            $result[$symbol] = $this->parse_ticker($response[$id], $market);
        }
        return $this->filter_by_array($result, 'symbol', $symbols);
    }

    public function fetch_ticker($symbol, $params = array ()) {
        /**
         * fetches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific $market
         * @param {str} $symbol unified $symbol of the $market to fetch the ticker for
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} a {@link https://docs.ccxt.com/en/latest/manual.html#ticker-structure ticker structure}
         */
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'market' => $market['id'],
        );
        $response = yield $this->publicGetTickersMarket (array_merge($request, $params));
        return $this->parse_ticker($response, $market);
    }

    public function fetch_l3_order_book($symbol, $limit = null, $params = array ()) {
        return yield $this->fetch_order_book($symbol, $limit, $params);
    }

    public function fetch_trades($symbol, $since = null, $limit = null, $params = array ()) {
        /**
         * get the list of most recent trades for a particular $symbol
         * @param {str} $symbol unified $symbol of the $market to fetch trades for
         * @param {int|null} $since timestamp in ms of the earliest trade to fetch
         * @param {int|null} $limit the maximum amount of trades to fetch
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {[dict]} a list of ~@link https://docs.ccxt.com/en/latest/manual.html?#public-trades trade structures~
         */
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'market' => $market['id'],
        );
        $response = yield $this->publicGetTrades (array_merge($request, $params));
        //
        //      array(
        //          array(
        //              "id":11353466,
        //              "price":"3000.16",
        //              "volume":"0.000397",
        //              "funds":"1.19106352",
        //              "market":"ethusdt",
        //              "created_at":"2022-04-12T18:32:36Z",
        //              "side":null,
        //              "trend":"sell"
        //          ),
        //      )
        //
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function parse_trade($trade, $market = null) {
        //
        // fetchTrades (public)
        //
        //      {
        //          "id":11353466,
        //          "price":"3000.16",
        //          "volume":"0.000397",
        //          "funds":"1.19106352",
        //          "market":"ethusdt",
        //          "created_at":"2022-04-12T18:32:36Z",
        //          "side":null,
        //          "trend":"sell"
        //      }
        //
        // fetchMyTrades (private)
        //
        //      {
        //          "id":11353719,
        //          "price":"0.13566",
        //          "volume":"99.0",
        //          "funds":"13.43034",
        //          "market":"dogeusdt",
        //          "created_at":"2022-04-12T18:58:44Z",
        //          "side":"ask",
        //          "order_id":1665670371,
        //          "trend":"buy"
        //      }
        //
        $timestamp = $this->parse8601($this->safe_string($trade, 'created_at'));
        $symbol = null;
        if ($market) {
            $symbol = $market['symbol'];
        }
        $side = $this->safe_string_2($trade, 'side', 'trend');
        if ($side !== null) {
            $sideMap = array(
                'ask' => 'sell',
                'bid' => 'buy',
            );
            $side = $this->safe_string($sideMap, $side, $side);
        }
        $priceString = $this->safe_string($trade, 'price');
        $amountString = $this->safe_string($trade, 'volume');
        $costString = $this->safe_number($trade, 'funds');
        $orderId = $this->safe_string($trade, 'order_id');
        $id = $this->safe_string($trade, 'id');
        return $this->safe_trade(array(
            'id' => $id,
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'symbol' => $symbol,
            'type' => null,
            'side' => $side,
            'order' => $orderId,
            'takerOrMaker' => null,
            'price' => $priceString,
            'amount' => $amountString,
            'cost' => $costString,
            'fee' => null,
        ), $market);
    }

    public function fetch_ohlcv($symbol, $timeframe = '1m', $since = null, $limit = null, $params = array ()) {
        /**
         * fetches historical candlestick data containing the open, high, low, and close price, and the volume of a market
         * @param {str} $symbol unified $symbol of the market to fetch OHLCV data for
         * @param {str} $timeframe the length of time each candle represents
         * @param {int|null} $since timestamp in ms of the earliest candle to fetch
         * @param {int|null} $limit the maximum amount of candles to fetch
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {[[int]]} A list of candles ordered as timestamp, open, high, low, close, volume
         */
        yield $this->load_markets();
        $trades = yield $this->fetch_trades($symbol, $since, $limit, $params);
        $ohlcvc = $this->build_ohlcvc($trades, $timeframe, $since, $limit);
        $result = array();
        for ($i = 0; $i < count($ohlcvc); $i++) {
            $ohlcv = $ohlcvc[$i];
            $result[] = [
                $ohlcv[0],
                $ohlcv[1],
                $ohlcv[2],
                $ohlcv[3],
                $ohlcv[4],
                $ohlcv[5],
            ];
        }
        return $result;
    }

    public function parse_balance($response) {
        $balances = $this->safe_value($response, 'accounts', array());
        $result = array( 'info' => $balances );
        for ($i = 0; $i < count($balances); $i++) {
            $balance = $balances[$i];
            $currencyId = $this->safe_string($balance, 'currency');
            $code = $this->safe_currency_code($currencyId);
            $account = $this->account();
            $account['free'] = $this->safe_string($balance, 'balance');
            $account['used'] = $this->safe_string($balance, 'locked');
            $result[$code] = $account;
        }
        return $this->safe_balance($result);
    }

    public function fetch_balance($params = array ()) {
        /**
         * query for balance and get the amount of funds available for trading or funds locked in orders
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} a ~@link https://docs.ccxt.com/en/latest/manual.html?#balance-structure balance structure~
         */
        yield $this->load_markets();
        $response = yield $this->privateGetMembersMe ($params);
        return $this->parse_balance($response);
    }

    public function create_order($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        /**
         * create a trade order
         * @param {str} $symbol unified $symbol of the $market to create an order in
         * @param {str} $type 'market' or 'limit'
         * @param {str} $side 'buy' or 'sell'
         * @param {float} $amount how much of currency you want to trade in units of base currency
         * @param {float} $price the $price at which the order is to be fullfilled, in units of the quote currency, ignored in $market orders
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} an {@link https://docs.ccxt.com/en/latest/manual.html#order-structure order structure}
         */
        yield $this->load_markets();
        $request = array(
            'market' => $this->market_id($symbol),
            'side' => $side,
            'volume' => (string) $amount,
            'ord_type' => $type,
        );
        if ($type === 'limit') {
            $request['price'] = (string) $price;
        }
        $response = yield $this->privatePostOrders (array_merge($request, $params));
        $marketId = $this->safe_value($response, 'market');
        $market = $this->safe_value($this->markets_by_id, $marketId);
        return $this->parse_order($response, $market);
    }

    public function cancel_order($id, $symbol = null, $params = array ()) {
        /**
         * cancels an open $order
         * @param {str} $id $order $id
         * @param {str|null} $symbol not used by kuna cancelOrder ()
         * @param {dict} $params extra parameters specific to the kuna api endpoint
         * @return {dict} An {@link https://docs.ccxt.com/en/latest/manual.html#$order-structure $order structure}
         */
        yield $this->load_markets();
        $request = array(
            'id' => $id,
        );
        $response = yield $this->privatePostOrderDelete (array_merge($request, $params));
        $order = $this->parse_order($response);
        $status = $order['status'];
        if ($status === 'closed' || $status === 'canceled') {
            throw new OrderNotFound($this->id . ' ' . $this->json($order));
        }
        return $order;
    }

    public function parse_order_status($status) {
        $statuses = array(
            'done' => 'closed',
            'wait' => 'open',
            'cancel' => 'canceled',
        );
        return $this->safe_string($statuses, $status, $status);
    }

    public function parse_order($order, $market = null) {
        $marketId = $this->safe_string($order, 'market');
        $symbol = $this->safe_symbol($marketId, $market);
        $timestamp = $this->parse8601($this->safe_string($order, 'created_at'));
        $status = $this->parse_order_status($this->safe_string($order, 'state'));
        $type = $this->safe_string($order, 'type');
        $side = $this->safe_string($order, 'side');
        $id = $this->safe_string($order, 'id');
        return $this->safe_order(array(
            'id' => $id,
            'clientOrderId' => null,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'lastTradeTimestamp' => null,
            'status' => $status,
            'symbol' => $symbol,
            'type' => $type,
            'timeInForce' => null,
            'postOnly' => null,
            'side' => $side,
            'price' => $this->safe_string($order, 'price'),
            'stopPrice' => null,
            'amount' => $this->safe_string($order, 'volume'),
            'filled' => $this->safe_string($order, 'executed_volume'),
            'remaining' => $this->safe_string($order, 'remaining_volume'),
            'trades' => null,
            'fee' => null,
            'info' => $order,
            'cost' => null,
            'average' => null,
        ), $market);
    }

    public function fetch_order($id, $symbol = null, $params = array ()) {
        yield $this->load_markets();
        $request = array(
            'id' => intval($id),
        );
        $response = yield $this->privateGetOrder (array_merge($request, $params));
        return $this->parse_order($response);
    }

    public function fetch_open_orders($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchOpenOrders() requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'market' => $market['id'],
        );
        $response = yield $this->privateGetOrders (array_merge($request, $params));
        // todo emulation of fetchClosedOrders, fetchOrders, fetchOrder
        // with order cache . fetchOpenOrders
        // as in BTC-e, Liqui, Yobit, DSX, Tidex, WEX
        return $this->parse_orders($response, $market, $since, $limit);
    }

    public function fetch_my_trades($symbol = null, $since = null, $limit = null, $params = array ()) {
        //
        //      array(
        //          array(
        //              "id":11353719,
        //              "price":"0.13566",
        //              "volume":"99.0",
        //              "funds":"13.43034",
        //              "market":"dogeusdt",
        //              "created_at":"2022-04-12T18:58:44Z",
        //              "side":"ask",
        //              "order_id":1665670371,
        //              "trend":"buy"
        //          ),
        //      )
        //
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchMyTrades() requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'market' => $market['id'],
        );
        $response = yield $this->privateGetTradesMy (array_merge($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function nonce() {
        return $this->milliseconds();
    }

    public function encode_params($params) {
        if (is_array($params) && array_key_exists('orders', $params)) {
            $orders = $params['orders'];
            $query = $this->urlencode($this->keysort($this->omit($params, 'orders')));
            for ($i = 0; $i < count($orders); $i++) {
                $order = $orders[$i];
                $keys = is_array($order) ? array_keys($order) : array();
                for ($k = 0; $k < count($keys); $k++) {
                    $key = $keys[$k];
                    $value = $order[$key];
                    $query .= '&$orders%5B%5D%5B' . $key . '%5D=' . (string) $value;
                }
            }
            return $query;
        }
        return $this->urlencode($this->keysort($params));
    }

    public function sign($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = null;
        if (gettype($api) === 'array' && count(array_filter(array_keys($api), 'is_string')) == 0) {
            list($version, $access) = $api;
            $url = $this->urls['api'][$version] . '/' . $version . '/' . $this->implode_params($path, $params);
            if ($access === 'public') {
                if ($method === 'GET') {
                    if ($params) {
                        $url .= '?' . $this->urlencode($params);
                    }
                } elseif (($method === 'POST') || ($method === 'PUT')) {
                    $headers = array( 'Content-Type' => 'application/json' );
                    $body = $this->json($params);
                }
            } elseif ($access === 'private') {
                throw new NotSupported($this->id . ' private v3 API is not supported yet');
            }
        } else {
            $request = '/api/' . $this->version . '/' . $this->implode_params($path, $params);
            if (is_array($this->urls) && array_key_exists('extension', $this->urls)) {
                $request .= $this->urls['extension'];
            }
            $query = $this->omit($params, $this->extract_params($path));
            $url = $this->urls['api'][$api] . $request;
            if ($api === 'public') {
                if ($query) {
                    $url .= '?' . $this->urlencode($query);
                }
            } else {
                $this->check_required_credentials();
                $nonce = (string) $this->nonce();
                $query = $this->encode_params(array_merge(array(
                    'access_key' => $this->apiKey,
                    'tonce' => $nonce,
                ), $params));
                $auth = $method . '|' . $request . '|' . $query;
                $signed = $this->hmac($this->encode($auth), $this->encode($this->secret));
                $suffix = $query . '&signature=' . $signed;
                if ($method === 'GET') {
                    $url .= '?' . $suffix;
                } else {
                    $body = $suffix;
                    $headers = array( 'Content-Type' => 'application/x-www-form-urlencoded' );
                }
            }
        }
        return array( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function handle_errors($code, $reason, $url, $method, $headers, $body, $response, $requestHeaders, $requestBody) {
        if ($response === null) {
            return;
        }
        if ($code === 400) {
            $error = $this->safe_value($response, 'error');
            $errorCode = $this->safe_string($error, 'code');
            $feedback = $this->id . ' ' . $this->json($response);
            $this->throw_exactly_matched_exception($this->exceptions, $errorCode, $feedback);
            // fallback to default $error handler
        }
    }
}
