<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Security\Models\User;

class UserFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_user_instance(): void
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotEmpty($user->name);
    }

    #[Test]
    public function it_generates_valid_user_attributes(): void
    {
        $user = User::factory()->make();

        $this->assertIsString($user->name);
        $this->assertIsString($user->email);
        $this->assertNotEmpty($user->password);
        $this->assertNotNull($user->email_verified_at);
    }

    #[Test]
    public function it_generates_valid_email_format(): void
    {
        $user = User::factory()->make();

        $this->assertMatchesRegularExpression('/^[^@]+@[^@]+\.[^@]+$/', $user->email);
    }

    #[Test]
    public function it_generates_unique_emails_for_multiple_users(): void
    {
        $users = User::factory()->count(10)->make();
        $emails = $users->pluck('email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)));
    }

    #[Test]
    public function it_hashes_the_password(): void
    {
        $user = User::factory()->make();

        $this->assertNotEquals('password', $user->password);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    #[Test]
    public function it_generates_remember_token(): void
    {
        $user = User::factory()->make();

        $this->assertNotNull($user->remember_token);
        $this->assertEquals(10, strlen($user->remember_token));
    }

    #[Test]
    public function it_can_create_unverified_user(): void
    {
        $user = User::factory()->unverified()->make();

        $this->assertNull($user->email_verified_at);
    }

    #[Test]
    public function it_can_override_user_attributes(): void
    {
        $customName = 'John Doe';
        $customEmail = 'john@example.com';

        $user = User::factory()->make([
            'name' => $customName,
            'email' => $customEmail,
        ]);

        $this->assertEquals($customName, $user->name);
        $this->assertEquals($customEmail, $user->email);
    }

    #[Test]
    public function it_can_create_multiple_users(): void
    {
        $users = User::factory()->count(5)->make();

        $this->assertCount(5, $users);
        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
        }
    }

    #[Test]
    public function it_sets_email_verified_at_by_default(): void
    {
        $user = User::factory()->make();

        $this->assertNotNull($user->email_verified_at);
    }
}