<?php
/**
 * This file is part of the DMM JsonSerializer package.
 * Copyright 2017 - 2018 by Julian Finkler <julian@mintware.de>
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace MintWare\Tests\DMM;

use MintWare\DMM\DataField;
use MintWare\DMM\Exception\InvalidJsonException;
use MintWare\DMM\Serializer\JsonSerializer;
use MintWare\DMM\Serializer\PropertyHolder;
use MintWare\DMM\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    public function testImplementation()
    {
        $serializer = new JsonSerializer();
        $this->assertInstanceOf(SerializerInterface::class, $serializer);
    }

    /** @throws \Exception */
    public function testDeserializeFails()
    {
        $serializer = new JsonSerializer();
        $this->expectException(InvalidJsonException::class);
        $serializer->deserialize('Foobar');
    }

    /** @throws \Exception */
    public function testDeserialize()
    {
        $serializer = new JsonSerializer();

        $expected = [
            "foo" => "bar",
            "test" => [1, 2, 3, 4]
        ];
        $res = $serializer->deserialize('{"foo": "bar", "test": [1,2,3,4]}');

        $this->assertEquals($expected, $res);
    }

    public function testRemoveMetaDataEntries()
    {
        $expected = [
            'Foo' => 1,
            'Baz' => ['Foo', 'Bar' => 'Baz'],
            'Obj' => ['Hello' => 'World'],
            'Temp' => ['Hello' => ['x' => ['y' => 'z']]],
        ];

        $df = new DataField();
        $input = [
            'Foo' => new PropertyHolder($df, '', 1),
            'Baz' => new PropertyHolder($df, '', ['Foo', 'Bar' => 'Baz']),
            'Obj' => new PropertyHolder($df, '', ['Hello' => new PropertyHolder($df, '', 'World')]),
            'Temp' => new PropertyHolder($df, '', ['Hello' => new PropertyHolder($df, '', ['x' => ['y' => 'z']])]),
        ];

        $serializer = new JsonSerializer();
        $res = $serializer->removeMetaDataEntries($input);
        $this->assertEquals($expected, $res);
    }

    public function testSerialize()
    {
        $df = new DataField();
        $input = [
            'Foo' => new PropertyHolder($df, '', 1),
            'Baz' => new PropertyHolder($df, '', ['Foo', 'Bar' => 'Baz']),
            'Obj' => new PropertyHolder($df, '', ['Hello' => new PropertyHolder($df, '', 'World')]),
            'Temp' => new PropertyHolder($df, '', ['Hello' => new PropertyHolder($df, '', ['x' => ['y' => 'z']])]),
        ];

        $expected = <<<'JSON'
{
    "Foo": 1,
    "Baz": {
        "0": "Foo",
        "Bar": "Baz"
    },
    "Obj": {
        "Hello": "World"
    },
    "Temp": {
        "Hello": {
            "x": {
                "y": "z"
            }
        }
    }
}
JSON;

        $serializer = new JsonSerializer();
        $res = $serializer->serialize(new PropertyHolder(null, null, $input, null));
        $this->assertSame($expected, $res);
    }
}
