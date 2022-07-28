<?php

namespace MuaRachmann\Invitations\Tests\Commands;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use MuaRachmann\Invitation\Events\InvitationDeleted;
use MuaRachmann\Invitation\Facades\Invitation;
use \MuaRachmann\Invitation\Models\Invitation as Invites;
use MuaRachmann\Invitation\Tests\Invitee;
use MuaRachmann\Invitation\Tests\TestCase;

class DeleteExpiredInvitationsCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks if event is fired after calling the command
     * @test
     */
    public function test_it_dispatch_invitation_delete_event_when_invites_are_deleted()
    {
        Event::fake();

        $invitee = Invitee::create([
            "name" => "Mua Rachmann",
            "email" => "muarachmann@gmail.com"
        ]);

        $invitation = Invitation::invite($invitee);

        $this->assertCount(1, Invites::all());

        // simulate event that has expired
        $invitation->expires_at = Carbon::now()->subDays(2);
        $invitation->save();

        Artisan::call('invitations:clear');

        $this->assertCount(0, Invites::all());

        Event::assertDispatched(InvitationDeleted::class);
    }
}
