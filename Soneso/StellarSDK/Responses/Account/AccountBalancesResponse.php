<?php declare(strict_types=1);

// Copyright 2021 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\Responses\Account;

class AccountBalancesResponse extends \IteratorIterator {

    public function __construct(AccountBalanceResponse ...$balances) {
        parent::__construct(new \ArrayIterator($balances));
    }

    public function current() : AccountBalanceResponse {
        return parent::current();
    }

    public function add(AccountBalanceResponse $balance) {
        $this->getInnerIterator()->append($balance);
    }
    public function count() : int {
        return $this->getInnerIterator()->count();
    }

    /**
     * @return array<AccountBalanceResponse>
     */
    public function toArray() : array {
        /**
         * @var array<AccountBalanceResponse> $result
         */
        $result = array();
        foreach($this as $value) {
            array_push($result, $value);
        }
        return $result;
    }
}