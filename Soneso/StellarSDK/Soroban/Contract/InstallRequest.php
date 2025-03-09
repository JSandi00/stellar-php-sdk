<?php declare(strict_types=1);

// Copyright 2025 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\Soroban\Contract;

use Soneso\StellarSDK\Crypto\KeyPair;
use Soneso\StellarSDK\Network;

class InstallRequest
{

    /**
     * @var string $wasmBytes the contract code wasm bytes to install.
     */
    public string $wasmBytes;

    /**
     * @var KeyPair $sourceAccountKeyPair Keypair of the Stellar account that will send this transaction.
     * The keypair must contain the private key for signing.
     */
    public KeyPair $sourceAccountKeyPair;

    /**
     * @var Network $network The Stellar network this contract is to be installed
     *  to
     */
    public Network $network;

    /**
     * @var string $rpcUrl The URL of the RPC instance that will be used to install the contract.
     */
    public string $rpcUrl;

    /**
     * @var bool $enableServerLogging enable soroban server logging (helpful for debugging). Default: false.
     */
    public bool $enableServerLogging = false;

    /**
     * Constructor.
     *
     * @param string $wasmBytes The contract code wasm bytes to install.
     * @param string $rpcUrl The URL of the RPC instance that will be used to deploy the contract.
     * @param Network $network The Stellar network this contract is to be deployed.
     * @param KeyPair $sourceAccountKeyPair Keypair of the Stellar account that will send this transaction. The keypair must contain the private key for signing.
     * @param bool $enableServerLogging enable soroban server logging (helpful for debugging). Default: false.
     */
    public function __construct(string $wasmBytes,
                                string $rpcUrl,
                                Network $network,
                                KeyPair $sourceAccountKeyPair,
                                bool $enableServerLogging = false)
    {
        $this->wasmBytes = $wasmBytes;
        $this->sourceAccountKeyPair = $sourceAccountKeyPair;
        $this->network = $network;
        $this->rpcUrl = $rpcUrl;
        $this->enableServerLogging = $enableServerLogging;
    }

}