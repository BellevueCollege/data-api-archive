<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class SubjectControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        //test subject index
        $this->get('/v1/subject')
            ->seeJson([
                /*'areas' => [],*/
                'area' => 'HIST'
            ]);

        $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetSubject()
    {
        //Try valid subjects
        $this->get('/v1/subject/ENGR')
            ->seeJson([
                'area' => 'ENGR', 
                'name' => 'Engineering'
            ]);
        
        $this->assertEquals(200, $this->response->getStatusCode());
            
        $this->get('/v1/subject/ACCT&')
            ->seeJson([
                'area' => 'ACCT&', 
                'name' => 'Accounting-Transfer'
            ]);
            
        $this->assertEquals(200, $this->response->getStatusCode());
       
        $this->get('/v1/subject/ADFIT')
            ->seeJson([
                'area' => 'ADFIT', 
                'name' => 'Adult Fitness'
            ]);
            
        $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetSubjectBadSubject() {
        //try invalid subject, should return empty json
        $response = $this->call('GET', '/v1/subject/xyzsdf');
        
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    public function testGetSubjectsByYearQuarter() 
    {
        //try with valid quarter
        $this->get('v1/catalog/catalogAreas/B563');
        
        $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetSubjectsByYearQuarterBadYQR(){
        //try with invalid quarter, should return empty json
        $this->get('v1/catalog/catalogAreas/xyzsdf');
        
        $this->assertEquals(200, $this->response->getStatusCode());
    }
}