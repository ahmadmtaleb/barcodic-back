<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $json = File::get("database/data/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          User::create(array(
            'username' => $obj->username,
            'password' => bcrypt($obj->password),
            'role_id' => $obj->role_id,
          ));
        }
    }
}
