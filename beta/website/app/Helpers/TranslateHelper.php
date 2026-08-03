<?php

if (!function_exists('tv')) {
    function tv(string $group, ?string $value): ?string
    {
        if (!$value) return $value;
        $translated = __("values.{$group}.{$value}");
        return ($translated === "values.{$group}.{$value}") ? $value : $translated;
    }
}
