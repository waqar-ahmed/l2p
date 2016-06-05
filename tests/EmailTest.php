<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailTest extends TestCase
{
    /**
     * A basic test example.
     * returns unauthorized exception
     * @return void
     */
    public function testAddEmail()
    {
        $this->withoutMiddleware();
        
        $response = $this->call('POST', '/add_email', [
            'cid' => '16ss-55492', 
            'recipent'=>'managers;tutors;students;', 
            'subject'=>'This is a sample email.',  
            'body'=> 'This is a sample email.',]);             
        $response = json_decode($response);                
        $this->assertFalse($response['Status']);                
    }
}
