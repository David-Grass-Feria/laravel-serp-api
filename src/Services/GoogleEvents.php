<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class GoogleEvents

{
    
    public $api_key;
    public $gl;
    public $city;
    
    public function __construct(string $gl, string $city)
    {
        $this->api_key          = config('laravel-serp-api.serp_api_key');
        $this->gl               = $gl;
        $this->city             = $city;
    }
    
    
    
    
    public function getEventsFromGoogleThisMonth()
    {
        $parameters = array_merge([
            'engine' => 'google_events',
            'api_key' => config('laravel-serp-api.serp_api_key'),
            'gl' => $this->gl,
            'q' => 'events in '.$this->city,
            'htichips' => 'date:month',
        ]);

        $response = Http::get('https://serpapi.com/search.json', $parameters);

        $data = $response->json();
       
        $events = $data['events_results'];
        
        // remove duplicates and remove other cities
        $eventsWithoutDuplicates = $this->removeDuplicates($events);
        // sort events by date
        $sortedEventsByDate = $this->sortEventsByDate($eventsWithoutDuplicates);
         // add day column to the array
         $addDayColumnToEventsArray = $this->createDayNumberColumnInArray($sortedEventsByDate);
          // add month column to the array
          $addMonthToEventsArray = $this->createMonthColumnInArray($addDayColumnToEventsArray);
          return $addMonthToEventsArray;
    }

    public function getEventsFromGoogleNextMonth()
    {
        $parameters = array_merge([
            'engine' => 'google_events',
            'api_key' => config('laravel-serp-api.serp_api_key'),
            'gl' => $this->gl,
            'q' => 'events in '.$this->city,
            'htichips' => 'date:next_month',
        ]);

        $response = Http::get('https://serpapi.com/search.json', $parameters);

        $data = $response->json();
       
        $events = $data['events_results'];
        
        // remove duplicates and remove other cities
        $eventsWithoutDuplicates = $this->removeDuplicates($events);
        // sort events by date
        $sortedEventsByDate = $this->sortEventsByDate($eventsWithoutDuplicates);
         // add day column to the array
         $addDayColumnToEventsArray = $this->createDayNumberColumnInArray($sortedEventsByDate);
          // add month column to the array
          $addMonthToEventsArray = $this->createMonthColumnInArray($addDayColumnToEventsArray);
          return $addMonthToEventsArray;
    }

    public function removeDuplicates($events)
    {
        $addressCheck = [];
        foreach ($events as $key => $event) {
            if (!str_contains(strtolower($event['address'][1]), $this->city) || in_array($event['address'][0], $addressCheck)) {
                unset($events[$key]);
            } else {
                $addressCheck[] = $event['address'][0];
            }
        }

        return $events;
    }
    
    
    public function sortEventsByDate($events)
    {
        $germanMonths = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dez'];
        $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        foreach ($events as &$event) {
            $date = $event['date']['start_date'];
            foreach ($germanMonths as $index => $germanMonth) {
                if (strpos($date, $germanMonth) !== false) {
                    $date = str_replace($germanMonth, $englishMonths[$index], $date);
                    $event['date']['start_date'] = $date;
                    break;
                }
            }
        }

        usort($events, function ($a, $b) {
            return strtotime($a['date']['start_date']) <=> strtotime($b['date']['start_date']);
        });

        return $events;
    }

    public function createDayNumberColumnInArray($events)
    {
        
        foreach($events as $key => $event){
            $dayNumber = trim(str_replace(['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez', 'Mar', 'May', 'Dec'], '', $event['date']['start_date']));
            $events[$key]['day'] = $dayNumber;
            
        }

        return $events;
        
    }

    public function createMonthColumnInArray($events)
    {
        
        foreach($events as $key => $event){
            $month = substr($event['date']['start_date'], 0, strpos($event['date']['start_date'], ' '));
            $events[$key]['month'] = $month;
            
        }

        return $events;
        
    }

    

    

    
    
}
