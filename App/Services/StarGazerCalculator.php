<?php
namespace App\Services;

use Github\Client;
class StarGazerCalculator
{
    
    /**
     * @var Client
     */
    protected $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function calculateStarGazersByUsername($username)
    {
        $repositories = $this->client->user()->repositories($username);
        $repositories = $this->filterForkedRepositories($repositories);
        
        return $this->addStarGazersFromRepositories($repositories);
    }
    
    protected function filterForkedRepositories(array $repositories)
    {
        return array_filter($repositories, function($repository) {
            return $repository['fork'] === false;
        });
    }
    
    protected function addStarGazersFromRepositories(array $repositories)
    {
        return array_reduce($repositories, function($starGazersSoFar, $repository) {
            return $starGazersSoFar + $repository['stargazers_count'];
        });
    }
    
}
