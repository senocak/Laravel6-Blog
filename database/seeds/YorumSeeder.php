<?php

use App\Yorum;
use Illuminate\Database\Seeder;

class YorumSeeder extends Seeder{
    public function run(){
        $json = File::get("database/veriler/yorums.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Yorum::create(array(
            'id' => $obj->id,
            'email' => $obj->email,
            'body' => $obj->body,
            'onay' => $obj->onay,
            'yazi_id' => $obj->yazi_id
          ));
        }
    }
}
