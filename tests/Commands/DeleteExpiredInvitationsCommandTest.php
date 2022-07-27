<?php

namespace MuaRachmann\Invitations\Tests\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use MuaRachmann\Invitation\Events\InvitationDeleted;
use MuaRachmann\Invitation\Facades\Invitation;
use \MuaRachmann\Invitation\Models\Invitation as Invites;
use MuaRachmann\Invitation\Tests\TestCase;
use MuaRachmann\Invitation\Tests\TestInviteeModel;

class DeleteExpiredInvitationsCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks if event is fired after calling the command
     */
    public function test_it_dispatch_invitation_delete_event_when_invites_are_deleted()
    {
        Event::fake();

        $invitee = TestInviteeModel::create([
            'name' => 'Mua Rachmann',
            'email' => 'muarachmann@gmail.com',
        ]);

        Invitation::invite($invitee);

        $this->assertCount(1, Invites::all());

        Artisan::call('invitations:clear');

        $this->assertCount(0, Invites::all());

        Event::assertDispatched(InvitationDeleted::class);
    }
}
