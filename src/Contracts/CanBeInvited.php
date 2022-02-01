<?php

namespace MuaRachmann\Invitations\Contracts;

interface CanBeInvited
{
    public function getInvitationEmail(): string;
}
