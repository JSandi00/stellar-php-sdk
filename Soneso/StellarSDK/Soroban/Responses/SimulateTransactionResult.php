<?php declare(strict_types=1);

// Copyright 2023 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\Soroban\Responses;


use Soneso\StellarSDK\Xdr\XdrSCVal;

/**
 * Used as a part of simulate transaction response.
 * See: https://developers.stellar.org/network/soroban-rpc/api-reference/methods/simulateTransaction
 */
class SimulateTransactionResult
{
    /**
     * @var string Serialized base64 string - return value of the Host Function call.
     */
    public string $xdr;

    /**
     * @var array<String> Array of serialized base64 strings - Per-address authorizations recorded when
     * simulating this Host Function call.
     */
    public array $auth;

    protected function loadFromJson(array $json) : void {
        $this->xdr = $json['xdr'];
        $this->auth = array();
        foreach ($json['auth'] as $jsonValue) {
            array_push($this->auth, $jsonValue);
        }
    }

    public static function fromJson(array $json) : SimulateTransactionResult {
        $result = new SimulateTransactionResult();
        $result->loadFromJson($json);
        return $result;
    }

    /**
     * @return XdrSCVal return value of the Host Function call as XdrSCVal.
     */
    public function getResultValue(): XdrSCVal {
        return XdrSCVal::fromBase64Xdr($this->xdr);
    }

    /**
     * @return string Serialized base64 string - return value of the Host Function call.
     */
    public function getXdr(): string
    {
        return $this->xdr;
    }

    /**
     * @return array<String> Array of serialized base64 strings - Per-address authorizations recorded when
     * simulating this Host Function call.
     */
    public function getAuth(): array
    {
        return $this->auth;
    }
}