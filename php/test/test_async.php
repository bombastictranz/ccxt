<?php
namespace ccxt;

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('UTC');

include_once 'vendor/autoload.php';

function dump(...$s) {
    $args = array_map(function ($arg) {
        if (is_array($arg) || is_object($arg)) {
            return json_encode($arg);
        } else {
            return $arg;
        }
    }, func_get_args());
    echo implode(' ', $args) . "\n";
}

ini_set('memory_limit', '512M');

$exchanges = null;

// $shortopts = '';
// $longopts = array (
//     "nonce::", // '::' means optional, ':' means required
// );

// $options = getopt ($shortopts, $longopts);
// var_dump ($options);
// exit ();

# first we filter the args
$verbose = in_array('--verbose', $argv);
$args = $argv;

$exchangeSymbol = $nonPrefixedArgs[3] ?? null;
define ('exchangeSymbol', $nonPrefixedArgs[3] ?? null);
define ('sandbox', in_array('--sandbox', $args));
define ('privateTest', in_array('--private', $args));
define ('privateOnly', in_array('--privateOnly', $args));

define ('is_sync', stripos(__FILE__, '_async') === false);

//-----------------------------------------------------------------------------
foreach (Exchange::$exchanges as $id) {
    if (in_array($id, $args)) {
        $exchangeName = '\\ccxt\\async\\' . $id;
        $selected_exchange = new $exchangeName();
                            // httpsAgent,
                            // verbose,
                            // enableRateLimit,
                            // debug,
                            // timeout,
    }
}

if (!$selected_exchange) {
    throw new \Exception('No exchange specified');
}

function snake_case ($methodName) {
    return strtolower(preg_replace('/(?<!^)(?=[A-Z])/', '_', $methodName));
}
function method_namer_in_test($methodName) {
    $snake_cased = snake_case($methodName);
    $snake_cased = str_replace('o_h_l_c_v', 'ohlcv', $snake_cased);
    return 'test_' . $snake_cased;
}
define('targetDir', __DIR__ . '/../../');

foreach (glob(__DIR__ . '/test_*.php') as $filename) {
    if (strpos($filename, 'test_async') === false && strpos($filename, 'test_sync') === false && strpos($filename, 'datetime_functions') === false) {
        if (
            (is_sync && stripos($filename, '_async') === false) 
                ||
            (!is_sync && stripos($filename, '_async') !== false)
        ){
            include_once $filename;
        }
    }
}

$allfuncs = get_defined_functions()['user'];
$testFuncs = [];
foreach ($allfuncs as $fName) {
    if (stripos($fName, 'ccxt\\test_')!==false) {
        $nameWithoutNs = str_replace('ccxt\\', '', $fName);
        $testFuncs[$nameWithoutNs] = $fName;
        
    }
}
define('testFiles', $testFuncs);
define('envVars', []);


// non-transpiled commons
class emptyClass {}

function io_file_exists($path) {
    return file_exists($path);
}

function io_file_read($path, $decode = true) {
    $content = file_get_contents($path);
    return $decode ? json_decode($content, true) : $content;
}

function call_method($methodName, $exchange, $args) {
    return testFiles[$methodName]($exchange, ... $args);
}

function exception_message ($exc) {
    return '[' . get_class($exc) . '] ' . substr($exc->getMessage(), 0, 200);
}

function add_proxy_agent ($exchange, $settings) {
    // placeholder function in php
}

function exit_script() {
    exit();
}

function reqCredentials ($exchange) {
    return $exchange->requiredCredenials;
}

function get_exchange_prop ($exchange, $prop, $defaultValue = null) {
    return property_exists ($exchange, $prop) ? $exchange->{$prop} : $defaultValue;
}

function set_exchange_prop ($exchange, $prop, $value) {
    $exchange->{$prop} = $value;
}
// #############################
// ### AUTO-TRANSPILER-START ###


// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import
use React\Async;
use React\Promise;

class testMainClass extends emptyClass {

    public function init($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            $this->expand_settings($exchange, $symbol);
            Async\await($this->start_test($exchange, $symbol));
        }) ();
    }

    public function expand_settings($exchange, $symbol) {
        $exchangeId = $exchange->id;
        $keysGlobal = targetDir . 'keys.json';
        $keysLocal = targetDir . 'keys.local.json';
        $fileExists = io_file_exists ($keysLocal);
        $keysFile = $fileExists ? $keysLocal : $keysGlobal;
        $allSettings = io_file_read ($keysFile);
        $exchangeSettings = $exchange->safe_value($allSettings, $exchangeId, array());
        if ($exchangeSettings) {
            $settingKeys = is_array($exchangeSettings) ? array_keys($exchangeSettings) : array();
            for ($i = 0; $i < count($settingKeys); $i++) {
                $key = $settingKeys[$i];
                if ($exchangeSettings[$key]) {
                    $existing = get_exchange_prop ($exchange, $key, array());
                    set_exchange_prop ($exchange, $key, $exchange->deep_extend($existing, $exchangeSettings[$key]));
                }
            }
        }
        // credentials
        $reqCreds = get_exchange_prop ($exchange, 're' . 'quiredCredentials'); // dont glue the r-e-q-u-$i-r-e phrase, because leads to messed up transpilation
        $objkeys = is_array($reqCreds) ? array_keys($reqCreds) : array();
        for ($i = 0; $i < count($objkeys); $i++) {
            $credential = $objkeys[$i];
            $isRequired = $reqCreds[$credential];
            if ($isRequired && get_exchange_prop($exchange, $credential) === null) {
                $fullKey = $exchangeId . '_' . $credential;
                $credentialEnvName = strtoupper($fullKey); // example => KRAKEN_APIKEY
                $credentialValue = envVars[$credentialEnvName];
                if ($credentialValue) {
                    set_exchange_prop ($exchange, $credential, $credentialValue);
                }
            }
        }
        // others
        if ($exchangeSettings && $exchange->safe_value($exchangeSettings, 'skip')) {
            dump ('[Skipped]', 'exchange', $exchangeId, 'symbol', $symbol);
            exit_script();
        }
        if ($exchange->alias) {
            dump ('[Skipped] Alias $exchange-> ', 'exchange', $exchangeId, 'symbol', $symbol);
            exit_script();
        }
        add_proxy_agent ($exchange, $exchangeSettings);
    }

    public function test_method($methodName, $exchange, $args) {
        return Async\async(function () use ($methodName, $exchange, $args) {
            $methodNameInTest = method_namer_in_test ($methodName);
            $skipMessage = null;
            if (($methodName !== 'loadMarkets') && (!(is_array($exchange->has) && array_key_exists($methodName, $exchange->has)) || !$exchange->has[$methodName])) {
                $skipMessage = 'not supported';
            } elseif (!(is_array(testFiles) && array_key_exists($methodNameInTest, testFiles))) {
                $skipMessage = 'test not available';
            }
            if ($skipMessage) {
                dump ('[Skipping]', $exchange->id, $methodNameInTest, ' - ' . $skipMessage);
                return;
            }
            $argsStringified = '(' . implode(',', $args) . ')';
            dump ('[Testing]', $exchange->id, $methodNameInTest, $argsStringified);
            try {
                return Async\await(call_method ($methodNameInTest, $exchange, $args));
            } catch (Exception $e) {
                dump (exception_message($e), ' | Exception from => ', $exchange->id, $methodNameInTest, $argsStringified);
                throw $e;
            }
        }) ();
    }

    public function test_safe($methodName, $exchange, $args) {
        return Async\async(function () use ($methodName, $exchange, $args) {
            try {
                Async\await($this->test_method($methodName, $exchange, $args));
                return true;
            } catch (Exception $e) {
                return false;
            }
        }) ();
    }

    public function run_public_tests($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            $tests = array(
                'loadMarkets' => array(),
                'fetchCurrencies' => array(),
                'fetchTicker' => [$symbol],
                'fetchTickers' => [$symbol],
                'fetchOHLCV' => [$symbol],
                'fetchTrades' => [$symbol],
                'fetchOrderBook' => [$symbol],
                'fetchL2OrderBook' => [$symbol],
                'fetchOrderBooks' => array(),
                'fetchBidsAsks' => array(),
                'fetchStatus' => array(),
                'fetchTime' => array(),
            );
            $market = $exchange->market ($symbol);
            $isSpot = $market['spot'];
            if ($isSpot) {
                $tests['fetchCurrencies'] = array();
            } else {
                $tests['fetchFundingRates'] = [$symbol];
                $tests['fetchFundingRate'] = [$symbol];
                $tests['fetchFundingRateHistory'] = [$symbol];
                $tests['fetchIndexOHLCV'] = [$symbol];
                $tests['fetchMarkOHLCV'] = [$symbol];
                $tests['fetchPremiumIndexOHLCV'] = [$symbol];
            }
            $testNames = is_array($tests) ? array_keys($tests) : array();
            $promises = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $testArgs = $tests[$testName];
                $promises[] = $this->test_safe($testName, $exchange, $testArgs);
            }
            Async\await(Promise\all($promises));
        }) ();
    }

    public function load_exchange($exchange) {
        return Async\async(function () use ($exchange) {
            $markets = Async\await($exchange->load_markets());
            assert (gettype($exchange->markets) === 'array', '.markets is not an object');
            assert (gettype($exchange->symbols) === 'array' && array_keys($exchange->symbols) === array_keys(array_keys($exchange->symbols)), '.symbols is not an array');
            $symbolsLength = count($exchange->symbols);
            $marketKeys = is_array($exchange->markets) ? array_keys($exchange->markets) : array();
            $marketKeysLength = count($marketKeys);
            assert ($symbolsLength > 0, '.symbols count <= 0 (less than or equal to zero)');
            assert ($marketKeysLength > 0, '.markets objects keys length <= 0 (less than or equal to zero)');
            assert ($symbolsLength === $marketKeysLength, 'number of .symbols is not equal to the number of .markets');
            $symbols = array(
                'BTC/CNY',
                'BTC/USD',
                'BTC/USDT',
                'BTC/EUR',
                'BTC/ETH',
                'ETH/BTC',
                'BTC/JPY',
                'ETH/EUR',
                'ETH/JPY',
                'ETH/CNY',
                'ETH/USD',
                'LTC/CNY',
                'DASH/BTC',
                'DOGE/BTC',
                'BTC/AUD',
                'BTC/PLN',
                'USD/SLL',
                'BTC/RUB',
                'BTC/UAH',
                'LTC/BTC',
                'EUR/USD',
            );
            $resultSymbols = array();
            $exchangeSpecificSymbols = $exchange->symbols;
            for ($i = 0; $i < count($exchangeSpecificSymbols); $i++) {
                $symbol = $exchangeSpecificSymbols[$i];
                if ($exchange->inArray($symbol, $symbols)) {
                    $resultSymbols[] = $symbol;
                }
            }
            $resultMsg = '';
            $resultLength = count($resultSymbols);
            $exchangeSymbolsLength = count($exchange->symbols);
            if ($resultLength > 0) {
                if ($exchangeSymbolsLength > $resultLength) {
                    $resultMsg = implode(', ', $resultSymbols) . ' . more...';
                } else {
                    $resultMsg = implode(', ', $resultSymbols);
                }
            }
            dump ('Exchange loaded', $exchangeSymbolsLength, 'symbols', $resultMsg);
        }) ();
    }

    public function get_test_symbol($exchange, $symbols) {
        $symbol = null;
        for ($i = 0; $i < count($symbols); $i++) {
            $s = $symbols[$i];
            $market = $exchange->safe_value($exchange->markets, $s);
            if ($market !== null) {
                $active = $exchange->safe_value($market, 'active');
                if ($active || ($active === null)) {
                    $symbol = $s;
                    break;
                }
            }
        }
        return $symbol;
    }

    public function get_exchange_code($exchange, $codes = null) {
        if ($codes === null) {
            $codes = ['BTC', 'ETH', 'XRP', 'LTC', 'BCH', 'EOS', 'BNB', 'BSV', 'USDT'];
        }
        $code = $codes[0];
        for ($i = 0; $i < count($codes); $i++) {
            if (is_array($exchange->currencies) && array_key_exists($codes[$i], $exchange->currencies)) {
                return $codes[$i];
            }
        }
        return $code;
    }

    public function get_symbols_from_exchange($exchange, $spot = true) {
        $res = array();
        $markets = $exchange->markets;
        $keys = is_array($markets) ? array_keys($markets) : array();
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            $market = $markets[$key];
            if ($spot && $market['spot']) {
                $res[] = $key;
            } elseif (!$spot && !$market['spot']) {
                $res[] = $key;
            }
        }
        return $res;
    }

    public function get_valid_symbol($exchange, $spot = true) {
        $codes = array(
            'BTC',
            'ETH',
            'XRP',
            'LTC',
            'BCH',
            'EOS',
            'BNB',
            'BSV',
            'USDT',
            'ATOM',
            'BAT',
            'BTG',
            'DASH',
            'DOGE',
            'ETC',
            'IOTA',
            'LSK',
            'MKR',
            'NEO',
            'PAX',
            'QTUM',
            'TRX',
            'TUSD',
            'USD',
            'USDC',
            'WAVES',
            'XEM',
            'XMR',
            'ZEC',
            'ZRX',
        );
        $spotSymbols = array(
            'BTC/USD',
            'BTC/USDT',
            'BTC/CNY',
            'BTC/EUR',
            'BTC/ETH',
            'ETH/BTC',
            'ETH/USD',
            'ETH/USDT',
            'BTC/JPY',
            'LTC/BTC',
            'ZRX/WETH',
            'EUR/USD',
        );
        $swapSymbols = array(
            'BTC/USDT:USDT',
            'BTC/USD:USD',
            'ETH/USDT:USDT',
            'ETH/USD:USD',
            'LTC/USDT:USDT',
            'DOGE/USDT:USDT',
            'ADA/USDT:USDT',
            'BTC/USD:BTC',
            'ETH/USD:ETH',
        );
        $targetSymbols = $spot ? $spotSymbols : $swapSymbols;
        $symbol = $this->get_test_symbol($exchange, $targetSymbols);
        $exchangeMarkets = $this->get_symbols_from_exchange($exchange, $spot);
        // if symbols wasn't found from above hardcoded list, then try to locate any $symbol which has our target hardcoded 'base' code
        if ($symbol === null) {
            for ($i = 0; $i < count($codes); $i++) {
                $currentCode = $codes[$i];
                $marketsForCurrentCode = $exchange->filter_by($exchangeMarkets, 'base', $currentCode);
                $symbolsForCurrentCode = is_array($marketsForCurrentCode) ? array_keys($marketsForCurrentCode) : array();
                if (strlen($symbolsForCurrentCode)) {
                    $symbol = $this->get_test_symbol($exchange, $symbolsForCurrentCode);
                    break;
                }
            }
        }
        // if there wasn't found any $symbol with our hardcoded 'base' code, then just try to find symbols that are 'active'
        if ($symbol === null) {
            $activeMarkets = $exchange->filter_by($exchangeMarkets, 'active', true);
            $activeSymbols = is_array($activeMarkets) ? array_keys($activeMarkets) : array();
            $symbol = $this->get_test_symbol($exchange, $activeSymbols);
        }
        if ($symbol === null) {
            $first = $exchangeMarkets[0];
            if ($first !== null) {
                $symbol = $first['symbol'];
            }
        }
        return $symbol;
    }

    public function test_exchange($exchange, $providedSymbol = null) {
        return Async\async(function () use ($exchange, $providedSymbol) {
            $spotSymbol = null;
            $swapSymbol = null;
            if ($providedSymbol !== null) {
                $market = $exchange->market($providedSymbol);
                if ($market['spot']) {
                    $spotSymbol = $providedSymbol;
                } else {
                    $swapSymbol = $providedSymbol;
                }
            } else {
                $spotSymbol = $this->get_valid_symbol($exchange, true);
                $swapSymbol = $this->get_valid_symbol($exchange, false);
            }
            if ($spotSymbol !== null) {
                dump ('Selected SPOT SYMBOL:', $spotSymbol);
            }
            if ($swapSymbol !== null) {
                dump ('Selected SWAP SYMBOL:', $swapSymbol);
            }
            if (!privateOnly) {
                if ($exchange->has['spot'] && $spotSymbol !== null) {
                    $exchange->options['type'] = 'spot';
                    Async\await($this->run_public_tests($exchange, $spotSymbol));
                }
                if ($exchange->has['swap'] && $swapSymbol !== null) {
                    $exchange->options['type'] = 'swap';
                    Async\await($this->run_public_tests($exchange, $swapSymbol));
                }
            }
            if (privateTest || privateOnly) {
                if ($exchange->has['spot'] && $spotSymbol !== null) {
                    $exchange->options['defaultType'] = 'spot';
                    Async\await($this->run_private_tests($exchange, $spotSymbol));
                }
                if ($exchange->has['swap'] && $swapSymbol !== null) {
                    $exchange->options['defaultType'] = 'swap';
                    Async\await($this->run_private_tests($exchange, $swapSymbol));
                }
            }
        }) ();
    }

    public function run_private_tests($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            if (!$exchange->check_required_credentials(false)) {
                dump ('[Skipped]', 'Keys not found, skipping private tests');
                return;
            }
            $code = $this->get_exchange_code($exchange);
            // if ($exchange->extendedTest) {
            //     Async\await(test ('InvalidNonce', $exchange, $symbol));
            //     Async\await(test ('OrderNotFound', $exchange, $symbol));
            //     Async\await(test ('InvalidOrder', $exchange, $symbol));
            //     Async\await(test ('InsufficientFunds', $exchange, $symbol, balance)); // danger zone - won't execute with non-empty balance
            // }
            $tests = array(
                'signIn' => [$exchange],
                'fetchBalance' => [$exchange],
                'fetchAccounts' => [$exchange],
                'fetchTransactionFees' => [$exchange],
                'fetchTradingFees' => [$exchange],
                'fetchStatus' => [$exchange],
                'fetchOrders' => [$exchange, $symbol],
                'fetchOpenOrders' => [$exchange, $symbol],
                'fetchClosedOrders' => [$exchange, $symbol],
                'fetchMyTrades' => [$exchange, $symbol],
                'fetchLeverageTiers' => [$exchange, $symbol],
                'fetchLedger' => [$exchange, $code],
                'fetchTransactions' => [$exchange, $code],
                'fetchDeposits' => [$exchange, $code],
                'fetchWithdrawals' => [$exchange, $code],
                'fetchBorrowRates' => [$exchange, $code],
                'fetchBorrowRate' => [$exchange, $code],
                'fetchBorrowInterest' => [$exchange, $code, $symbol],
                'addMargin' => [$exchange, $symbol],
                'reduceMargin' => [$exchange, $symbol],
                'setMargin' => [$exchange, $symbol],
                'setMarginMode' => [$exchange, $symbol],
                'setLeverage' => [$exchange, $symbol],
                'cancelAllOrders' => [$exchange, $symbol],
                'cancelOrder' => [$exchange, $symbol],
                'cancelOrders' => [$exchange, $symbol],
                'fetchCanceledOrders' => [$exchange, $symbol],
                'fetchClosedOrder' => [$exchange, $symbol],
                'fetchOpenOrder' => [$exchange, $symbol],
                'fetchOrder' => [$exchange, $symbol],
                'fetchOrderTrades' => [$exchange, $symbol],
                'fetchPosition' => [$exchange, $symbol],
                'fetchDeposit' => [$exchange, $code],
                'createDepositAddress' => [$exchange, $code],
                'fetchDepositAddress' => [$exchange, $code],
                'fetchDepositAddresses' => [$exchange, $code],
                'fetchDepositAddressesByNetwork' => [$exchange, $code],
                'editOrder' => [$exchange, $symbol],
                'fetchBorrowRateHistory' => [$exchange, $symbol],
                'fetchBorrowRatesPerSymbol' => [$exchange, $symbol],
                'fetchLedgerEntry' => [$exchange, $code],
                'fetchWithdrawal' => [$exchange, $code],
                'transfer' => [$exchange, $code],
                'withdraw' => [$exchange, $code],
            );
            $market = $exchange->market ($symbol);
            $isSpot = $market['spot'];
            if ($isSpot) {
                $tests['fetchCurrencies'] = [$exchange, $symbol];
            } else {
                // derivatives only
                $tests['fetchPositions'] = [$exchange, [$symbol]];
                $tests['fetchPosition'] = [$exchange, $symbol];
                $tests['fetchPositionRisk'] = [$exchange, $symbol];
                $tests['setPositionMode'] = [$exchange, $symbol];
                $tests['setMarginMode'] = [$exchange, $symbol];
                $tests['fetchOpenInterestHistory'] = [$exchange, $symbol];
                $tests['fetchFundingRateHistory'] = [$exchange, $symbol];
                $tests['fetchFundingHistory'] = [$exchange, $symbol];
            }
            $testNames = is_array($tests) ? array_keys($tests) : array();
            $promises = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $testArgs = $tests[$testName];
                $promises[] = $this->test_safe($testName, $exchange, $testArgs);
            }
            $results = Async\await(Promise\all($promises));
            $errors = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $success = $results[$i];
                if (!$success) {
                    $errors[] = $testName;
                }
            }
            if (strlen($errors) > 0) {
                throw new \Exception('Failed private $tests [' . $market['type'] . '] => ' . implode(', ', $errors));
            }
        }) ();
    }

    public function start_test($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            // we don't need to test aliases
            if ($exchange->alias) {
                return;
            }
            if (sandbox || get_exchange_prop ($exchange, 'sandbox')) {
                $exchange->set_sandbox_mode(true);
            }
            Async\await($this->load_exchange($exchange));
            Async\await($this->test_exchange($exchange, $symbol));
        }) ();
    }
}

// ### AUTO-TRANSPILER-END ###
// ###########################
$promise = (new testMainClass())->init($selected_exchange, $exchangeSymbol); // Async\coroutine(
//Async\await($promise);