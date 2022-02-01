<?php

namespace MuaRachmann\Invitations\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MuaRachmann\Invitations\Models\Invitation;

class InvitationExpired
{
    use Dispatchable, SerializesModels;

    public Invitation $invitation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }
}
