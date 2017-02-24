<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class EmployeeControllerTest extends TestCase
{
    
    public function testGetEmployeeByUsername() {
        //valid employee username
        $this->get('/v1/employee/nicole.swan');
        //var_dump($response);
        $this->assertEquals(200, $this->response->status());
        
    }
    
    public function testGetEmployeeByUsernameNotEmployee() {
        //valid course numbers
        $this->get('/v1/employee/student.test');
        //var_dump($this->response->getStatusCode());
        $this->assertEquals(200, $this->response->getStatusCode());
        
    }

}