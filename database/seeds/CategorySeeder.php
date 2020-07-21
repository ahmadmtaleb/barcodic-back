<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        $json = File::get("database/data/categories.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          Category::create(array(
            'english_name' => $obj->english_name,
            'arabic_name' => $obj->arabic_name,

          ));
      }
    }
}
