```bash
SERP_API_KEY=
## Google Events this month
$events = (new \GrassFeria\LaravelSerpApi\Services\GoogleEvents('de','saalfeld'))->getEventsFromGoogleThisMonth();
## Google Events next month
$events = (new \GrassFeria\LaravelSerpApi\Services\GoogleEvents('de','saalfeld'))->getEventsFromGoogleNextMonth();

```
# Google News
$news = (new \GrassFeria\LaravelSerpApi\Services\GoogleNews('de','saalfeld news'))->getGoogleNews();
