<?php

namespace MuaRachmann\Invitation\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


/**
 * Class Invite.
 *
 * @method static Builder expired() All expired invites.
 */
class Invitation extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(config('laravel-invitations.database.connection'));
        $this->setTable(config('laravel-invitations.database.invitations_table'));
    }

    protected $fillable = [
        'code',
        'email',
        'invitee_id',
        'invitee_type',
        'expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    /**
     * Entity that the invitation is for. e,g. User, Organization, etc.
     * @return MorphTo
     */
    public function invitee(): MorphTo
    {
        return $this->morphTo('invitee');
    }

    /**
     * Checks if the invitation has expired
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        if (empty($this->expires_at)) {
            return false;
        }

        return $this->expires_at->isPast();
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
