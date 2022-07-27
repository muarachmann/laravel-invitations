<?php

namespace MuaRachmann\Invitation\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
