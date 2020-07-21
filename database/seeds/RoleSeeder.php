<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $json = File::get("database/data/roles.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          Role::create(array(
            'name' => $obj->name,
          ));
        }
    }
}
