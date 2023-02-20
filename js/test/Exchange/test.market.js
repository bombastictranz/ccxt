'use strict'

const assert = require ('assert');
const testCommonItems = require ('./test.commonItems.js');

function testMarket (exchange, market, method) {
    const method = 'testMarket';
    const format = {
        'id': 'btcusd', // string literal for referencing within an exchange
        'symbol': 'BTC/USD', // uppercase string literal of a pair of currencies
        'base': 'BTC', // unified uppercase string, base currency, 3 or more letters
        'quote': 'USD', // unified uppercase string, quote currency, 3 or more letters
        'taker': exchange.parseNumber ('0.0011'), // taker fee, for example, 0.0011 = 0.11%
        'maker': exchange.parseNumber ('0.0009'), // maker fee, for example, 0.0009 = 0.09%
        'baseId': 'btc', // exchange-specific base currency id
        'quoteId': 'usd', // exchange-specific quote currency id
        'active': true, // boolean, market status
        'type': 'spot',
        'linear': undefined,
        'inverse': undefined,
        'spot': true,
        'swap': false,
        'future': false,
        'option': false,
        'margin': false,
        'contract': false,
        'contractSize': exchange.parseNumber ('0.001'),
        'expiry': 1656057600000,
        'expiryDatetime': '2022-06-24T08:00:00.000Z',
        'optionType': 'put',
        'strike': exchange.parseNumber ('56000'),
        'settle': undefined,
        'settleId': undefined,
        'precision': {
            // todo : handle precision types after another PR is merged
            'price': exchange.parseNumber ('8'), // integer or fraction
            'amount': exchange.parseNumber ('8'), // integer or fraction
            'cost': exchange.parseNumber ('8'), // integer or fraction
        },
        // value limits when placing orders on this market
        'limits': {
            'amount': {
                'min': exchange.parseNumber ('0.01'), // order amount should be > min
                'max': exchange.parseNumber ('1000'), // order amount should be < max
            },
            'price': {
                'min': exchange.parseNumber ('0.01'), // order price should be > min
                'max': exchange.parseNumber ('1000'), // order price should be < max
            },
            // order cost = price * amount
            'cost': {
                'min': exchange.parseNumber ('0.01'), // order cost should be > min
                'max': exchange.parseNumber ('1000'), // order cost should be < max
            },
        },
        'info': {}, // the original unparsed market info from the exchange
    };
    const emptyNotAllowedFor = [ 'id', 'symbol', 'base', 'quote', 'baseId', 'quoteId', 'type', 'spot', 'swap', 'future', 'contract', 'precision', 'limits', 'info' ];
    testCommonItems.testStructureKeys (exchange, method, market, format, emptyNotAllowedFor);
    const logText = testCommonItems.logTemplate (exchange, method, market);
    //
    testCommonItems.Gt (exchange, method, market, 'contractSize', '0');
    testCommonItems.Ge (exchange, method, market, 'expiry', '0');
    testCommonItems.Ge (exchange, method, market, 'strike', '0');
    if (market['expiry'] !== undefined) {
        assert (market['expiryDatetime'] === exchange.iso8601 (market['expiry']), 'expiryDatetime must be equal to expiry in iso8601 format' + logText);
    }
    testCommonItems.checkAgainstArray (exchange, method, market, 'type', [ 'spot', 'margin', 'swap', 'future', 'option' ]);
    testCommonItems.checkAgainstArray (exchange, method, market, 'optionType', [ 'put', 'call' ]);
    // todo: handle str/num types later
    // assert ((market['taker'] === undefined) || (typeof market['taker'] === 'number'));
    // assert ((market['maker'] === undefined) || (typeof market['maker'] === 'number'));
    if (market['contract']) {
        assert (market['linear'] !== market['inverse'], 'market linear and inverse must not be the same' + logText);
    } else {
        assert ((market['linear'] === undefined) && (market['inverse'] === undefined), 'market linear and inverse must be undefined when "contract" is true' + logText);
    }
    if (market['option']) {
        assert (market['strike'] !== undefined, '"strike" must be defined when "option" is true' + logText);
        assert (market['optionType'] !== undefined, '"optionType" must be defined when "option" is true' + logText);
    }
    const types = Object.keys (validTypes);
    for (let i = 0; i < types.length; i++) {
        const entry = types[i];
        if (entry in market) {
            const value = market[entry];
            assert ((value === undefined) || value || !value);
        }
    }
    //
    // todo fix binance
    //
    // if (market['future']) {
    //     assert ((market['swap'] === false) && (market['option'] === false));
    // } else if (market['swap']) {
    //     assert ((market['future'] === false) && (market['option'] === false));
    // } else if (market['option']) {
    //     assert ((market['future'] === false) && (market['swap'] === false));
    // }
    // if (market['linear']) {
    //     assert (market['inverse'] === false);
    // } else if (market['inverse']) {
    //     assert (market['linear'] === false);
    // }
    // if (market['future']) {
    //     assert (market['expiry'] !== undefined);
    //     assert (market['expiryDatetime'] !== undefined);
    // }
}

module.exports = testMarket;
