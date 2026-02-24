<?php

if (! function_exists('generateUniqueCode')) {
    function generateUniqueCode(string $prefix, string $modelClass, string $column = 'order_code'): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        do {
            $random = '';
            for ($i = 0; $i < 5; $i++) {
                $random .= $characters[random_int(0, strlen($characters) - 1)];
            }

            $code = strtoupper($prefix.'-'.$random);
        } while ($modelClass::where($column, $code)->exists());

        return $code;
    }
}