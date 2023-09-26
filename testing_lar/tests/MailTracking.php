<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Swift_Events_EventListener;


trait MailTracking
{

    protected $emails = [];


    protected function setUp(): void
    {

//        Mail::getSwiftMailer()
//            ->registerPlugin(new TestingMailEventListener($this));
        parent::setUp();
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }


    public function seeEmailWasSent()
    {
        $this->assertNotEmpty($this->emails, 'No emails has been sent');
        return $this;

    }

    public function seeEmailNotWasSent()
    {
        $this->assertEmpty($this->emails, 'Did not expect any emails have been sent ');
        return $this;

    }

    public function seeEmailEquals($body, \Swift_Message $message = null)
    {
        $email = $message ?? end($this->emails);
        $this->assertEquals(
            $body , $email->getBody(),
            "No email with the provider body was sent"
        );
        return $this;
    }


    public function seeEmailContain($excerpt, \Swift_Message $message = null)
    {
        $email = $message ?? end($this->emails);
        $this->assertStringContainsString (
            $excerpt , $email->getBody(),
            "No email with the provider contain body was sent"
        );
        return $this;
    }



    public function addEmail(\Swift_Message $email)
    {
        $this->emails []= $email;
    }

    protected function seeEmailsSent($count)
    {
        $emailsCount = count($this->emails);
        $this->assertCount( $count, $this->emails, "Expected $count emails to have been sent, but emails sent were $emailsCount");
        return $this;
    }

    protected function seeEmailTo($recipt, $message = null){

        $email = $message ?? end($this->emails);
        $this->assertArrayHasKey($recipt, $email->getTo());
        return $this;
    }

    protected function seeEmailFrom($sender, $message = null){

        $email = $message ?? end($this->emails);
        $this->assertArrayHasKey($sender, $email->getFrom());
        return $this;
    }
}

class TestingMailEventListener implements Swift_Events_EventListener {

    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event) {
        $this->test->addEmail($event->getMessage());
    }
}
