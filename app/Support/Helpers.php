<?php

if (!function_exists('vue')) {
    /**
     * Returns a view that contains the given Vue component with the given attributes.
     *
     * @return mixed
     */
    function vue(string $name, array $attributes = [])
    {
        $data = [
        'componentAttributes' => $attributes,
        'componentName' => $name
    ];

        return view('vue.index', $data);
    }
}

if (!function_exists('array_to_object')) {
    /**
     * Converts an array to and object.
     *
     * @return object
     */
    function array_to_object(array $array)
    {
        return json_decode(json_encode($array), false);
    }
}
