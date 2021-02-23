<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration{
    public function up(){
        Schema::create('kategoris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("baslik");
            $table->string("url");
            $table->integer("sira")->default(0);
            $table->string("resim");
            $table->timestamps();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->foreign('kategori_id')->references('id')->on('kategoris');
        });
    }
    public function down(){
        Schema::dropIfExists('kategoris');
    }
}
