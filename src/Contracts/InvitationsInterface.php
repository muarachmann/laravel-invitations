<?php

namespace MuaRachmann\Invitation\Contracts;

use Muarachmann\Invitation\Invitation;
use MuaRachmann\Invitation\Models\Invitation as InvitationModel;

interface InvitationsInterface
{
    /**
     * Create new invitation
     * @param  CanBeInvited  $invitee  Invitee e.g . User, Organization, etc
     * @param int|null $expires_at  Expiration DateTime for the invitation
     */
    public function invite(CanBeInvited $invitee, ?int $expires_at);

    /**
     * Without events triggers
     * @return Invitation
     */
    public function withoutEvents(): Invitation;


    /**
     * Decline an invitation
     * @param InvitationModel $invitation
     * @return bool
     */
    public function decline(InvitationModel $invitation): bool;


    /**
     * Extend an invitation
     * @param InvitationModel $invitation
     * @param int|null $hours
     * @return bool
     */
    public function extend(InvitationModel $invitation, ?int $hours): bool;
}
