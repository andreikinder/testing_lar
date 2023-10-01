<?php

namespace Tests\Feature;

use App\Mail\SupportTiket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ValidationRequestTiket extends TestCase
{




    /**
     *
     * @test
     */
    public function it_send_a_support_email()
    {
        Mail::fake();
        $this->post('/api/support',
            $fields = $this->vaildValue()
        );
        Mail::assertSent(SupportTiket::class, function ($mail) use ($fields){
            return $mail->sender == $fields['email'];
        });
    }

    /**
     *
     * @test
     */
    public function it_requires_a_name()
    {
        $this->contact(['name' => ''])->assertSessionHasErrors('name');
    }

    /**
     *
     * @test
     */
    public function it_requires_a_email()
    {
        $this->contact(['email' => ''])->assertSessionHasErrors('email');
    }

    /**
     *
     * @test
     */
    public function it_vaild_email()
    {
       $this->contact(['email' => 'some'])->assertSessionHasErrors('email');
    }


    /**
     *
     * @test
     */
    public function it_require_a_question()
    {
        $this->contact(['question' => ''])->assertSessionHasErrors('question');
    }

    /**
     *
     * @test
     */
    public function it_require_a_verification()
    {
        $this->contact(['verification' => ''])->assertSessionHasErrors('verification');
    }


    /**
     *
     * @test
     */
    public function it_vaild_a_verification()
    {
        $this->contact(['verification' => 3])->assertSessionHasErrors('verification');
    }



    public function contact($attributes) {
        $this->withExceptionHandling();
        return $this->post('/api/support',
            $this->vaildValue($attributes)
        );
    }

    public function vaildValue($overrides = []) : array
    {
        return array_merge([
            'name'          => 'john doe',
            'email'         => 'john@email.com',
            'question'      => 'What can me do with this',
            'verification'  => 5,
        ], $overrides);
    }
}
