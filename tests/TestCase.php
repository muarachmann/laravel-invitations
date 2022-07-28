<?php

namespace MuaRachmann\Invitation\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MuaRachmann\Invitation\InvitationServiceProvider;
use MuaRachmann\Invitation\InvitationEventServiceProvider;
use MuaRachmann\Invitation\Models\Invitation;

use Orchestra\Testbench\TestCase as Orchestra;


class TestCase extends Orchestra
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->prepateDatabase($this->app);
        (new InvitationServiceProvider($this->app))->boot();
    }

    protected function getPackageProviders($app)
    {
        return [
            InvitationServiceProvider::class,
            InvitationEventServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Prepare database for mocking tests
     * @param $app
     */
    private function prepateDatabase($app)
    {
        // invitations table
        $app['config']->set('laravel-invitations.database.invitations_table', 'test_invitations');

        // invitation model
        $app['config']->set('laravel-invitations.invitation_model', Invitation::class);

        // load migrations
        include_once __DIR__.'/../database/migrations/create_invitations_table.php';

        (new \CreateInvitationsTable())->up();

        $app['db']->connection()->getSchemaBuilder()->create('invitees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
