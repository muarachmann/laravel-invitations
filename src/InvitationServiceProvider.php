<?php

namespace MuaRachmann\Invitation;

use Illuminate\Support\ServiceProvider;
use MuaRachmann\Invitation\Console\Commands\DeleteExpiredInvitationsCommand;

class InvitationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->publishConfig();

            $this->loadMigrations();

            $this->loadCommands();
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->app->bind('laravel-invitations', Invitation::class);
    }

    /**
     * Publishes the package configuration file.
     */
    private function publishConfig(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-invitations.php' => config_path('laravel-invitations.php'),
        ], 'laravel-invitations-config');
    }

    /**
     * Load commands to delete expired invitations
     */
    private function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteExpiredInvitationsCommand::class,
            ]);
        }
    }

    /**
     * Load the package migrations.
     */
    private function loadMigrations(): void
    {
        if (! class_exists('CreateInvitationsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_invitations_table.php' =>
                    database_path('migrations/' . date('Y_m_d_His', time()) .
                        '_create_invitations_table.php'),
            ], 'laravel-invitations-migrations');
        }
    }
}
