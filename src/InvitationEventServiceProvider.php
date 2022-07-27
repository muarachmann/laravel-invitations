<?php

namespace MuaRachmann\Invitation;

use Illuminate\Support\ServiceProvider;
use MuaRachmann\Invitation\Events\InvitationAccepted;
use MuaRachmann\Invitation\Events\InvitationDeclined;
use MuaRachmann\Invitation\Events\InvitationSent;
use MuaRachmann\Invitation\Events\InvitationExpired;

class InvitationEventServiceProvider extends ServiceProvider
{
    public array $listen = [
        InvitationAccepted::class => [],
        InvitationDeclined::class => [],
        InvitationSent::class => [],
        InvitationExpired::class => [],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
