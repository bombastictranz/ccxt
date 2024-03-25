<?php

namespace ccxt\pro;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import
use ccxt\ExchangeError;
use React\Async;
use React\Promise\PromiseInterface;

class hyperliquid extends \ccxt\async\hyperliquid {

    public function describe() {
        return $this->deep_extend(parent::describe(), array(
            'has' => array(
                'ws' => true,
                'watchBalance' => false,
                'watchMyTrades' => true,
                'watchOHLCV' => true,
                'watchOrderBook' => true,
                'watchOrders' => true,
                'watchTicker' => false,
                'watchTickers' => false,
                'watchTrades' => true,
                'watchPosition' => false,
            ),
            'urls' => array(
                'api' => array(
                    'ws' => array(
                        'public' => 'wss://api.hyperliquid.xyz/ws',
                    ),
                ),
                'test' => array(
                    'ws' => array(
                        'public' => 'wss://api.hyperliquid-testnet.xyz/ws',
                    ),
                ),
            ),
            'options' => array(
            ),
            'streaming' => array(
                'ping' => array($this, 'ping'),
                'keepAlive' => 20000,
            ),
            'exceptions' => array(
                'ws' => array(
                    'exact' => array(
                    ),
                ),
            ),
        ));
    }

    public function watch_order_book(string $symbol, ?int $limit = null, $params = array ()): PromiseInterface {
        return Async\async(function () use ($symbol, $limit, $params) {
            /**
             * watches information on open orders with bid (buy) and ask (sell) prices, volumes and other data
             * @param {string} $symbol unified $symbol of the $market to fetch the order book for
             * @param {int} [$limit] the maximum amount of order book entries to return
             * @param {array} [$params] extra parameters specific to the exchange API endpoint
             * @return {array} A dictionary of ~@link https://docs.ccxt.com/#/?id=order-book-structure order book structures~ indexed by $market symbols
             */
            Async\await($this->load_markets());
            $market = $this->market($symbol);
            $symbol = $market['symbol'];
            $messageHash = 'orderbook:' . $symbol;
            $url = $this->urls['api']['ws']['public'];
            $request = array(
                'method' => 'subscribe',
                'subscription' => array(
                    'type' => 'l2Book',
                    'coin' => $market['base'],
                ),
            );
            $message = array_merge($request, $params);
            $orderbook = Async\await($this->watch($url, $messageHash, $message, $messageHash));
            return $orderbook->limit ();
        }) ();
    }

    public function handle_order_book($client, $message) {
        //
        //     {
        //         "channel" => "l2Book",
        //         "data" => {
        //             "coin" => "BTC",
        //             "time" => 1710131872708,
        //             "levels" => array(
        //                 array(
        //                     {
        //                         "px" => "68674.0",
        //                         "sz" => "0.97139",
        //                         "n" => 4
        //                     }
        //                 ),
        //                 array(
        //                     {
        //                         "px" => "68675.0",
        //                         "sz" => "0.04396",
        //                         "n" => 1
        //                     }
        //                 )
        //             )
        //         }
        //     }
        //
        $entry = $this->safe_dict($message, 'data', array());
        $coin = $this->safe_string($entry, 'coin');
        $marketId = $coin . '/USDC:USDC';
        $market = $this->market($marketId);
        $symbol = $market['symbol'];
        $rawData = $this->safe_list($entry, 'levels', array());
        $data = array(
            'bids' => $this->safe_list($rawData, 0, array()),
            'asks' => $this->safe_list($rawData, 1, array()),
        );
        $timestamp = $this->safe_integer($entry, 'time');
        $snapshot = $this->parse_order_book($data, $symbol, $timestamp, 'bids', 'asks', 'px', 'sz');
        if (!(is_array($this->orderbooks) && array_key_exists($symbol, $this->orderbooks))) {
            $ob = $this->order_book($snapshot);
            $this->orderbooks[$symbol] = $ob;
        }
        $orderbook = $this->orderbooks[$symbol];
        $orderbook->reset ($snapshot);
        $messageHash = 'orderbook:' . $symbol;
        $client->resolve ($orderbook, $messageHash);
    }

    public function watch_my_trades(?string $symbol = null, ?int $since = null, ?int $limit = null, $params = array ()): PromiseInterface {
        return Async\async(function () use ($symbol, $since, $limit, $params) {
            /**
             * watches information on multiple $trades made by the user
             * @param {string} $symbol unified market $symbol of the market orders were made in
             * @param {int} [$since] the earliest time in ms to fetch orders for
             * @param {int} [$limit] the maximum number of order structures to retrieve
             * @param {array} [$params] extra parameters specific to the exchange API endpoint
             * @param {string} [$params->user] user address, will default to $this->walletAddress if not provided
             * @return {array[]} a list of [order structures]{@link https://docs.ccxt.com/#/?id=order-structure
             */
            $userAddress = null;
            list($userAddress, $params) = $this->handlePublicAddress ('watchMyTrades', $params);
            Async\await($this->load_markets());
            $messageHash = 'myTrades';
            if ($symbol !== null) {
                $symbol = $this->symbol($symbol);
                $messageHash .= ':' . $symbol;
            }
            $url = $this->urls['api']['ws']['public'];
            $request = array(
                'method' => 'subscribe',
                'subscription' => array(
                    'type' => 'userFills',
                    'user' => $userAddress,
                ),
            );
            $message = array_merge($request, $params);
            $trades = Async\await($this->watch($url, $messageHash, $message, $messageHash));
            if ($this->newUpdates) {
                $limit = $trades->getLimit ($symbol, $limit);
            }
            return $this->filter_by_symbol_since_limit($trades, $symbol, $since, $limit, true);
        }) ();
    }

    public function handle_my_trades(Client $client, $message) {
        //
        //     {
        //         "channel" => "userFills",
        //         "data" => {
        //             "isSnapshot" => true,
        //             "user" => "0x15f43d1f2dee81424afd891943262aa90f22cc2a",
        //             "fills" => array(
        //                 {
        //                     "coin" => "BTC",
        //                     "px" => "72528.0",
        //                     "sz" => "0.11693",
        //                     "side" => "A",
        //                     "time" => 1710208712815,
        //                     "startPosition" => "0.11693",
        //                     "dir" => "Close Long",
        //                     "closedPnl" => "-0.81851",
        //                     "hash" => "0xc5adaf35f8402750c218040b0a7bc301130051521273b6f398b3caad3e1f3f5f",
        //                     "oid" => 7484888874,
        //                     "crossed" => true,
        //                     "fee" => "2.968244",
        //                     "liquidationMarkPx" => null,
        //                     "tid" => 567547935839686,
        //                     "cloid" => null
        //                 }
        //             )
        //         }
        //     }
        //
        $entry = $this->safe_dict($message, 'data', array());
        if ($this->myTrades === null) {
            $limit = $this->safe_integer($this->options, 'tradesLimit', 1000);
            $this->myTrades = new ArrayCacheBySymbolById ($limit);
        }
        $trades = $this->myTrades;
        $symbols = array();
        $data = $this->safe_list($entry, 'fills', array());
        $dataLength = count($data);
        if ($dataLength === 0) {
            return;
        }
        for ($i = 0; $i < count($data); $i++) {
            $rawTrade = $data[$i];
            $parsed = $this->parse_ws_trade($rawTrade);
            $symbol = $parsed['symbol'];
            $symbols[$symbol] = true;
            $trades->append ($parsed);
        }
        $keys = is_array($symbols) ? array_keys($symbols) : array();
        for ($i = 0; $i < count($keys); $i++) {
            $currentMessageHash = 'myTrades:' . $keys[$i];
            $client->resolve ($trades, $currentMessageHash);
        }
        // non-$symbol specific
        $messageHash = 'myTrades';
        $client->resolve ($trades, $messageHash);
    }

    public function watch_trades(string $symbol, ?int $since = null, ?int $limit = null, $params = array ()): PromiseInterface {
        return Async\async(function () use ($symbol, $since, $limit, $params) {
            /**
             * watches information on multiple $trades made in a $market
             * @param {string} $symbol unified $market $symbol of the $market $trades were made in
             * @param {int} [$since] the earliest time in ms to fetch $trades for
             * @param {int} [$limit] the maximum number of trade structures to retrieve
             * @param {array} [$params] extra parameters specific to the exchange API endpoint
             * @return {array[]} a list of [trade structures]{@link https://docs.ccxt.com/#/?id=trade-structure
             */
            Async\await($this->load_markets());
            $market = $this->market($symbol);
            $symbol = $market['symbol'];
            $messageHash = 'trade:' . $symbol;
            $url = $this->urls['api']['ws']['public'];
            $request = array(
                'method' => 'subscribe',
                'subscription' => array(
                    'type' => 'trades',
                    'coin' => $market['base'],
                ),
            );
            $message = array_merge($request, $params);
            $trades = Async\await($this->watch($url, $messageHash, $message, $messageHash));
            if ($this->newUpdates) {
                $limit = $trades->getLimit ($symbol, $limit);
            }
            return $this->filter_by_since_limit($trades, $since, $limit, 'timestamp', true);
        }) ();
    }

    public function handle_trades(Client $client, $message) {
        //
        //     {
        //         "channel" => "trades",
        //         "data" => array(
        //             {
        //                 "coin" => "BTC",
        //                 "side" => "A",
        //                 "px" => "68517.0",
        //                 "sz" => "0.005",
        //                 "time" => 1710125266669,
        //                 "hash" => "0xc872699f116e012186620407fc08a802015e0097c5cce74710697f7272e6e959",
        //                 "tid" => 981894269203506
        //             }
        //         )
        //     }
        //
        $entry = $this->safe_list($message, 'data', array());
        $first = $this->safe_dict($entry, 0, array());
        $coin = $this->safe_string($first, 'coin');
        $marketId = $coin . '/USDC:USDC';
        $market = $this->market($marketId);
        $symbol = $market['symbol'];
        if (!(is_array($this->trades) && array_key_exists($symbol, $this->trades))) {
            $limit = $this->safe_integer($this->options, 'tradesLimit', 1000);
            $stored = new ArrayCache ($limit);
            $this->trades[$symbol] = $stored;
        }
        $trades = $this->trades[$symbol];
        for ($i = 0; $i < count($entry); $i++) {
            $data = $this->safe_dict($entry, $i);
            $trade = $this->parse_ws_trade($data);
            $trades->append ($trade);
        }
        $messageHash = 'trade:' . $symbol;
        $client->resolve ($trades, $messageHash);
    }

    public function parse_ws_trade($trade, ?array $market = null): array {
        //
        // fetchMyTrades
        //
        //     {
        //         "coin" => "BTC",
        //         "px" => "72528.0",
        //         "sz" => "0.11693",
        //         "side" => "A",
        //         "time" => 1710208712815,
        //         "startPosition" => "0.11693",
        //         "dir" => "Close Long",
        //         "closedPnl" => "-0.81851",
        //         "hash" => "0xc5adaf35f8402750c218040b0a7bc301130051521273b6f398b3caad3e1f3f5f",
        //         "oid" => 7484888874,
        //         "crossed" => true,
        //         "fee" => "2.968244",
        //         "liquidationMarkPx" => null,
        //         "tid" => 567547935839686,
        //         "cloid" => null
        //     }
        //
        // fetchTrades
        //
        //     {
        //         "coin" => "BTC",
        //         "side" => "A",
        //         "px" => "68517.0",
        //         "sz" => "0.005",
        //         "time" => 1710125266669,
        //         "hash" => "0xc872699f116e012186620407fc08a802015e0097c5cce74710697f7272e6e959",
        //         "tid" => 981894269203506
        //     }
        //
        $timestamp = $this->safe_integer($trade, 'time');
        $price = $this->safe_string($trade, 'px');
        $amount = $this->safe_string($trade, 'sz');
        $coin = $this->safe_string($trade, 'coin');
        $marketId = $coin . '/USDC:USDC';
        $market = $this->safe_market($marketId, null);
        $symbol = $market['symbol'];
        $id = $this->safe_string($trade, 'tid');
        $side = $this->safe_string($trade, 'side');
        if ($side !== null) {
            $side = ($side === 'A') ? 'sell' : 'buy';
        }
        $fee = $this->safe_string($trade, 'fee');
        return $this->safe_trade(array(
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'symbol' => $symbol,
            'id' => $id,
            'order' => null,
            'type' => null,
            'side' => $side,
            'takerOrMaker' => null,
            'price' => $price,
            'amount' => $amount,
            'cost' => null,
            'fee' => array( 'cost' => $fee, 'currency' => 'USDC' ),
        ), $market);
    }

    public function watch_ohlcv(string $symbol, $timeframe = '1m', ?int $since = null, ?int $limit = null, $params = array ()): PromiseInterface {
        return Async\async(function () use ($symbol, $timeframe, $since, $limit, $params) {
            /**
             * watches historical candlestick data containing the open, high, low, close price, and the volume of a $market
             * @param {string} $symbol unified $symbol of the $market to fetch OHLCV data for
             * @param {string} $timeframe the length of time each candle represents
             * @param {int} [$since] timestamp in ms of the earliest candle to fetch
             * @param {int} [$limit] the maximum amount of candles to fetch
             * @param {array} [$params] extra parameters specific to the exchange API endpoint
             * @return {int[][]} A list of candles ordered, open, high, low, close, volume
             */
            Async\await($this->load_markets());
            $market = $this->market($symbol);
            $symbol = $market['symbol'];
            $url = $this->urls['api']['ws']['public'];
            $request = array(
                'method' => 'subscribe',
                'subscription' => array(
                    'type' => 'candle',
                    'coin' => $market['base'],
                    'interval' => $timeframe,
                ),
            );
            $messageHash = 'candles:' . $timeframe . ':' . $symbol;
            $message = array_merge($request, $params);
            $ohlcv = Async\await($this->watch($url, $messageHash, $message, $messageHash));
            if ($this->newUpdates) {
                $limit = $ohlcv->getLimit ($symbol, $limit);
            }
            return $this->filter_by_since_limit($ohlcv, $since, $limit, 0, true);
        }) ();
    }

    public function handle_ohlcv(Client $client, $message) {
        //
        //     {
        //         channel => 'candle',
        //         $data => {
        //             t => 1710146280000,
        //             T => 1710146339999,
        //             s => 'BTC',
        //             i => '1m',
        //             o => '71400.0',
        //             c => '71411.0',
        //             h => '71422.0',
        //             l => '71389.0',
        //             v => '1.20407',
        //             n => 20
        //         }
        //     }
        //
        $data = $this->safe_dict($message, 'data', array());
        $base = $this->safe_string($data, 's');
        $symbol = $base . '/USDC:USDC';
        $timeframe = $this->safe_string($data, 'i');
        if (!(is_array($this->ohlcvs) && array_key_exists($symbol, $this->ohlcvs))) {
            $this->ohlcvs[$symbol] = array();
        }
        if (!(is_array($this->ohlcvs[$symbol]) && array_key_exists($timeframe, $this->ohlcvs[$symbol]))) {
            $limit = $this->safe_integer($this->options, 'OHLCVLimit', 1000);
            $stored = new ArrayCacheByTimestamp ($limit);
            $this->ohlcvs[$symbol][$timeframe] = $stored;
        }
        $ohlcv = $this->ohlcvs[$symbol][$timeframe];
        $parsed = $this->parse_ohlcv($data);
        $ohlcv->append ($parsed);
        $messageHash = 'candles:' . $timeframe . ':' . $symbol;
        $client->resolve ($ohlcv, $messageHash);
    }

    public function watch_orders(?string $symbol = null, ?int $since = null, ?int $limit = null, $params = array ()): PromiseInterface {
        return Async\async(function () use ($symbol, $since, $limit, $params) {
            /**
             * watches information on multiple $orders made by the user
             * @param {string} $symbol unified $market $symbol of the $market $orders were made in
             * @param {int} [$since] the earliest time in ms to fetch $orders for
             * @param {int} [$limit] the maximum number of order structures to retrieve
             * @param {array} [$params] extra parameters specific to the exchange API endpoint
             * @param {string} [$params->user] user address, will default to $this->walletAddress if not provided
             * @return {array[]} a list of [order structures]{@link https://docs.ccxt.com/#/?id=order-structure
             */
            Async\await($this->load_markets());
            $userAddress = null;
            list($userAddress, $params) = $this->handlePublicAddress ('watchOrders', $params);
            $market = null;
            $messageHash = 'order';
            if ($symbol !== null) {
                $market = $this->market($symbol);
                $symbol = $market['symbol'];
                $messageHash = $messageHash . ':' . $symbol;
            }
            $url = $this->urls['api']['ws']['public'];
            $request = array(
                'method' => 'subscribe',
                'subscription' => array(
                    'type' => 'orderUpdates',
                    'user' => $userAddress,
                ),
            );
            $message = array_merge($request, $params);
            $orders = Async\await($this->watch($url, $messageHash, $message, $messageHash));
            if ($this->newUpdates) {
                $limit = $orders->getLimit ($symbol, $limit);
            }
            return $this->filter_by_symbol_since_limit($orders, $symbol, $since, $limit, true);
        }) ();
    }

    public function handle_order(Client $client, $message) {
        //
        //     {
        //         channel => 'orderUpdates',
        //         $data => array(
        //             {
        //                 $order => array(
        //                     coin => 'BTC',
        //                     side => 'B',
        //                     limitPx => '30000.0',
        //                     sz => '0.001',
        //                     oid => 7456484275,
        //                     timestamp => 1710163596492,
        //                     origSz => '0.001'
        //                 ),
        //                 status => 'open',
        //                 statusTimestamp => 1710163596492
        //             }
        //         )
        //     }
        //
        $data = $this->safe_list($message, 'data', array());
        if ($this->orders === null) {
            $limit = $this->safe_integer($this->options, 'ordersLimit', 1000);
            $this->orders = new ArrayCacheBySymbolById ($limit);
        }
        $dataLength = count($data);
        if ($dataLength === 0) {
            return;
        }
        $stored = $this->orders;
        $messageHash = 'order';
        $marketSymbols = array();
        for ($i = 0; $i < count($data); $i++) {
            $rawOrder = $data[$i];
            $order = $this->parse_order($rawOrder);
            $stored->append ($order);
            $symbol = $this->safe_string($order, 'symbol');
            $marketSymbols[$symbol] = true;
        }
        $keys = is_array($marketSymbols) ? array_keys($marketSymbols) : array();
        for ($i = 0; $i < count($keys); $i++) {
            $symbol = $keys[$i];
            $innerMessageHash = $messageHash . ':' . $symbol;
            $client->resolve ($stored, $innerMessageHash);
        }
        $client->resolve ($stored, $messageHash);
    }

    public function handle_error_message(Client $client, $message) {
        //
        //     {
        //         "channel" => "error",
        //         "data" => "Error parsing JSON into valid websocket request => array( \"type\" => \"allMids\" )"
        //     }
        //
        $channel = $this->safe_string($message, 'channel', '');
        $ret_msg = $this->safe_string($message, 'data', '');
        if ($channel === 'error') {
            throw new ExchangeError($this->id . ' ' . $ret_msg);
        } else {
            return false;
        }
    }

    public function handle_message(Client $client, $message) {
        if ($this->handle_error_message($client, $message)) {
            return;
        }
        $topic = $this->safe_string($message, 'channel', '');
        $methods = array(
            'pong' => array($this, 'handle_pong'),
            'trades' => array($this, 'handle_trades'),
            'l2Book' => array($this, 'handle_order_book'),
            'candle' => array($this, 'handle_ohlcv'),
            'orderUpdates' => array($this, 'handle_order'),
            'userFills' => array($this, 'handle_my_trades'),
        );
        $exacMethod = $this->safe_value($methods, $topic);
        if ($exacMethod !== null) {
            $exacMethod($client, $message);
            return;
        }
        $keys = is_array($methods) ? array_keys($methods) : array();
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            if (mb_strpos($topic, $keys[$i]) !== false) {
                $method = $methods[$key];
                $method($client, $message);
                return;
            }
        }
    }

    public function ping($client) {
        return array(
            'method' => 'ping',
        );
    }

    public function handle_pong(Client $client, $message) {
        //
        //   {
        //       "channel" => "pong"
        //   }
        //
        $client->lastPong = $this->safe_integer($message, 'pong');
        return $message;
    }
}
