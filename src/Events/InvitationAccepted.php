<?php

namespace MuaRachmann\Invitation\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MuaRachmann\Invitation\Models\Invitation;

class InvitationAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
