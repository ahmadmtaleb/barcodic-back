<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->delete();
        $json = File::get("database/data/items.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          Item::create(array(
            'english_name' => $obj->english_name,
            'arabic_name' => $obj->arabic_name,
            'barcode' => $obj->barcode,
            'price' => $obj->price,
            'brand' => $obj->brand,
            'category_id' => $obj->category_id,
          ));
      }
    }
}
