<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersSeeder');

        Model::reguard();
    }
}

    class UsersSeeder extends Seeder
    {
        public function run()
        {
            DB::table('users')->delete();

            //test data
            User::create([
                'name' => '濱田　真旗',
                'kana' =>  'テスト　タロウ',
                'email' => 'b5163@oic.jp',
                'birthday' => 19960507,
                'access_token' => 'himitu',
                'refresh_token' => 'naisyo',

                ]);
        }
    }
