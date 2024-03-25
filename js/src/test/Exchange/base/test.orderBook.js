// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code
// EDIT THE CORRESPONDENT .ts FILE INSTEAD

import assert from 'assert';
import Precise from '../../../base/Precise.js';
import testSharedMethods from './test.sharedMethods.js';
function testOrderBook(exchange, skippedProperties, method, orderbook, symbol) {
    const format = {
        'symbol': 'ETH/BTC',
        'asks': [
            [exchange.parseNumber('1.24'), exchange.parseNumber('0.453')],
            [exchange.parseNumber('1.25'), exchange.parseNumber('0.157')],
        ],
        'bids': [
            [exchange.parseNumber('1.23'), exchange.parseNumber('0.123')],
            [exchange.parseNumber('1.22'), exchange.parseNumber('0.543')],
        ],
        'timestamp': 1504224000000,
        'datetime': '2017-09-01T00:00:00',
        'nonce': 134234234,
        // 'info': {},
    };
    const emptyAllowedFor = ['symbol', 'nonce', 'datetime', 'timestamp']; // todo: make timestamp required
    testSharedMethods.assertStructure(exchange, skippedProperties, method, orderbook, format, emptyAllowedFor);
    testSharedMethods.assertTimestampAndDatetime(exchange, skippedProperties, method, orderbook);
    testSharedMethods.assertSymbol(exchange, skippedProperties, method, orderbook, 'symbol', symbol);
    const logText = testSharedMethods.logTemplate(exchange, method, orderbook);
    //
    if (('bid' in skippedProperties) || ('ask' in skippedProperties)) {
        return;
    }
    // todo: check non-emtpy arrays for bids/asks for toptier exchanges
    const bids = orderbook['bids'];
    const bidsLength = bids.length;
    for (let i = 0; i < bidsLength; i++) {
        const currentBidString = exchange.safeString(bids[i], 0);
        const nextI = i + 1;
        if (bidsLength > nextI) {
            const nextBidString = exchange.safeString(bids[nextI], 0);
            const hasCorrectOrder = Precise.stringGt(currentBidString, nextBidString);
            assert(hasCorrectOrder, 'current bid should be > than the next one: ' + currentBidString + '>' + nextBidString + logText);
        }
        testSharedMethods.assertGreater(exchange, skippedProperties, method, bids[i], 0, '0');
        testSharedMethods.assertGreater(exchange, skippedProperties, method, bids[i], 1, '0');
    }
    const asks = orderbook['asks'];
    const asksLength = asks.length;
    for (let i = 0; i < asksLength; i++) {
        const currentAskString = exchange.safeString(asks[i], 0);
        const nextI = i + 1;
        if (asksLength > nextI) {
            const nextAskString = exchange.safeString(asks[nextI], 0);
            const hasCorrectOrder = Precise.stringLt(currentAskString, nextAskString);
            assert(hasCorrectOrder, 'current ask should be < than the next one: ' + currentAskString + '<' + nextAskString + logText);
        }
        testSharedMethods.assertGreater(exchange, skippedProperties, method, asks[i], 0, '0');
        testSharedMethods.assertGreater(exchange, skippedProperties, method, asks[i], 1, '0');
    }
    if (!('spread' in skippedProperties)) {
        if (bidsLength && asksLength) {
            const firstBid = exchange.safeString(bids[0], 0);
            const firstAsk = exchange.safeString(asks[0], 0);
            // check bid-ask spread
            assert(Precise.stringLt(firstBid, firstAsk), 'bids[0][0] (' + firstAsk + ') should be < than asks[0][0] (' + firstAsk + ')' + logText);
        }
    }
}
export default testOrderBook;
