<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class LikTest extends TestCase
{


    use DatabaseTransactions;

    /**
     * @test
     */
    public function a_user_can_like_a_post()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $post->like();

        $this->assertDatabaseHas(
           'likes', [
                'user_id'       => $user->id,
                'likeable_id'   => $post->id,
                'likeable_type' => get_class($post)
            ]
        );

        $this->assertTrue($post->isLiked());
    }


    /**
     * @test
     */
    public function a_user_can_unlike_a_post()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $post->like();
        $post->unlike();

        $this->assertDatabaseMissing(
            'likes', [
                'user_id'       => $user->id,
                'likeable_id'   => $post->id,
                'likeable_type' => get_class($post)
            ]
        );

        $this->assertFalse($post->isLiked());
    }


    /**
     * @test
     */
    public function a_user_can_toggle_like_a_post()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $post->toggle();
        $this->assertTrue($post->isLiked());

        $post->toggle();
        $this->assertFalse($post->isLiked());

    }

    /**
     * @test
     */
    public function a_post_know_how_many_likes_it_has()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $post->toggle();

        $this->assertEquals(1, $post->likesCount);


    }


}
