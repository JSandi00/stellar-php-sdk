<?php declare(strict_types=1);

// Copyright 2023 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\Soroban\Responses;

/**
 * Response when reading the current values of ledger entries.
 * See: https://developers.stellar.org/network/soroban-rpc/api-reference/methods/getLedgerEntries
 */
class GetLedgerEntriesResponse extends SorobanRpcResponse
{

    /**
     * @var array<LedgerEntry>|null $entries Array of objects containing all found ledger entries.
     */
    public ?array $entries = null; // LedgerEntry

    /**
     * @var int|null $latestLedger The sequence number of the latest ledger known to Soroban RPC at the time it handled the request.
     */
    public ?int $latestLedger = null;

    public static function fromJson(array $json) : GetLedgerEntriesResponse {
        $result = new GetLedgerEntriesResponse($json);
        if (isset($json['result'])) {

            if (isset($json['result']['entries'])) {
                $result->entries = array();
                foreach ($json['result']['entries'] as $jsonEntry) {
                    $entry = LedgerEntry::fromJson($jsonEntry);
                    array_push($result->entries, $entry);
                }
            }

            $result->latestLedger = $json['result']['latestLedger'];
        } else if (isset($json['error'])) {
            $result->error = SorobanRpcErrorResponse::fromJson($json);
        }
        return $result;
    }

    /**
     * @return array<LedgerEntry>|null Array of objects containing all found ledger entries.
     */
    public function getEntries(): ?array
    {
        return $this->entries;
    }

    /**
     * @param array<LedgerEntry>|null $entries Array of objects containing all found ledger entries.
     */
    public function setEntries(?array $entries): void
    {
        $this->entries = $entries;
    }

    /**
     * @return int|null The sequence number of the latest ledger known to Soroban RPC at the time it handled the
     * request.
     */
    public function getLatestLedger(): ?int
    {
        return $this->latestLedger;
    }

    /**
     * @param int|null $latestLedger The sequence number of the latest ledger known to Soroban RPC at the time
     * it handled the request.
     */
    public function setLatestLedger(?int $latestLedger): void
    {
        $this->latestLedger = $latestLedger;
    }

}