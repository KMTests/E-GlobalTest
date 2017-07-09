<?php

namespace ApiBundle\Utils;

/**
 * Class ArrayUtils
 * @package ApiBundle\Utils
 */
class ArrayUtils {

    const MODE_APPEND = 'APPEND';
    const MODE_SET = 'SET';
    const DELIMITER = '.';

    /**
     * @param $key
     * @param $data
     * @param array $array
     * @param string $delimiter
     * @param string $mode
     * @return array
     */
    public static function setArrayByString($key, $data, array &$array, $delimiter = self::DELIMITER, $mode = self::MODE_SET) {
        $keys = self::getKeys($key, $delimiter);
        while(count($keys) > 1) {
            $key = self::createArrayIfNotSet($array, $keys);
            $array = &$response[$key];
        }
        if($mode === self::MODE_SET) {
            $array[array_shift($keys)] = $data;
        } elseif ($mode == self::MODE_APPEND) {
            $key = self::createArrayIfNotSet($array, $keys);
            $array[$key][] = $data;
        }
        return $array;
    }

    /**
     * @param string $key
     * @param string $delimiter
     * @return array
     */
    private static function getKeys($key, $delimiter = ArrayUtils::DELIMITER) {
        return explode($delimiter, $key);
    }

    /**
     * @param array $array
     * @param array $keys
     * @return mixed
     */
    private static function createArrayIfNotSet(&$array, &$keys) {
        $key = array_shift($keys);
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = [];
        }
        return $key;
    }

    /**
     * @param array $array
     * @param $key
     * @param $value
     */
    public static function addToArrayKey(array &$array, $key, $value) {
        if(array_key_exists($key, $array)) {
            $array[$key][] = $value;
        } else {
            $array[$key] = [$value];
        }
    }

}