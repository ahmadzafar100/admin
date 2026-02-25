<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-user-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::with('roles', 'permissions')->get();

        foreach ($users as $user) {
            $roles = $user->getRoleNames()->implode(', ');
            $perms = $user->getAllPermissions()->pluck('name')->implode(', ');
            $this->line("User: {$user->name} | Roles: {$roles} | Permissions: {$perms}");
        }
    }
}
