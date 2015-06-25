<?php
namespace App\Providers;

use Silex\ServiceProviderInterface;
use Silex\Application;
use Github\Client;
use App\Services\UserSearcher;
use App\Services\StarGazerCalculator;
use App\Services\TopCreatorsRetriever;
class TopCreatorsRetrieverServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['topCreatorsRetriever'] = $app->share(function() {
            $client = new Client();
            $searcher = new UserSearcher($client);
            $calculator = new StarGazerCalculator($client);
            
            return new TopCreatorsRetriever($searcher, $calculator);
        });
    }

    public function boot(Application $app)
    {
        
    }
}
