<?php

namespace MuaRachmann\Invitation\Contracts;

interface CanBeInvited
{
    public function getInvitationEmail(): string;
}
