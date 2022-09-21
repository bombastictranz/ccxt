<?php

namespace ccxt;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import

class bitazza extends ndax {

    public function describe() {
        return $this->deep_extend(parent::describe(), array(
            'id' => 'bitazza',
            'name' => 'Bitazza',
            'countries' => array( 'THA' ),
            'certified' => false,
            'pro' => false,
            'urls' => array(
                'test' => null,
                'api' => array(
                    'public' => 'https://apexapi.bitazza.com:8443/AP',
                    'private' => 'https://apexapi.bitazza.com:8443/AP',
                ),
                'www' => 'https://bitazza.com/',
                'referral' => '',
                'fees' => 'https://bitazza.com/fees.html',
                'doc' => array(
                    'https://api-doc.bitazza.com/',
                ),
            ),
            'fees' => array(
                'trading' => array(
                    'tierBased' => true,
                    'percentage' => true,
                    'taker' => $this->parse_number('0.0025'),
                    'maker' => $this->parse_number('0.0025'),
                ),
            ),
        ));
    }
}
