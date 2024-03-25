<?php
namespace ccxt;

// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

// -----------------------------------------------------------------------------
use \ccxt\Precise;
include_once PATH_TO_CCXT . '/test/base/test_shared_methods.php';

function test_market($exchange, $skipped_properties, $method, $market) {
    $format = array(
        'id' => 'btcusd',
        'symbol' => 'BTC/USD',
        'base' => 'BTC',
        'quote' => 'USD',
        'taker' => $exchange->parse_number('0.0011'),
        'maker' => $exchange->parse_number('0.0009'),
        'baseId' => 'btc',
        'quoteId' => 'usd',
        'active' => false,
        'type' => 'spot',
        'linear' => false,
        'inverse' => false,
        'spot' => false,
        'swap' => false,
        'future' => false,
        'option' => false,
        'margin' => false,
        'contract' => false,
        'contractSize' => $exchange->parse_number('0.001'),
        'expiry' => 1656057600000,
        'expiryDatetime' => '2022-06-24T08:00:00.000Z',
        'optionType' => 'put',
        'strike' => $exchange->parse_number('56000'),
        'settle' => 'XYZ',
        'settleId' => 'Xyz',
        'precision' => array(
            'price' => $exchange->parse_number('0.001'),
            'amount' => $exchange->parse_number('0.001'),
            'cost' => $exchange->parse_number('0.001'),
        ),
        'limits' => array(
            'amount' => array(
                'min' => $exchange->parse_number('0.01'),
                'max' => $exchange->parse_number('1000'),
            ),
            'price' => array(
                'min' => $exchange->parse_number('0.01'),
                'max' => $exchange->parse_number('1000'),
            ),
            'cost' => array(
                'min' => $exchange->parse_number('0.01'),
                'max' => $exchange->parse_number('1000'),
            ),
        ),
        'info' => array(),
    );
    $empty_allowed_for = ['linear', 'inverse', 'settle', 'settleId', 'expiry', 'expiryDatetime', 'optionType', 'strike', 'margin', 'contractSize'];
    assert_structure($exchange, $skipped_properties, $method, $market, $format, $empty_allowed_for);
    assert_symbol($exchange, $skipped_properties, $method, $market, 'symbol');
    $log_text = log_template($exchange, $method, $market);
    //
    $valid_types = ['spot', 'margin', 'swap', 'future', 'option', 'index'];
    assert_in_array($exchange, $skipped_properties, $method, $market, 'type', $valid_types);
    $has_index = (is_array($market) && array_key_exists('index', $market)); // todo: add in all
    // check if string is consistent with 'type'
    if ($market['spot']) {
        assert($market['type'] === 'spot', '\"type\" string should be \"spot\" when spot is true' . $log_text);
    } elseif ($market['swap']) {
        assert($market['type'] === 'swap', '\"type\" string should be \"swap\" when swap is true' . $log_text);
    } elseif ($market['future']) {
        assert($market['type'] === 'future', '\"type\" string should be \"future\" when future is true' . $log_text);
    } elseif ($market['option']) {
        assert($market['type'] === 'option', '\"type\" string should be \"option\" when option is true' . $log_text);
    } elseif ($has_index && $market['index']) {
        // todo: add index in all implementations
        assert($market['type'] === 'index', '\"type\" string should be \"index\" when index is true' . $log_text);
    }
    // margin check (todo: add margin as mandatory, instead of undefined)
    if ($market['spot']) {
        // for spot market, 'margin' can be either true/false or undefined
        assert_in_array($exchange, $skipped_properties, $method, $market, 'margin', [true, false, null]);
    } else {
        // otherwise, it must be false or undefined
        assert_in_array($exchange, $skipped_properties, $method, $market, 'margin', [false, null]);
    }
    if (!(is_array($skipped_properties) && array_key_exists('contractSize', $skipped_properties))) {
        assert_greater($exchange, $skipped_properties, $method, $market, 'contractSize', '0');
    }
    // typical values
    assert_greater($exchange, $skipped_properties, $method, $market, 'expiry', '0');
    assert_greater($exchange, $skipped_properties, $method, $market, 'strike', '0');
    assert_in_array($exchange, $skipped_properties, $method, $market, 'optionType', ['put', 'call']);
    assert_greater($exchange, $skipped_properties, $method, $market, 'taker', '-100');
    assert_greater($exchange, $skipped_properties, $method, $market, 'maker', '-100');
    // 'contract' boolean check
    if ($market['future'] || $market['swap'] || $market['option'] || ($has_index && $market['index'])) {
        // if it's some kind of contract market, then `conctract` should be true
        assert($market['contract'], '\"contract\" must be true when \"future\", \"swap\", \"option\" or \"index\" is true' . $log_text);
    } else {
        assert(!$market['contract'], '\"contract\" must be false when neither \"future\", \"swap\",\"option\" or \"index\" is true' . $log_text);
    }
    $is_swap_or_future = $market['swap'] || $market['future'];
    $contract_size = $exchange->safe_string($market, 'contractSize');
    // contract fields
    if ($market['contract']) {
        // linear & inverse should have different values (true/false)
        // todo: expand logic on other market types
        if ($is_swap_or_future) {
            assert($market['linear'] !== $market['inverse'], 'market linear and inverse must not be the same' . $log_text);
            if (!(is_array($skipped_properties) && array_key_exists('contractSize', $skipped_properties))) {
                // contract size should be defined
                assert($contract_size !== null, '\"contractSize\" must be defined when \"contract\" is true' . $log_text);
                // contract size should be above zero
                assert(Precise::string_gt($contract_size, '0'), '\"contractSize\" must be > 0 when \"contract\" is true' . $log_text);
            }
            if (!(is_array($skipped_properties) && array_key_exists('settle', $skipped_properties))) {
                // settle should be defined
                assert(($market['settle'] !== null) && ($market['settleId'] !== null), '\"settle\" & \"settleId\" must be defined when \"contract\" is true' . $log_text);
            }
        }
        // spot should be false
        assert(!$market['spot'], '\"spot\" must be false when \"contract\" is true' . $log_text);
    } else {
        // linear & inverse needs to be undefined
        assert(($market['linear'] === null) && ($market['inverse'] === null), 'market linear and inverse must be undefined when \"contract\" is false' . $log_text);
        // contract size should be undefined
        if (!(is_array($skipped_properties) && array_key_exists('contractSize', $skipped_properties))) {
            assert($contract_size === null, '\"contractSize\" must be undefined when \"contract\" is false' . $log_text);
        }
        // settle should be undefined
        assert(($market['settle'] === null) && ($market['settleId'] === null), '\"settle\" must be undefined when \"contract\" is false' . $log_text);
        // spot should be true
        assert($market['spot'], '\"spot\" must be true when \"contract\" is false' . $log_text);
    }
    // option fields
    if ($market['option']) {
        // if option, then strike and optionType should be defined
        assert($market['strike'] !== null, '\"strike\" must be defined when \"option\" is true' . $log_text);
        assert($market['optionType'] !== null, '\"optionType\" must be defined when \"option\" is true' . $log_text);
    } else {
        // if not option, then strike and optionType should be undefined
        assert($market['strike'] === null, '\"strike\" must be undefined when \"option\" is false' . $log_text);
        assert($market['optionType'] === null, '\"optionType\" must be undefined when \"option\" is false' . $log_text);
    }
    // future, swap and option should be mutually exclusive
    if ($market['future']) {
        assert(!$market['swap'] && !$market['option'], 'market swap and option must be false when \"future\" is true' . $log_text);
    } elseif ($market['swap']) {
        assert(!$market['future'] && !$market['option'], 'market future and option must be false when \"swap\" is true' . $log_text);
    } elseif ($market['option']) {
        assert(!$market['future'] && !$market['swap'], 'market future and swap must be false when \"option\" is true' . $log_text);
    }
    // expiry field
    if ($market['future'] || $market['option']) {
        // future or option markets need 'expiry' and 'expiryDatetime'
        assert($market['expiry'] !== null, '\"expiry\" must be defined when \"future\" is true' . $log_text);
        assert($market['expiryDatetime'] !== null, '\"expiryDatetime\" must be defined when \"future\" is true' . $log_text);
        // expiry datetime should be correct
        $iso_string = $exchange->iso8601($market['expiry']);
        assert($market['expiryDatetime'] === $iso_string, 'expiryDatetime (\"' . $market['expiryDatetime'] . '\") must be equal to expiry in iso8601 format \"' . $iso_string . '\"' . $log_text);
    } else {
        // otherwise, they need to be undefined
        assert(($market['expiry'] === null) && ($market['expiryDatetime'] === null), '\"expiry\" and \"expiryDatetime\" must be undefined when it is not future|option market' . $log_text);
    }
    // check precisions
    if (!(is_array($skipped_properties) && array_key_exists('precision', $skipped_properties))) {
        $precision_keys = is_array($market['precision']) ? array_keys($market['precision']) : array();
        $keys_length = count($precision_keys);
        assert($keys_length >= 2, 'precision should have \"amount\" and \"price\" keys at least' . $log_text);
        for ($i = 0; $i < count($precision_keys); $i++) {
            check_precision_accuracy($exchange, $skipped_properties, $method, $market['precision'], $precision_keys[$i]);
        }
    }
    // check limits
    if (!(is_array($skipped_properties) && array_key_exists('limits', $skipped_properties))) {
        $limits_keys = is_array($market['limits']) ? array_keys($market['limits']) : array();
        $keys_length = count($limits_keys);
        assert($keys_length >= 3, 'limits should have \"amount\", \"price\" and \"cost\" keys at least' . $log_text);
        for ($i = 0; $i < count($limits_keys); $i++) {
            $key = $limits_keys[$i];
            $limit_entry = $market['limits'][$key];
            // min >= 0
            assert_greater_or_equal($exchange, $skipped_properties, $method, $limit_entry, 'min', '0');
            // max >= 0
            assert_greater($exchange, $skipped_properties, $method, $limit_entry, 'max', '0');
            // max >= min
            $min_string = $exchange->safe_string($limit_entry, 'min');
            if ($min_string !== null) {
                assert_greater_or_equal($exchange, $skipped_properties, $method, $limit_entry, 'max', $min_string);
            }
        }
    }
    // check whether valid currency ID and CODE is used
    if (!(is_array($skipped_properties) && array_key_exists('currency', $skipped_properties)) && !(is_array($skipped_properties) && array_key_exists('currencyIdAndCode', $skipped_properties))) {
        assert_valid_currency_id_and_code($exchange, $skipped_properties, $method, $market, $market['baseId'], $market['base']);
        assert_valid_currency_id_and_code($exchange, $skipped_properties, $method, $market, $market['quoteId'], $market['quote']);
        assert_valid_currency_id_and_code($exchange, $skipped_properties, $method, $market, $market['settleId'], $market['settle']);
    }
    assert_timestamp($exchange, $skipped_properties, $method, $market, null, 'created');
}
