<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class EventFilters

{

    public function convertFormatForMonthColumn(string $value)
    {
        $value = str_replace(['Januar', 'Jan','JAN'], 'JAN', $value);
        $value = str_replace(['Februar', 'Feb','FEB'], 'FEB', $value);
        $value = str_replace(['März', 'March', 'Mär', 'Mar','MAR'], config('app.locale') == 'de' ? 'MÄR' : 'MAR', $value);
        $value = str_replace(['April', 'Apr','APR'], 'APR', $value);
        $value = str_replace(['Mai', 'May','MAY'], config('app.locale') == 'de' ? 'MAI' : 'MAY', $value);
        $value = str_replace(['Juni', 'Jun','June','JUNe','JUN'], 'JUN', $value);
        $value = str_replace(['Juli', 'Jul','July','JUL'], 'JUL', $value);
        $value = str_replace(['August', 'Aug','AUG'], 'AUG', $value);
        $value = str_replace(['September', 'Sep','SEP'], 'SEP', $value);
        $value = str_replace(['Oktober', 'Oct','OCT'], 'OCT', $value);
        $value = str_replace(['November', 'Nov','NOV'], 'NOV', $value);
        $value = str_replace(['Dezember', 'Dec', 'Dez','DEZ'], config('app.locale') == 'de' ? 'DEZ' : 'DEC', $value);

        return $value;
    }
}
