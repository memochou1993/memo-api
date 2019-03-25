<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(config('default.factories.user'));

        factory(User::class, config('default.seeds.user.number'))->create();
    }
}
