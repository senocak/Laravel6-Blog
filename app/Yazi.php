<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Yazi extends Model{
    protected $table = "yazis";
    public function kategori(){
        return $this->belongsTo('App\Kategori');
    }
    public function yorum()    {
        return $this->hasMany('App\Yorum');
    }
}
