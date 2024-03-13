<?php declare(strict_types=1);

// Copyright 2024 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\SEP\TransferServerService;

class DepositInstruction
{
    /**
     * @var string $value The value of the field.
     */
    public string $value;

    /**
     * @var string $description A human-readable description of the field. This can be used by an anchor
     * to provide any additional information about fields that are not defined in the SEP-9 standard.
     */
    public string $description;

    /**
     * @param string $value The value of the field.
     * @param string $description A human-readable description of the field. This can be used by an anchor
     *  to provide any additional information about fields that are not defined in the SEP-9 standard.
     */
    public function __construct(string $value, string $description)
    {
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * Constructs a new instance of DepositInstruction by using the given data.
     * @param array<array-key, mixed> $json the data to construct the object from.
     * @return DepositInstruction the object containing the parsed data.
     */
    public static function fromJson(array $json) : DepositInstruction
    {
        return new DepositInstruction($json['value'], $json['description']);
    }
}