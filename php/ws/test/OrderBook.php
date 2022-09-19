<?php
namespace ccxtpro;
include_once __DIR__ . '/../../../vendor/autoload.php';
// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

// -----------------------------------------------------------------------------

function equals($a, $b) {
    return json_encode($a) === json_encode($b);
}

// --------------------------------------------------------------------------------------------------------------------

$orderBookInput = array(
    'bids' => array( array( 10.0, 10 ), array( 9.1, 11 ), array( 8.2, 12 ), array( 7.3, 13 ), array( 6.4, 14 ), array( 4.5, 13 ), array( 4.5, 0 ) ),
    'asks' => array( array( 16.6, 10 ), array( 15.5, 11 ), array( 14.4, 12 ), array( 13.3, 13 ), array( 12.2, 14 ), array( 11.1, 13 ) ),
    'timestamp' => 1574827239000,
    'nonce' => 69,
    'symbol' => null,
);

$orderBookTarget = array(
    'bids' => array( array( 10.0, 10 ), array( 9.1, 11 ), array( 8.2, 12 ), array( 7.3, 13 ), array( 6.4, 14 ) ),
    'asks' => array( array( 11.1, 13 ), array( 12.2, 14 ), array( 13.3, 13 ), array( 14.4, 12 ), array( 15.5, 11 ), array( 16.6, 10 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$storeBid = array(
    'bids' => array( array( 10.0, 10 ), array( 9.1, 11 ), array( 8.2, 12 ), array( 7.3, 13 ), array( 6.4, 14 ), array( 3, 4 ) ),
    'asks' => array( array( 11.1, 13 ), array( 12.2, 14 ), array( 13.3, 13 ), array( 14.4, 12 ), array( 15.5, 11 ), array( 16.6, 10 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10 ), array( 9.1, 11 ), array( 8.2, 12 ), array( 7.3, 13 ), array( 6.4, 14 ) ),
    'asks' => array( array( 11.1, 13 ), array( 12.2, 14 ), array( 13.3, 13 ), array( 14.4, 12 ), array( 15.5, 11 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedDeletedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10 ), array( 9.1, 11 ), array( 8.2, 12 ), array( 7.3, 13 ), array( 6.4, 14 ) ),
    'asks' => array( array( 11.1, 13 ), array( 12.2, 14 ), array( 13.3, 13 ), array( 14.4, 12 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$indexedOrderBookInput = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 16.6, 10, '1240' ), array( 15.5, 11, '1241' ), array( 14.4, 12, '1242' ), array( 13.3, 13, '1243' ), array( 12.2, 14, '1244' ), array( 11.1, 13, '1244' ) ),
    'timestamp' => 1574827239000,
    'nonce' => 69,
    'symbol' => null,
);

$indexedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 13, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedIndexedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ) ),
    'asks' => array( array( 11.1, 13, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$incrementalIndexedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 27, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$incrementalIndexedOrderBookDeletedTarget = array(
    'bids' => array( array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 27, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedIncrementalIndexedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ) ),
    'asks' => array( array( 11.1, 27, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$storedIncrementalIndexedOrderBookTarget = array(
    'bids' => array( array( 10.0, 13, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 27, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$anotherStoredIncrementalIndexedOrderBookTarget = array(
    'bids' => array( array( 10.2, 13, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 27, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$overwrite1234 = array(
    'bids' => array( array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 11.1, 13, '1244' ), array( 13.3, 13, '1243' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$overwrite1244 = array(
    'bids' => array( array( 10.0, 10, '1234' ), array( 9.1, 11, '1235' ), array( 8.2, 12, '1236' ), array( 7.3, 13, '1237' ), array( 6.4, 14, '1238' ), array( 4.5, 13, '1239' ) ),
    'asks' => array( array( 13.3, 13, '1243' ), array( 13.5, 13, '1244' ), array( 14.4, 12, '1242' ), array( 15.5, 11, '1241' ), array( 16.6, 10, '1240' ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$countedOrderBookInput = array(
    'bids' => array( array( 10.0, 10, 1 ), array( 9.1, 11, 1 ), array( 8.2, 12, 1 ), array( 7.3, 13, 1 ), array( 7.3, 0, 1 ), array( 6.4, 14, 5 ), array( 4.5, 13, 5 ), array( 4.5, 13, 1 ), array( 4.5, 13, 0 ) ),
    'asks' => array( array( 16.6, 10, 1 ), array( 15.5, 11, 1 ), array( 14.4, 12, 1 ), array( 13.3, 13, 3 ), array( 12.2, 14, 3 ), array( 11.1, 13, 3 ), array( 11.1, 13, 12 ) ),
    'timestamp' => 1574827239000,
    'nonce' => 69,
    'symbol' => null,
);

$countedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, 1 ), array( 9.1, 11, 1 ), array( 8.2, 12, 1 ), array( 6.4, 14, 5 ) ),
    'asks' => array( array( 11.1, 13, 12 ), array( 12.2, 14, 3 ), array( 13.3, 13, 3 ), array( 14.4, 12, 1 ), array( 15.5, 11, 1 ), array( 16.6, 10, 1 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$storedCountedOrderbookTarget = array(
    'bids' => array( array( 10.0, 10, 1 ), array( 9.1, 11, 1 ), array( 8.2, 12, 1 ), array( 6.4, 14, 5 ), array( 1, 1, 6 ) ),
    'asks' => array( array( 11.1, 13, 12 ), array( 12.2, 14, 3 ), array( 13.3, 13, 3 ), array( 14.4, 12, 1 ), array( 15.5, 11, 1 ), array( 16.6, 10, 1 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedCountedOrderBookTarget = array(
    'bids' => array( array( 10.0, 10, 1 ), array( 9.1, 11, 1 ), array( 8.2, 12, 1 ), array( 6.4, 14, 5 ) ),
    'asks' => array( array( 11.1, 13, 12 ), array( 12.2, 14, 3 ), array( 13.3, 13, 3 ), array( 14.4, 12, 1 ), array( 15.5, 11, 1 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$incrementalOrderBookInput = array(
    'bids' => array( array( 10.0, 1 ), array( 10.0, 2 ), array( 9.1, 0 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ) ),
    'asks' => array( array( 11.1, 5 ), array( 11.1, -6 ), array( 11.1, 2 ), array( 12.2, 10 ), array( 12.2, -9.875 ), array( 12.2, 0 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 15.5, 1 ), array( 16.6, 3 ) ),
    'timestamp' => 1574827239000,
    'nonce' => 69,
    'symbol' => null,
);

$incremetalOrderBookTarget = array(
    'bids' => array( array( 10.0, 3 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ) ),
    'asks' => array( array( 11.1, 2 ), array( 12.2, 0.125 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 15.5, 1 ), array( 16.6, 3 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$limitedIncremetalOrderBookTarget = array(
    'bids' => array( array( 10.0, 3 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ) ),
    'asks' => array( array( 11.1, 2 ), array( 12.2, 0.125 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 15.5, 1 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$storedIncremetalOrderBookTarget = array(
    'bids' => array( array( 10.0, 3 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ), array( 3, 3 ) ),
    'asks' => array( array( 11.1, 2 ), array( 12.2, 0.125 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 15.5, 1 ), array( 16.6, 3 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$doubleStoredIncremetalOrderBookTarget = array(
    'bids' => array( array( 10.0, 3 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ), array( 3, 10 ) ),
    'asks' => array( array( 11.1, 2 ), array( 12.2, 0.125 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 15.5, 1 ), array( 16.6, 3 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$negativeStoredIncremetalOrderBookTarget = array(
    'bids' => array( array( 10.0, 3 ), array( 8.2, 1 ), array( 7.3, 1 ), array( 6.4, 1 ) ),
    'asks' => array( array( 11.1, 2 ), array( 12.2, 0.125 ), array( 13.3, 3 ), array( 14.4, 4 ), array( 16.6, 3 ) ),
    'timestamp' => 1574827239000,
    'datetime' => '2019-11-27T04:00:39.000Z',
    'nonce' => 69,
    'symbol' => null,
);

$bids = null;
$asks = null;

// --------------------------------------------------------------------------------------------------------------------

$orderBook = new OrderBook ($orderBookInput);
$limited = new OrderBook ($orderBookInput, 5);
$orderBook->limit ();
assert (equals ($orderBook, $orderBookTarget));

$orderBook->limit (5);
$limited->limit ();
assert (equals ($orderBook, $limitedOrderBookTarget));
assert (equals ($limited, $limitedOrderBookTarget));

$orderBook->limit ();
assert (equals ($orderBook, $orderBookTarget));

$bids = $orderBook['bids'];
$bids->store (1000, 0);
$orderBook->limit ();

assert (equals ($orderBook, $orderBookTarget));

$bids->store (3, 4);
$orderBook->limit ();

assert (equals ($orderBook, $storeBid));
$bids->store (3, 0);
$orderBook->limit ();
assert (equals ($orderBook, $orderBookTarget));
$asks = $limited['asks'];
$asks->store (15.5, 0);
$limited->limit ();
assert (equals ($limited, $limitedDeletedOrderBookTarget));

$limited->limit (5);
$asks->store (100, 1);
$asks->store (101, 1);
$asks->store (101, 3);

// --------------------------------------------------------------------------------------------------------------------

$indexedOrderBook = new IndexedOrderBook ($indexedOrderBookInput);
$limitedIndexedOrderBook = new IndexedOrderBook ($indexedOrderBookInput, 5);
$indexedOrderBook->limit ();
assert (equals ($indexedOrderBook, $indexedOrderBookTarget));

$indexedOrderBook->limit (5);
$limitedIndexedOrderBook->limit ();
assert (equals ($indexedOrderBook, $limitedIndexedOrderBookTarget));
assert (equals ($limitedIndexedOrderBook, $limitedIndexedOrderBookTarget));
$indexedOrderBook->limit ();
assert (equals ($indexedOrderBook, $indexedOrderBookTarget));

$bids = $indexedOrderBook['bids'];
$bids->store (1000, 0, '12345');
assert (equals ($indexedOrderBook, $indexedOrderBookTarget));
$bids->store (10, 0, '1234');
$indexedOrderBook->limit ();
assert (equals ($indexedOrderBook, $overwrite1234));
$indexedOrderBook = new IndexedOrderBook ($indexedOrderBookInput);
$asks = $indexedOrderBook['asks'];
$asks->store (13.5, 13, '1244');
$indexedOrderBook->limit ();
assert (equals ($indexedOrderBook, $overwrite1244));

// --------------------------------------------------------------------------------------------------------------------

$countedOrderBook = new CountedOrderBook ($countedOrderBookInput);
$limitedCountedOrderBook = new CountedOrderBook ($countedOrderBookInput, 5);
$countedOrderBook->limit ();
assert (equals ($countedOrderBook, $countedOrderBookTarget));

$countedOrderBook->limit (5);
$limitedCountedOrderBook->limit ();
assert (equals ($countedOrderBook, $limitedCountedOrderBookTarget));
assert (equals ($limitedCountedOrderBook, $limitedCountedOrderBookTarget));
$countedOrderBook->limit ();
assert (equals ($countedOrderBook, $countedOrderBookTarget));

$bids = $countedOrderBook['bids'];
$bids->store (5, 0, 6);
$countedOrderBook->limit ();
assert (equals ($countedOrderBook, $countedOrderBookTarget));
$bids->store (1, 1, 6);
$countedOrderBook->limit ();
assert (equals ($countedOrderBook, $storedCountedOrderbookTarget));

// --------------------------------------------------------------------------------------------------------------------

// $incrementalOrderBook = new IncrementalOrderBook ($incrementalOrderBookInput);
// $limitedIncrementalOrderBook = new IncrementalOrderBook ($incrementalOrderBookInput, 5);
// $incrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $incremetalOrderBookTarget));

// $incrementalOrderBook->limit (5);
// $limitedIncrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $limitedIncremetalOrderBookTarget));
// assert (equals ($limitedIncrementalOrderBook, $limitedIncremetalOrderBookTarget));
// $incrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $incremetalOrderBookTarget));

// $bids = $incrementalOrderBook['bids'];
// $bids->store (3, 3);
// $incrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $storedIncremetalOrderBookTarget));
// $bids->store (3, 7);
// $incrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $doubleStoredIncremetalOrderBookTarget));
// $bids->store (17, 0);
// assert (equals ($incrementalOrderBook, $doubleStoredIncremetalOrderBookTarget));
// $incrementalOrderBook = new IncrementalOrderBook ($incrementalOrderBookInput);
// $asks = $incrementalOrderBook['asks'];
// $asks->store (15.5, -10);
// $incrementalOrderBook->limit ();
// assert (equals ($incrementalOrderBook, $negativeStoredIncremetalOrderBookTarget));

// --------------------------------------------------------------------------------------------------------------------

// $incrementalIndexedOrderBook = new IncrementalIndexedOrderBook ($indexedOrderBookInput);
// $limitedIncrementalIndexedOrderBook = new IncrementalIndexedOrderBook ($indexedOrderBookInput, 5);
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $incrementalIndexedOrderBookTarget));

// $incrementalIndexedOrderBook->limit (5);
// $limitedIncrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $limitedIncrementalIndexedOrderBookTarget));
// assert (equals ($limitedIncrementalIndexedOrderBook, $limitedIncrementalIndexedOrderBookTarget));
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $incrementalIndexedOrderBookTarget));

// $bids = $incrementalIndexedOrderBook['bids'];
// $bids->store (5, 0, 'xxyy');
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $incrementalIndexedOrderBookTarget));

// $bids->store (10.0, 3, '1234');  // price does match merge size
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $storedIncrementalIndexedOrderBookTarget));

// $bids->store (0, 0, '1234');
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $incrementalIndexedOrderBookDeletedTarget));

// $incrementalIndexedOrderBook = new IncrementalIndexedOrderBook ($indexedOrderBookInput);
// $bids = $incrementalIndexedOrderBook['bids'];
// $bids->store (10.2, 3, '1234');  // price does not match merge size
// $incrementalIndexedOrderBook->limit ();
// assert (equals ($incrementalIndexedOrderBook, $anotherStoredIncrementalIndexedOrderBookTarget));

// --------------------------------------------------------------------------------------------------------------------

$resetBook = new OrderBook ($storeBid);
$resetBook->limit ();
$resetBook->reset ($orderBookInput);
$resetBook->limit ();
assert (equals ($resetBook, $orderBookTarget));
