<?php
namespace App\Services;

use Github\Client;
class UserSearcher
{
    
    /**
     * @var Client
     */
    protected $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function retrieveByLocationAndLanguage($location, $language)
    {
        $searchString = "location:${location} language:${language}";
        $results = $this->fetchSearchResults($searchString, 10);
        
        return $this->extractUsernames($results);
    }
    
    protected function fetchSearchResults($searchString, $count)
    {
        $results = $this->client
            ->search()
            ->setPerPage($count)
            ->users($searchString, 'followers')
        ;
        
        return $results['items'];
    }
    
    protected function extractUsernames(array $results)
    {
        $usernames = [];
        
        foreach ($results as $result) {
            $usernames[] = $result['login'];
        }
        
        return $usernames;
    }
    
}
