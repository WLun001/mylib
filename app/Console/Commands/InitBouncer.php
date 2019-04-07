<?php

namespace App\Console\Commands;

use http\Client\Curl\User;
use Illuminate\Console\Command;
use Silber\Bouncer\Bouncer;
use Silber\Bouncer\Conductors\AssignsRoles;

class InitBouncer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:bouncer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise roles and abilities';

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
     * @return mixed
     */
    public function handle()
    {
        // define roles
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator'
        ]);

        $staff = Bouncer::role()->create([
            'name' => 'staff',
            'title' => 'Staff'
        ]);

        $member = Bouncer::role()->create([
            'name' => 'member',
            'title' => 'Member'
        ]);

        // define abilities
        $manageUsers = Bouncer::ability()->create([
            'name' => 'manage-user',
            'title' => 'Manage Users'
        ]);

        $manageBooks = Bouncer::ability()->create([
            'name' => 'manage-book',
            'title' => 'Manage Books',
        ]);

        $viewBooks = Bouncer::ability()->create([
            'name' => 'view-book',
            'title' => 'View Books'
        ]);

        // assign abilities to roles
        Bouncer::allow($admin)->to($manageUsers);
        Bouncer::allow($admin)->to($manageBooks);
        Bouncer::allow($admin)->to($viewBooks);
        Bouncer::allow($staff)->to($manageBooks);
        Bouncer::allow($staff)->to($viewBooks);
        Bouncer::allow($member)->to($viewBooks);


        // assign role to users
        $user = User::where('email', 'admin@mylib.info')->first();
        Bouncer::assign($admin)->to($user);

        $user = User::where('email', 'user1@mylib.info')->first();
        Bouncer::assign($staff)->to($user);

        $user = User::where('email', 'user2@mylib.info')->first();
        Bouncer::assign($member)->to($user);
    }
}
