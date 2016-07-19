<?php

class AnnouncementTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddAnnouncement()
    {
        $this->withoutMiddleware();

        
        $response = $this->call('POST', 'course/16ss-55492/add_announcement', [            
            'body'=>'This is a sample announcement2.', 
            'expiretime'=>123456789,  
            'title'=> 'This is a sample announcement2.',]);                             
//        echo $response->content();
        
//        $this->assertEquals(200, $response->status());                
    }
}
