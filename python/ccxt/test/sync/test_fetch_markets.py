import os
import sys

root = os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__)))))
sys.path.append(root)

# ----------------------------------------------------------------------------

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

# ----------------------------------------------------------------------------
# -*- coding: utf-8 -*-

from ccxt.test.base import test_market  # noqa E402
from ccxt.test.base import test_shared_methods  # noqa E402

def test_fetch_markets(exchange, skipped_properties):
    method = 'fetchMarkets'
    markets = exchange.fetch_markets()
    assert isinstance(markets, dict), exchange.id + ' ' + method + ' must return an object. ' + exchange.json(markets)
    market_values = list(markets.values())
    test_shared_methods.assert_non_emtpy_array(exchange, skipped_properties, method, market_values)
    for i in range(0, len(market_values)):
        test_market(exchange, skipped_properties, method, market_values[i])
