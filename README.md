```bash
SERP_API_KEY=
## Google Events this month
$events = (new \GrassFeria\LaravelSerpApi\Services\GoogleEvents('de','saalfeld'))->getEventsFromGoogleThisMonth();
## Google Events next month
$events = (new \GrassFeria\LaravelSerpApi\Services\GoogleEvents('de','saalfeld'))->getEventsFromGoogleNextMonth();

```

# Google News
```bash
$news = (new \GrassFeria\LaravelSerpApi\Services\GoogleNews('de','saalfeld news'))->getGoogleNews();
```

```bash
<x-starterkid-frontend::newslist heading="Aktuelle Neuigkeiten in Saalfeld">

@foreach($news as $item)
<x-starterkid-frontend::newslist-item :firstLoop="$loop->first"
title="{{$item['title']}}" 
dateForHumans="{{\Carbon\Carbon::createFromFormat('m/d/Y, h:i A, P T', $item['date'])->diffForHumans()}}"
imgSrc="{{$item['source']['icon']}}"
imgAlt="{{$item['title']}}"
href="{{$item['link']}}"
linkTitle="{{$item['title']}}"

/>
@endforeach

</x-starterkid-frontend::newslist>
```
