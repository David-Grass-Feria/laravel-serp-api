<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class EventFilters

{

    public function convertFormatForMonthColumn(string $value)
    {
        $value = str_replace(['Januar', 'Jan'], 'JAN', $value);
        $value = str_replace(['Februar', 'Feb'], 'FEB', $value);
        $value = str_replace(['März', 'March', 'Mär', 'Mar'], config('app.locale') == 'de' ? 'MÄR' : 'MAR', $value);
        $value = str_replace(['April', 'Apr'], 'APR', $value);
        $value = str_replace(['Mai', 'May'], config('app.locale') == 'de' ? 'MAI' : 'MAY', $value);
        $value = str_replace(['Juni', 'Jun','June','JUNe'], 'JUN', $value);
        $value = str_replace(['Juli', 'Jul','July'], 'JUL', $value);
        $value = str_replace(['August', 'Aug'], 'AUG', $value);
        $value = str_replace(['September', 'Sep'], 'SEP', $value);
        $value = str_replace(['Oktober', 'Oct'], 'OCT', $value);
        $value = str_replace(['November', 'Nov'], 'NOV', $value);
        $value = str_replace(['Dezember', 'Dec', 'Dez'], config('app.locale') == 'de' ? 'DEZ' : 'DEC', $value);

        return $value;
    }
}
