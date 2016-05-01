<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

       /* $this->assertEquals(
            $this->response->getContent(), $this->app->version()
        );*/
    }
}
