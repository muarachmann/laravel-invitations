<?php

namespace MuaRachmann\Invitations\Contracts;

use Muarachmann\Invitations\Invitation;
use MuaRachmann\Invitations\Models\Invitation as InvitationModel;

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
