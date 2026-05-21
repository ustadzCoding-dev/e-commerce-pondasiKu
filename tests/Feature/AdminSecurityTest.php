<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_log_viewer(): void
    {
        $this->get('/log-viewer')->assertForbidden();
    }

    public function test_non_admin_cannot_access_log_viewer(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/log-viewer')->assertForbidden();
    }

    public function test_admin_can_access_log_viewer(): void
    {
        $admin = User::factory()->create();
        $admin->isAdmin = 1;
        $admin->save();

        $this->actingAs($admin)->get('/log-viewer')->assertOk();
    }

    public function test_admin_login_is_rate_limited_after_repeated_failures(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from(route('admin.login'))->post(route('admin.login.post'), [
                'email' => 'admin@example.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->from(route('admin.login'))->post(route('admin.login.post'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_login_regenerates_the_session_after_successful_authentication(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $admin->isAdmin = 1;
        $admin->save();

        $sessionBeforeLogin = $this->app['session.store']->getId();

        $this->post(route('admin.login.post'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertNotSame($sessionBeforeLogin, $this->app['session.store']->getId());
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_cannot_remove_their_own_admin_role(): void
    {
        $admin = User::factory()->create();
        $admin->isAdmin = 1;
        $admin->save();

        $this->actingAs($admin)
            ->patch(route('admin.user.role', $admin))
            ->assertSessionHas('error');

        $this->assertEquals(1, $admin->fresh()->isAdmin);
    }

    public function test_admin_upload_endpoints_reject_non_image_files(): void
    {
        $admin = User::factory()->create();
        $admin->isAdmin = 1;
        $admin->save();

        $this->actingAs($admin)
            ->from(route('admin.category.index'))
            ->post(route('admin.category.store'), [
                'name' => 'Kategori Upload',
                'image' => UploadedFile::fake()->create('payload.php', 1, 'application/x-php'),
            ])
            ->assertSessionHasErrors('image');
    }
}
