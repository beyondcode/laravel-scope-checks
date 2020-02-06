<?php

namespace BeyondCode\LaravelScopeChecks\Tests;

use BeyondCode\LaravelScopeChecks\HasScopeChecks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;

class HasScopeChecksTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('active')->default(false);
        });

        TestModel::forceCreate([
            'name' => 'Marcel',
            'email' => 'marcel@beyondco.de',
            'password' => '',
            'active' => true,
        ]);

        TestModel::forceCreate([
            'name' => 'Inactive',
            'email' => 'inactive@beyondco.de',
            'password' => '',
            'active' => false,
        ]);
    }

    /** @test */
    public function it_can_perform_check_methods()
    {
        $this->assertCount(1, TestModel::active()->get());

        $user = TestModel::find(1);

        $this->assertTrue($user->isActive());

        $user = TestModel::find(2);

        $this->assertFalse($user->isActive());
    }

    /** @test */
    public function it_can_perform_check_methods_with_parameters()
    {
        $user = TestModel::find(1);

        $this->assertTrue($user->hasEmail('marcel'));

        $user = TestModel::find(2);

        $this->assertFalse($user->hasEmail('marcel'));
    }
}

class TestModel extends Model
{
    use HasScopeChecks;

    protected $table = 'users';

    public function scopeActive($query)
    {
        $query->where('active', true);
    }

    public function scopeEmail($query, $email)
    {
        $query->where('email', 'LIKE', $email.'%');
    }
}
