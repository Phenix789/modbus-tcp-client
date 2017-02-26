# Modbus TCP protocol client

* Modbus TCP/IP specification: http://www.modbus.org/specs.php
* Modbus TCP/IP simpler description: http://www.simplymodbus.ca/TCP.htm

##Supported functions

* FC1 - Read Coils ([ReadCoilsRequest](src/Packet/ModbusFunction/ReadCoilsRequest.php) / [ReadCoilsResponse](src/Packet/ModbusFunction/ReadCoilsResponse.php))
* FC2 - Read Input Discretes ([ReadInputDiscretesRequest](src/Packet/ModbusFunction/ReadInputDiscretesRequest.php) / [ReadInputDiscretesResponse](src/Packet/ModbusFunction/ReadInputDiscretesResponse.php))
* FC3 - Read Holding Registers ([ReadHoldingRegistersRequest](src/Packet/ModbusFunction/ReadHoldingRegistersRequest.php) / [ReadHoldingRegistersResponse](src/Packet/ModbusFunction/ReadHoldingRegistersResponse.php))
* FC4 - Read Input Registers ([ReadInputRegistersRequest](src/Packet/ModbusFunction/ReadInputRegistersRequest.php) / [ReadInputRegistersResponse](src/Packet/ModbusFunction/ReadInputRegistersResponse.php))
* FC5 - Write Single Coil ([WriteSingleCoilRequest](src/Packet/ModbusFunction/WriteSingleCoilRequest.php) / [WriteSingleCoilResponse](src/Packet/ModbusFunction/WriteSingleCoilResponse.php))
* FC6 - Write Single Register ([WriteSingleRegisterRequest](src/Packet/ModbusFunction/WriteSingleRegisterRequest.php) / [WriteSingleRegisterResponse](src/Packet/ModbusFunction/WriteSingleRegisterResponse.php))
* FC15 - Write Multiple Coils ([WriteMultipleCoilsRequest](src/Packet/ModbusFunction/WriteMultipleCoilsRequest.php) / [WriteMultipleCoilsResponse](src/Packet/ModbusFunction/WriteMultipleCoilsResponse.php))
* FC16 - Write Multiple Registers ([WriteMultipleRegistersRequest](src/Packet/ModbusFunction/WriteMultipleRegistersRequest.php) / [WriteMultipleRegistersResponse](src/Packet/ModbusFunction/WriteMultipleRegistersResponse.php))

## Requirements

* PHP 5.6+ (64bit PHP! 32bit php does not support 64bit ints and overflows with 32bit unsigned integers when 32th bit is set)

## Intention
This library is influenced by [phpmodbus](https://github.com/adduc/phpmodbus) library and meant to be provide decoupled Modbus protocol (request/response packets) and networking related features so you could build modbus client with our own choice of networking code (ext_sockets/streams/Reactphp asynchronous streams) or use library provided networking classes (php Streams)

## Example (fc3 - read holding registers)

Some of the Modbus function examples are in `examples/` folder

```php
$connection = BinaryStreamConnection::getBuilder()
    ->setHost('192.168.0.1')
    ->build();
    
$packet = new ReadHoldingRegistersRequest(12288, 6); //create FC3 request packet

try {
    $binaryData = $connection->connect()->sendAndReceive($packet);

    //parse binary data to response object
    $response = ResponseFactory::parseResponseOrThrow($binaryData);
    
    foreach ($response->getWords() as $word) {
        print_r($word->getInt16BE());
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
} finally {
    $connection->close();
}
```

## Tests

* all `composer test`
* unit tests `composer test-unit`
* integration tests `composer test-integration`

For Windows users:
* all ` vendor/bin/phpunit`
* unit tests ` vendor/bin/phpunit --testsuite 'unit-tests'`
* integration tests ` vendor/bin/phpunit --testsuite 'integration-tests'`
