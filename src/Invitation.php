<?php

namespace MuaRachmann\Invitation;

use Carbon\Carbon;
use MuaRachmann\Invitation\Contracts\CanBeInvited;
use MuaRachmann\Invitation\Contracts\InvitationsInterface;
use MuaRachmann\Invitation\Events\InvitationAccepted;
use MuaRachmann\Invitation\Events\InvitationDeclined;
use MuaRachmann\Invitation\Events\InvitationSent;
use MuaRachmann\Invitation\Models\Invitation as InvitationModel;

class Invitation implements InvitationsInterface
{
    protected bool $dispatch_events = true;

    /**
     * When used, no events are being dispatched.
     * @return Invitation
     */
    public function withoutEvents(): self
    {
        $this->dispatch_events = false;

        return $this;
    }


    /**
     * Create invitation with given data.
     * @param CanBeInvited $invitee
     * @param int|null $expires_at
     * @return InvitationModel
     */
    public function invite(CanBeInvited $invitee, ?int $expires_at = null): InvitationModel
    {
        $model = app(config('laravel-invitations.invitation_model', InvitationModel::class));
        do {
            $code = md5(uniqid('', true));
        } while ($model->where('code', $code)->first() instanceof $model);

        $invitation = $this->hasInvitation($invitee);

        if ($invitation) {
            return $invitation;
        }

        $invitation = $model->create([
            'code' => $code,
            'email' => $invitee->getInvitationEmail(),
            'invitee_id' => $invitee->id,
            'invitee_type' => get_class($invitee),
            'expires_at' => Carbon::now()
                ->addHours($expires_at ?? config('laravel-invitations.expires_at')),
        ]);

        if ($this->shouldDispatchEvents()) {
            event(new InvitationSent($invitation));
        }

        return $invitation;
    }

    /**
     * Accept an Invitation. The invitation, however, must be active, not accepted till now and still not expired!
     * @param InvitationModel $invitation
     * @return bool
     */
    public function accept(InvitationModel $invitation): bool
    {
        if($invitation->isExpired()) {
            return false;
        }

        $invitation->status = 'accepted';
        $invitation->save();

        if ($this->shouldDispatchEvents()) {
            event(new InvitationAccepted($invitation));
        }

        return true;
    }

    /**
     * Decline an Invitation. The invitation, however, must be active, not accepted till now and still not expired!
     * @param InvitationModel $invitation
     * @return bool
     */
    public function decline(InvitationModel $invitation): bool
    {
        if ($this->isValid($invitation)) {
            $invitation->status = 'canceled';
            $invitation->save();

            if ($this->shouldDispatchEvents()) {
                event(new InvitationDeclined($invitation));
            }
        }
        return true;
    }

    /**
     * Determine if events should be dispatched
     * @return bool
     */
    private function shouldDispatchEvents(): bool
    {
        return $this->dispatch_events;
    }


    /**
     * Checks, if there is an active invitation for this email address
     * @param CanBeInvited $invitee
     * @return InvitationModel|null
     */
    public function hasInvitation(CanBeInvited $invitee): ?InvitationModel
    {
        return InvitationModel::where('email', $invitee->getInvitationEmail())
            ->where('invitee_type', get_class($invitee))->where('invitee_id', $invitee->id)
            ->where('status', 'pending')
            ->where('expires_at', '>=', Carbon::now())
            ->first();
    }

    /**
     * Check if invitation is valid
     * @param InvitationModel $invitation
     * @return bool
     */
    public function isValid(InvitationModel $invitation): bool
    {
        return ! $invitation->isExpired() && $invitation->isPending();
    }

    /**
     * Extend an Invitation for another x $hours
     *
     * @param InvitationModel $invitation
     * @param int|null $hours
     * @return bool
     */
    public function extend(InvitationModel $invitation, ?int $hours = 48): bool
    {
        if ($this->isValid($invitation)) {
            $invitation->expires_at = $invitation->expires_at ?
                $invitation->expires_at->addHours($hours) : Carbon::now()->addHours($hours);
            $invitation->save();
        }
        return true;
    }
}
