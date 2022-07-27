<?php

namespace MuaRachmann\Invitation\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MuaRachmann\Invitation\Events\InvitationDeleted;

class DeleteExpiredInvitationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitations:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'removes all expired invitations from your database';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = app(config('laravel-invitations.invitation_model'));
        $invitations = $model->where('expires_at', '<=', Carbon::now(config('app.timezone')));

        $invitations->delete();

        event(new InvitationDeleted());

        $this->info("Successfully deleted all expired invitations - [{$invitations->count()}]");
        return 0;
    }
}
