<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class EventFilters

{
    
    public $events;
    
    
    public function __construct(array $events)
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
}
