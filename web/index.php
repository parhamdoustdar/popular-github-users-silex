<?php
require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use App\Providers\TopCreatorsRetrieverServiceProvider;

$app = new Application();
$app['debug'] = true;
$app->register(new TopCreatorsRetrieverServiceProvider());

$app->get('/creators/{location}/{language}', function (Application $app, $location, $language) {
    $data = $app['topCreatorsRetriever']->retrieve($location, $language);
    return $app->json($data);
});

$app->run();
