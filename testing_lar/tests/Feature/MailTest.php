<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;

use Tests\MailTracking;
use Tests\TestCase;

class MailTest extends TestCase
{


    use MailTracking;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_basic_example()
    {


        Mail::raw('Hello World', function ($message) {
            $message->to('foo@bar.com');
            $message->from('bar@bar.com');
        });

        Mail::raw('Hello World', function ($message) {
            $message->to('foo@bar.com');
            $message->from('bar@bar.com');
        });

        $this->seeEmailsSent(2)
            ->seeEmailTo('foo@bar.com')
            ->seeEmailFrom('bar@bar.com')
            ->seeEmailEquals('Hello World')
            ->seeEmailContain('Hell');

//        $this->seeEmailNotWasSent();

    }



}

