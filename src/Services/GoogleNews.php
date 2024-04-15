<?php

namespace GrassFeria\LaravelSerpApi\Services;

use DateTime;
use Illuminate\Support\Facades\Http;

class GoogleNews

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
    
    
    
    
    public function getGoogleNews()
    {
        
        $news = [];
        
        $parameters = array_merge([
           
            'api_key' => config('laravel-serp-api.serp_api_key'),
            'engine' => 'google_news',
            'q' => $this->city,
            'gl' => $this->gl,
        ]);

        $response = Http::get('https://serpapi.com/search.json', $parameters);

        $data = $response->json();
       
        // take 10 results
        $responses = array_slice($data['news_results'], 0, 10);
        
        foreach($responses as $response){
            if(array_key_exists('stories',$response)){
                foreach($response['stories'] as $story){
                    array_push($news,$story);
                    
                }
            }else{
                array_push($news,$response);
            }
        }

        

        // remove news without thumbnail

        foreach($news as $key => $item){
            if(!array_key_exists('thumbnail',$item)){
                unset($news[$key]);
            }
        }

        
        // sort the array by date

        foreach ($news as $item) {
            $dateTime = DateTime::createFromFormat('m/d/Y, h:i A, +0000 UTC', $item['date']);
            if ($dateTime !== false) {
                $item['date'] = $dateTime->format('Y-m-d H:i:s');
            } else {
                // Handle error or set a default date
                $item['date'] = '0000-00-00 00:00:00'; // Default or error handling date
            }
        }
        
        usort($news, function($a, $b) {
            return strcmp($b['date'], $a['date']);
        });
        
        
        

        return $news;

        

        

        
       
    }

    

   
    
    
  

   

   

    

    

    
    
}
