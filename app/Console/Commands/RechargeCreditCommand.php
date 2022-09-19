<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use App\Models\UsersCredit;
use Illuminate\Console\Command;

class RechargeCreditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to recharge user credit to default.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rolePrefix = Role::whereIn('prefix', ['regular_user', 'premium_user'])->get('id')->toArray();
        $roleIds = array_column($rolePrefix, 'id');
        $user = User::whereHas('role', function ($q) use ($roleIds) {
            $q->whereIn('role_id', $roleIds);
        })->get();
        foreach ($user as $each) {
            UsersCredit::where('user_id', $each['id'])->update([
                'credit' => UsersCredit::getDefaultUserCredit($each['id'])
            ]);
        }

        $this->info($user);
        return 0;
    }
}
