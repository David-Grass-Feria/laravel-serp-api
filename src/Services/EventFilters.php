<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class EventFilters

{

    public $events;


    public function __construct(array $events = null)
    {
        $this->events = $events;
    }


    public function removeDublicateEntrys()
    {

        $addressCheck = [];
        foreach ($this->events as $key => $event) {
            if (!str_contains(strtolower($event['address'][1]), 'saalfeld') || in_array($event['address'][0], $addressCheck)) {
                unset($this->events[$key]);
            } else {
                $addressCheck[] = $event['address'][0];
            }
        }

        return $this->events;
    }

    public function sortEventsByDate()
    {
        $germanMonths = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dez'];
        $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        foreach ($this->events as &$event) {
            $date = $event['date']['start_date'];
            foreach ($germanMonths as $index => $germanMonth) {
                if (strpos($date, $germanMonth) !== false) {
                    $date = str_replace($germanMonth, $englishMonths[$index], $date);
                    $event['date']['start_date'] = $date;
                    break;
                }
            }
        }

        usort($this->events, function ($a, $b) {
            return strtotime($a['date']['start_date']) <=> strtotime($b['date']['start_date']);
        });

        return $this->events;
    }

    public function getFormatForDayNumberColumn($event)
    {
        $dayNumber = trim(str_replace(['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez', 'Mar', 'May', 'Dec'], '', $event['date']['start_date']));
        return $dayNumber;
    }

    public function getFormatForMonthColumn($event)
    {
        $month = substr($event['date']['start_date'], 0, strpos($event['date']['start_date'], ' '));
        $convert = $this->convertFormatForMonthColumn($month);

        return $convert;
    }

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
