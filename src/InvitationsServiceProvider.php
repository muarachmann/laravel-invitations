<?php

namespace MuaRachmann\Invitations;

use Illuminate\Support\ServiceProvider;

class InvitationsServiceProvider extends ServiceProvider
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
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-invitations.php', 'laravel-invitations');

        // Register the service the package provides.
        $this->app->singleton('laravel-invitations', function ($app) {
            return new Invitation;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-invitations'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/laravel-invitations.php' => config_path('laravel-invitations.php'),
        ], 'config');

        if (! class_exists('CreateInvitationsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_invitations_table.php' =>
                    database_path('migrations/' . date('Y_m_d_His', time()) .
                        '_create_invitations_table.php'),
            ], 'migrations');
        }

        // Registering package commands.
        // $this->commands([]);
    }
}
