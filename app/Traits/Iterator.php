<?php

namespace App\Traits;

trait Iterator
{
    protected static function getData(array $data, ...$keys)
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return $data[$key];
            }
        }

        return null;
    }

    protected static function substituteKeysOnArray(
        array $arrOne,
        array $arrTwo
    ): array
    {
        foreach ($arrOne as $keyOne => $valueArrayOne) {
            foreach ($arrTwo as $keyTwo => $valueArrayTwo) {
                if ($keyOne === $keyTwo) {
                    $arrOne[$keyOne] = $valueArrayTwo;
                }
            }
        }

        return $arrOne;
    }

    protected static function substituteStringOnArray(
        array  $arr,
        string $searchString,
        mixed  $substituteValue
    ): array
    {
        foreach ($arr as &$value) {
            if (is_string($value) && str_contains($value, $searchString)) {
                $value = str_replace($searchString, $substituteValue, $value);
            }
        }

        unset($value);
        return $arr;
    }
}
