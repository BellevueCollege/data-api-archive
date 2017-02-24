<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class StudentControllerTest extends TestCase
{
    
    public function testGetStudentByUsername() {
        //valid employee username
        $this->get('v1/employee/abby.lynn');
        //var_dump($this->response->getStatusCode());
        $this->assertEquals(200, $this->response->getStatusCode());
        
    }
    
    public function testGetStudentByUsernameNotStudent() {
        //valid course numbers
        $this->get('v1/employee/nicole.swan');
        //var_dump($this->response->getStatusCode());
        $this->assertEquals(200, $this->response->getStatusCode());
        
    }

}