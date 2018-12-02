<?php
/**
 * This file is part of the DMM JsonSerializer package.
 * Copyright 2017 - 2018 by Julian Finkler <julian@mintware.de>
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace MintWare\DMM\Serializer;

use MintWare\DMM\Exception\InvalidJsonException;

class JsonSerializer implements SerializerInterface
{
    public $serializeOptions;

    /**
     * JsonSerializer constructor.
     *
     * @param int $jsonOptions The options for the json_encode function
     */
    public function __construct($jsonOptions = 128)
    {
        $this->serializeOptions = $jsonOptions;
    }

    /** @inheritdoc */
    public function deserialize($json)
    {
        if (!is_array($data = json_decode($json, true))) {
            throw new InvalidJsonException();
        }

        return $data;
    }

    /** @inheritdoc */
    public function serialize($data)
    {
        $rawData = $this->removeMetaDataEntries($data);
        return json_encode($rawData, $this->serializeOptions);
    }

    public function removeMetaDataEntries($data)
    {
        $res = [];
        foreach ($data as $k => $v) {
            if ($v instanceof PropertyHolder) {
                if (is_array($v->value) || is_object($v->value)) {
                    $res[$k] = $this->removeMetaDataEntries($v->value);
                } else {
                    $res[$k] = $v->value;
                }
            } elseif (is_array($v) || is_object($v)) {
                $res[$k] = $this->removeMetaDataEntries($v);
            } else {
                $res[$k] = $v;
            }
        }
        return $res;
    }
}
