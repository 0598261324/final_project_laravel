<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_have_posts()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $post = Post::create([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'slug' => 'test-post',
            'status' => 'draft'
        ]);

        $this->assertTrue($category->posts->contains($post));
        $this->assertEquals(1, $category->posts->count());
    }

    public function test_category_name_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create([
            'slug' => 'test-category'
        ]);
    }

    public function test_category_has_correct_slug()
    {
        $category = Category::create([
            'name' => 'Test Category Name',
            'slug' => 'test-category-name'
        ]);

        $this->assertEquals('test-category-name', $category->slug);
    }
}
