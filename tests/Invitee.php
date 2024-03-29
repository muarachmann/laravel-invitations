<?php

namespace MuaRachmann\Invitation\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MuaRachmann\Invitation\Contracts\CanBeInvited;

class Invitee extends Authenticatable implements CanBeInvited
{
    use Notifiable;

    protected $guarded = [];

    protected $fillable = ["name", "email"];

    public function getInvitationEmail(): string
    {
        return $this->email;
    }
}
