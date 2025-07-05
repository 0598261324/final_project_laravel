<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'slug' => 'test-post',
            'status' => 'draft'
        ]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_post_belongs_to_category()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'slug' => 'test-post',
            'status' => 'draft'
        ]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }

    public function test_post_can_be_published()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'slug' => 'test-post',
            'status' => 'draft'
        ]);

        $this->assertEquals('draft', $post->status);

        $post->status = 'published';
        $post->published_at = now();
        $post->save();

        $this->assertEquals('published', $post->fresh()->status);
        $this->assertNotNull($post->fresh()->published_at);
    }
}
