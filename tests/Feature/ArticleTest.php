<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 「いいね」されていない場合のテスト
     * 期待値：false
     *
     * @return void
     */
    public function testIsLikedByNull()
    {
        // Arrange
        $article = factory(Article::class)->create();

        // Act
        $result = $article->isLikedBy(null);

        // Assert
        $this->assertFalse($result);
    }

    /**
     * 「いいね」されている場合のテスト
     * 期待値：true
     *
     * @return void
     */
    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    /**
     * 他の人が「いいね」しているパターン
     * 期待値：false
     *
     * @return void
     */
    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
