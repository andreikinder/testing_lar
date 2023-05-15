<?php

namespace Tests\Feature;

use App\Models\Article;
use Database\Factories\ArticleFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;
    /** @test   */
    public function it_fetches_trending_articles()
    {

        //Given

        Article::factory(3)->create();
        Article::factory()->create(['reads' => 10]);
        $mostPopular = Article::factory()->create(['reads' => 20]);

        // When
        $articles = Article::trending()->get();

        // Then

        $this->assertEquals($mostPopular->id, $articles->first()->id );
        $this->assertCount( 3, $articles);

    }
}
