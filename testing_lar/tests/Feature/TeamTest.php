<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class TeamTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function a_team_has_a_name()
    {
        $team = new Team(['name' => 'Acme']);

        $this->assertEquals('Acme', $team->name);
    }

    /**
     * @test
     */
    public function a_team_can_add_members()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();

        $userTwo = User::factory()->create();


        $team->add($user);
        $team->add($userTwo);

        $this->assertEquals(2, $team->count());

    }

    /**
     * @test
     */
    public function a_team_can_add_multiple_members_at_once()
    {
        $team = Team::factory()->create();
        $users = User::factory(2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());

    }

    /**
     * @test
     */
    public function a_team_has_a_maximum_size()
    {
        $team = Team::factory()->create(['size' => 2]);
        $user = User::factory()->create();

        $userTwo = User::factory()->create();


        $team->add($user);
        $team->add($userTwo);

        $this->assertEquals(2, $team->count());



        $this->expectException('Exception');

        $userThree = User::factory()->create();
        $team->add($userThree);


    }
}
