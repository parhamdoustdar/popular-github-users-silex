<?php
namespace App\Services;

class TopCreatorsRetriever
{
    
    /**
     * @var UserSearcher
     */
    protected $searcher;
    
    /**
     * @var StarGazerCalculator
     */
    protected $calculator;
    
    public function __construct(UserSearcher $searcher, StarGazerCalculator $calculator)
    {
        $this->searcher = $searcher;
        $this->calculator = $calculator;
    }
    
    public function retrieve($location, $language)
    {
        $usernames = $this->searcher->retrieveByLocationAndLanguage($location, $language);
        $map = $this->createUserStarGazerMap($usernames);
        
        return $this->sortMapByStarGazers($map);
    }
    
    protected function createuserStarGazerMap(array $usernames)
    {
        $results = [];
        
        foreach ($usernames as $username) {
            $results[$username] = $this->calculator->calculateStarGazersByUsername($username);
        }
        
        return $results;
    }
    
    protected function sortMapByStarGazers(array $map)
    {
        arsort($map, SORT_NUMERIC);
        
        return $map;
    }
    
}
