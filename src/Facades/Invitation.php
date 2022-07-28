<?php

namespace MuaRachmann\Invitation\Facades;

use Illuminate\Support\Facades\Facade;
use MuaRachmann\Invitation\Contracts\CanBeInvited;

class Invitation extends Facade
{
    /**
     * @see \Muarachmann\Invitation\Invitation
     * @method static string sendInvitationLink(CanBeInvited $invitable)
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-invitations';
    }
}
