<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Yazı extends Migration{
    public function up(){
        Schema::create('yazis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("baslik");
            $table->string("url");
            $table->text("icerik");
            $table->unsignedBigInteger("kategori_id");
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->text("etiketler");
            $table->integer("aktif")->default(1);
            $table->integer("sira")->default(0);
            $table->integer("onecikarilan")->default(0);
            $table->string("github_repo")->nullable();
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('yazis');
    }
}
