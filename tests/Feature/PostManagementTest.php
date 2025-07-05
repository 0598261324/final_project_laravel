<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create permissions
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        // Create writer role
        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo(['create posts', 'edit posts', 'delete posts']);
    }

    public function test_user_can_create_post()
    {
        $user = User::factory()->create();
        $user->assignRole('writer');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    public function test_user_cannot_create_post_without_permission()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_guest_cannot_create_post()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('login'));
    }
}
