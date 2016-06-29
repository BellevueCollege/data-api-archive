<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class YearQuarterControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        /*
        Currently no route for this function
        */
    }
    
    public function testGetYearQuarter()
    {
        //try valid terms
        $this->get('/v1/catalog/terms/B563')
            ->seeJson([
                'code' => 'B563', 
                'description' => 'Win 2016'
            ]);
        $this->assertEquals(200, $this->response->getStatusCode());
          
        $this->get('/v1/catalog/terms/B671')
            ->seeJson([
                'code' => 'B671', 
                'description' => 'Sum 2016'
            ]);
            
       $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetYearQuarterBadYQR() {
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/terms/xysdf');
       
       $this->assertEquals(200, $this->response->getStatusCode()); 
    }
    
    public function testGetCurrentYearQuarter() {
        //test valid YQR
        $response = $this->call('GET', 'v1/quarters/current');
        
        $this->assertEquals(200, $this->response->getStatusCode());
        
        //var_dump($response->content());
    }
    
    public function testGetViewableYearQuarters() {
        //test endpoint to get viewable YQRs
        $response = $this->call('GET', 'v1/catalog/terms');
        
        $this->assertEquals(200, $this->response->getStatusCode());
        
        //var_dump($response->content());
    }
}