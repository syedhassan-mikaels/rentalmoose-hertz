<?php

function isAssocArray(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}


function arrayValueByDottedKey($key, array $data, $default = null)
{
    if (!is_string($key) || empty($key) || !count($data))
    {
        return $default;
    }

    // @assert $key contains a dot notated string
    if (strpos($key, '.') !== false)
    {
        $keys = explode('.', $key);

        foreach ($keys as $innerKey)
        {
            // @assert $data[$innerKey] is available to continue
            // @otherwise return $default value
            if (!array_key_exists($innerKey, $data))
            {
                return $default;
            }

            $data = $data[$innerKey];
        }

        return $data;
    }

    // @fallback returning value of $key in $data or $default value
    return array_key_exists($key, $data) ? $data[$key] : $default;
}

function xmlToArray(String $str){
    $xml = simplexml_load_string($str);

    $json = json_encode($xml);

    return json_decode($json,TRUE);
}

?>
