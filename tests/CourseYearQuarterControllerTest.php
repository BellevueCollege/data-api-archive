<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class CourseYearQuarterControllerTest extends TestCase
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
    
    public function testGetCourseYearQuarter()
    {
       //catalog/{yqrid}/{subjectid}/{coursenum}
        
       //try valid offering
       $this->get('/v1/catalog/B561/ABE/053')
            ->seeJson([
                'subject' => 'ABE', 
                'courseNumber' => '053'
            ]);
       $this->assertEquals(200, $this->response->getStatusCode());
          
       $this->get('/v1/catalog/B562/ADFIT/020')
            ->seeJson([
                'subject' => 'ADFIT', 
                'courseNumber' => '020'
            ]);
       $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetCourseYearQuarterBadYQR(){
       //try invalid term
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/xysdf/ADFIT/020');
       $this->assertEquals(200, $this->response->getStatusCode()); 
    }
   
    public function testGetCourseYearQuarterBadSubject() {    
       //try invalid subject
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/B561/xysdf/020');
       $this->assertEquals(200, $this->response->getStatusCode()); 
    }
   
    public function testGetCourseYearQuarterBadCourseNumber() {    
       //try invalid coursenum
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/B561/ADFIT/xysdf');
       $this->assertEquals(200, $this->response->getStatusCode());  
    }
    
    public function testGetCourseYearQuartersBySubject() {
        //catalog/{yqrid}/{subjectid}
        
        //try valid term and subject
        $this->get('v1/catalog/B561/ABE')
            ->seeJson([
                'subject' => 'ABE', 
            ]);
        $this->assertEquals(200, $this->response->getStatusCode());
    }
    
    public function testGetCourseYearQuartersBySubjectBadTerm() {
       //try invalid term
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/xysdf/ADFIT');
       $this->assertEquals(200, $this->response->getStatusCode()); 
    }
    
    public function testGetCourseYearQuartersBySubjectBadSubject() {
       //try invalid subject
       //should return empty object so don't need to check json, just need to make sure it doesn't error
       $this->get('/v1/catalog/B561/xysdf');
       $this->assertEquals(200, $this->response->getStatusCode()); 
        //var_dump($response->content());
    }
    
}