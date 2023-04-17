<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink("Click")
                    ->assertSee('You are been clicked punk')
                    ->assertPathIs('/feedback');
                    //->screenshot('home')
                    //->assertSee('Laravel');
        });
    }
}
