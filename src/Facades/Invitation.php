<?php

namespace MuaRachmann\Invitations\Facades;

use Illuminate\Support\Facades\Facade;
use MuaRachmann\Invitations\Contracts\CanBeInvited;

class Invitation extends Facade
{
    /**
     * @see \Muarachmann\Invitations\Invitation
     *
     * @method static string sendInvitationLink(CanBeInvited $invitable)
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-invitations';
    }
}
