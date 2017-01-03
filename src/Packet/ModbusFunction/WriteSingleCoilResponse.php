<?php
namespace ModbusTcpClient\Packet\ModbusFunction;

use ModbusTcpClient\Packet\IModbusPacket;
use ModbusTcpClient\Packet\StartAddressResponse;
use ModbusTcpClient\Utils\Types;

/**
 * Response for Write Single Coil (FC=05)
 */
class WriteSingleCoilResponse extends StartAddressResponse
{
    /**
     * @var bool
     */
    private $coil;

    public function __construct($rawData, $unitId = 0, $transactionId = null)
    {
        parent::__construct($rawData, $unitId, $transactionId);
        $this->coil = ord($rawData[2]) === 0xFF;
    }

    public function getFunctionCode()
    {
        return IModbusPacket::WRITE_SINGLE_COIL;
    }

    public function __toString()
    {
        return parent::__toString()
            . Types::toByte($this->isCoil() ? 0xFF : 0x0)
            . chr(0x0);
    }

    public function isCoil()
    {
        return $this->coil;
    }

    protected function getLengthInternal()
    {
        return parent::getLengthInternal() + 2; //coil 1 byte + 1 "unused 0x0 byte"
    }
}