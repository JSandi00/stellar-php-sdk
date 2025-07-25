<?php declare(strict_types=1);

// Copyright 2023 The Stellar PHP SDK Authors. All rights reserved.
// Use of this source code is governed by a license that can be
// found in the LICENSE file.

namespace Soneso\StellarSDK\Xdr;


class XdrConfigSettingEntry
{
    public XdrConfigSettingID $configSettingID;
    public ?int $contractMaxSizeBytes = null;
    public ?XdrConfigSettingContractComputeV0 $contractCompute = null;
    public ?XdrConfigSettingContractLedgerCostV0 $contractLedgerCost = null;
    public ?XdrConfigSettingContractHistoricalDataV0 $contractHistoricalData = null;
    public ?XdrConfigSettingContractEventsV0 $contractEvents = null;
    public ?XdrConfigSettingContractBandwidthV0 $contractBandwidth = null;
    public ?XdrContractCostParams $contractCostParamsCpuInsns = null;
    public ?XdrContractCostParams $contractCostParamsMemBytes = null;
    public ?int $contractDataKeySizeBytes = null;
    public ?int $contractDataEntrySizeBytes = null;
    public ?XdrStateArchivalSettings $stateArchivalSettings = null;
    public ?XdrConfigSettingContractExecutionLanesV0 $contractExecutionLanes = null;
    /**
     * @var array<int>|null $liveSorobanStateSizeWindow [uint64]
     */
    public ?array $liveSorobanStateSizeWindow = null; // [uint64]
    public ?XdrEvictionIterator $evictionIterator = null;

    public ?XdrConfigSettingContractParallelComputeV0 $contractParallelCompute = null;
    public ?XdrConfigSettingContractLedgerCostExtV0 $contractLedgerCostExt = null;
    public ?XdrConfigSettingSCPTiming $contractSCPTiming = null;

    /**
     * @param XdrConfigSettingID $configSettingID
     */
    public function __construct(XdrConfigSettingID $configSettingID)
    {
        $this->configSettingID = $configSettingID;
    }


    public function encode(): string {
        $bytes = $this->configSettingID->encode();
        switch ($this->configSettingID->value) {
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_MAX_SIZE_BYTES:
                $bytes .= XdrEncoder::unsignedInteger32($this->contractMaxSizeBytes);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COMPUTE_V0:
                $bytes .= $this->contractCompute->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_LEDGER_COST_V0:
                $bytes .= $this->contractLedgerCost->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_HISTORICAL_DATA_V0:
                $bytes .= $this->contractHistoricalData->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_EVENTS_V0:
                $bytes .= $this->contractEvents->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_BANDWIDTH_V0:
                $bytes .= $this->contractBandwidth->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COST_PARAMS_CPU_INSTRUCTIONS:
                $bytes .= $this->contractCostParamsCpuInsns->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COST_PARAMS_MEMORY_BYTES:
                $bytes .= $this->contractCostParamsMemBytes->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_DATA_KEY_SIZE_BYTES:
                $bytes .= XdrEncoder::unsignedInteger32($this->contractDataKeySizeBytes);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_DATA_ENTRY_SIZE_BYTES:
                $bytes .= XdrEncoder::unsignedInteger32($this->contractDataEntrySizeBytes);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_STATE_ARCHIVAL:
                $bytes .= $this->stateArchivalSettings->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_EXECUTION_LANES:
                $bytes .= $this->contractExecutionLanes->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_LIVE_SOROBAN_STATE_SIZE_WINDOW:
                $bytes .= XdrEncoder::integer32(count($this->liveSorobanStateSizeWindow));
                foreach($this->liveSorobanStateSizeWindow as $val) {
                    $bytes .= XdrEncoder::unsignedInteger64($val);
                }
                break;
            case XdrConfigSettingID::CONFIG_SETTING_EVICTION_ITERATOR:
                $bytes .= $this->evictionIterator->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_PARALLEL_COMPUTE_V0:
                $bytes .= $this->contractParallelCompute->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_LEDGER_COST_EXT_V0:
                $bytes .= $this->contractLedgerCostExt->encode();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_SCP_TIMING:
                $bytes .= $this->contractSCPTiming->encode();
                break;
        }
        return $bytes;
    }

    public static function decode(XdrBuffer $xdr) : XdrConfigSettingEntry {
        $v = $xdr->readInteger32();
        $result = new XdrConfigSettingEntry(new XdrConfigSettingID($v));
        switch ($v) {
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_MAX_SIZE_BYTES:
                $result->contractMaxSizeBytes = $xdr->readUnsignedInteger32();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COMPUTE_V0:
                $result->contractCompute = XdrConfigSettingContractComputeV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_LEDGER_COST_V0:
                $result->contractLedgerCost = XdrConfigSettingContractLedgerCostV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_HISTORICAL_DATA_V0:
                $result->contractHistoricalData = XdrConfigSettingContractHistoricalDataV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_EVENTS_V0:
                $result->contractEvents = XdrConfigSettingContractEventsV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_BANDWIDTH_V0:
                $result->contractBandwidth = XdrConfigSettingContractBandwidthV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COST_PARAMS_CPU_INSTRUCTIONS:
                $result->contractCostParamsCpuInsns = XdrContractCostParams::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_COST_PARAMS_MEMORY_BYTES:
                $result->contractCostParamsMemBytes = XdrContractCostParams::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_DATA_KEY_SIZE_BYTES:
                $result->contractDataKeySizeBytes = $xdr->readUnsignedInteger32();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_DATA_ENTRY_SIZE_BYTES:
                $result->contractDataEntrySizeBytes = $xdr->readUnsignedInteger32();
                break;
            case XdrConfigSettingID::CONFIG_SETTING_STATE_ARCHIVAL:
                $result->stateArchivalSettings = XdrStateArchivalSettings::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_EXECUTION_LANES:
                $result->contractExecutionLanes = XdrConfigSettingContractExecutionLanesV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_LIVE_SOROBAN_STATE_SIZE_WINDOW:
                $valCount = $xdr->readInteger32();
                $entriesArr = array();
                for ($i = 0; $i < $valCount; $i++) {
                    $entriesArr[] = $xdr->readUnsignedInteger64();
                }
                $result->liveSorobanStateSizeWindow = $entriesArr;
                break;
            case XdrConfigSettingID::CONFIG_SETTING_EVICTION_ITERATOR:
                $result->evictionIterator = XdrEvictionIterator::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_PARALLEL_COMPUTE_V0:
                $result->contractParallelCompute = XdrConfigSettingContractParallelComputeV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_CONTRACT_LEDGER_COST_EXT_V0:
                $result->contractLedgerCostExt = XdrConfigSettingContractLedgerCostExtV0::decode($xdr);
                break;
            case XdrConfigSettingID::CONFIG_SETTING_SCP_TIMING:
                $result->contractSCPTiming = XdrConfigSettingSCPTiming::decode($xdr);
                break;
        }
        return $result;
    }

    /**
     * @return XdrConfigSettingID
     */
    public function getConfigSettingID(): XdrConfigSettingID
    {
        return $this->configSettingID;
    }

    /**
     * @param XdrConfigSettingID $configSettingID
     */
    public function setConfigSettingID(XdrConfigSettingID $configSettingID): void
    {
        $this->configSettingID = $configSettingID;
    }

    /**
     * @return int|null
     */
    public function getContractMaxSizeBytes(): ?int
    {
        return $this->contractMaxSizeBytes;
    }

    /**
     * @param int|null $contractMaxSizeBytes
     */
    public function setContractMaxSizeBytes(?int $contractMaxSizeBytes): void
    {
        $this->contractMaxSizeBytes = $contractMaxSizeBytes;
    }

    /**
     * @return XdrConfigSettingContractComputeV0|null
     */
    public function getContractCompute(): ?XdrConfigSettingContractComputeV0
    {
        return $this->contractCompute;
    }

    /**
     * @param XdrConfigSettingContractComputeV0|null $contractCompute
     */
    public function setContractCompute(?XdrConfigSettingContractComputeV0 $contractCompute): void
    {
        $this->contractCompute = $contractCompute;
    }

    /**
     * @return XdrConfigSettingContractLedgerCostV0|null
     */
    public function getContractLedgerCost(): ?XdrConfigSettingContractLedgerCostV0
    {
        return $this->contractLedgerCost;
    }

    /**
     * @param XdrConfigSettingContractLedgerCostV0|null $contractLedgerCost
     */
    public function setContractLedgerCost(?XdrConfigSettingContractLedgerCostV0 $contractLedgerCost): void
    {
        $this->contractLedgerCost = $contractLedgerCost;
    }

    /**
     * @return XdrConfigSettingContractHistoricalDataV0|null
     */
    public function getContractHistoricalData(): ?XdrConfigSettingContractHistoricalDataV0
    {
        return $this->contractHistoricalData;
    }

    /**
     * @param XdrConfigSettingContractHistoricalDataV0|null $contractHistoricalData
     */
    public function setContractHistoricalData(?XdrConfigSettingContractHistoricalDataV0 $contractHistoricalData): void
    {
        $this->contractHistoricalData = $contractHistoricalData;
    }

    /**
     * @return XdrConfigSettingContractEventsV0|null
     */
    public function getContractEvents(): ?XdrConfigSettingContractEventsV0
    {
        return $this->contractEvents;
    }

    /**
     * @param XdrConfigSettingContractEventsV0|null $contractEvents
     */
    public function setContractEvents(?XdrConfigSettingContractEventsV0 $contractEvents): void
    {
        $this->contractEvents = $contractEvents;
    }

    /**
     * @return XdrConfigSettingContractBandwidthV0|null
     */
    public function getContractBandwidth(): ?XdrConfigSettingContractBandwidthV0
    {
        return $this->contractBandwidth;
    }

    /**
     * @param XdrConfigSettingContractBandwidthV0|null $contractBandwidth
     */
    public function setContractBandwidth(?XdrConfigSettingContractBandwidthV0 $contractBandwidth): void
    {
        $this->contractBandwidth = $contractBandwidth;
    }

    /**
     * @return XdrContractCostParams|null
     */
    public function getContractCostParamsCpuInsns(): ?XdrContractCostParams
    {
        return $this->contractCostParamsCpuInsns;
    }

    /**
     * @param XdrContractCostParams|null $contractCostParamsCpuInsns
     */
    public function setContractCostParamsCpuInsns(?XdrContractCostParams $contractCostParamsCpuInsns): void
    {
        $this->contractCostParamsCpuInsns = $contractCostParamsCpuInsns;
    }

    /**
     * @return XdrContractCostParams|null
     */
    public function getContractCostParamsMemBytes(): ?XdrContractCostParams
    {
        return $this->contractCostParamsMemBytes;
    }

    /**
     * @param XdrContractCostParams|null $contractCostParamsMemBytes
     */
    public function setContractCostParamsMemBytes(?XdrContractCostParams $contractCostParamsMemBytes): void
    {
        $this->contractCostParamsMemBytes = $contractCostParamsMemBytes;
    }

    /**
     * @return int|null
     */
    public function getContractDataKeySizeBytes(): ?int
    {
        return $this->contractDataKeySizeBytes;
    }

    /**
     * @param int|null $contractDataKeySizeBytes
     */
    public function setContractDataKeySizeBytes(?int $contractDataKeySizeBytes): void
    {
        $this->contractDataKeySizeBytes = $contractDataKeySizeBytes;
    }

    /**
     * @return int|null
     */
    public function getContractDataEntrySizeBytes(): ?int
    {
        return $this->contractDataEntrySizeBytes;
    }

    /**
     * @param int|null $contractDataEntrySizeBytes
     */
    public function setContractDataEntrySizeBytes(?int $contractDataEntrySizeBytes): void
    {
        $this->contractDataEntrySizeBytes = $contractDataEntrySizeBytes;
    }

    /**
     * @return XdrStateArchivalSettings|null
     */
    public function getStateArchivalSettings(): ?XdrStateArchivalSettings
    {
        return $this->stateArchivalSettings;
    }

    /**
     * @param XdrStateArchivalSettings|null $stateArchivalSettings
     */
    public function setStateArchivalSettings(?XdrStateArchivalSettings $stateArchivalSettings): void
    {
        $this->stateArchivalSettings = $stateArchivalSettings;
    }

    /**
     * @return XdrConfigSettingContractExecutionLanesV0|null
     */
    public function getContractExecutionLanes(): ?XdrConfigSettingContractExecutionLanesV0
    {
        return $this->contractExecutionLanes;
    }

    /**
     * @param XdrConfigSettingContractExecutionLanesV0|null $contractExecutionLanes
     */
    public function setContractExecutionLanes(?XdrConfigSettingContractExecutionLanesV0 $contractExecutionLanes): void
    {
        $this->contractExecutionLanes = $contractExecutionLanes;
    }

    /**
     * @return XdrEvictionIterator|null
     */
    public function getEvictionIterator(): ?XdrEvictionIterator
    {
        return $this->evictionIterator;
    }

    /**
     * @param XdrEvictionIterator|null $evictionIterator
     */
    public function setEvictionIterator(?XdrEvictionIterator $evictionIterator): void
    {
        $this->evictionIterator = $evictionIterator;
    }

    /**
     * @return array|null
     */
    public function getLiveSorobanStateSizeWindow(): ?array
    {
        return $this->liveSorobanStateSizeWindow;
    }

    /**
     * @param array|null $liveSorobanStateSizeWindow
     */
    public function setLiveSorobanStateSizeWindow(?array $liveSorobanStateSizeWindow): void
    {
        $this->liveSorobanStateSizeWindow = $liveSorobanStateSizeWindow;
    }

    /**
     * @return XdrConfigSettingContractParallelComputeV0|null
     */
    public function getContractParallelCompute(): ?XdrConfigSettingContractParallelComputeV0
    {
        return $this->contractParallelCompute;
    }

    /**
     * @param XdrConfigSettingContractParallelComputeV0|null $contractParallelCompute
     */
    public function setContractParallelCompute(?XdrConfigSettingContractParallelComputeV0 $contractParallelCompute): void
    {
        $this->contractParallelCompute = $contractParallelCompute;
    }

    /**
     * @return XdrConfigSettingContractLedgerCostExtV0|null
     */
    public function getContractLedgerCostExt(): ?XdrConfigSettingContractLedgerCostExtV0
    {
        return $this->contractLedgerCostExt;
    }

    /**
     * @param XdrConfigSettingContractLedgerCostExtV0|null $contractLedgerCostExt
     */
    public function setContractLedgerCostExt(?XdrConfigSettingContractLedgerCostExtV0 $contractLedgerCostExt): void
    {
        $this->contractLedgerCostExt = $contractLedgerCostExt;
    }

    /**
     * @return XdrConfigSettingSCPTiming|null
     */
    public function getContractSCPTiming(): ?XdrConfigSettingSCPTiming
    {
        return $this->contractSCPTiming;
    }

    /**
     * @param XdrConfigSettingSCPTiming|null $contractSCPTiming
     */
    public function setContractSCPTiming(?XdrConfigSettingSCPTiming $contractSCPTiming): void
    {
        $this->contractSCPTiming = $contractSCPTiming;
    }

}