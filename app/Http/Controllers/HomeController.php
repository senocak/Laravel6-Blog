<?php

namespace App\Http\Controllers;
use App\Kategori;
use App\User;
use App\Yazi;
use App\Yorum;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\View;

class HomeController extends Controller{
    private $_paginate = 11;
    public function __construct(){
        View::share('user', User::select("name","about","social","resim")->where("id",1)->firstOrFail());
        //$this->middleware('auth');
        //var_dump(exec('D:\View_Storage\xampp\mysql\bin\mysqldump --user=root --password= --host=localhost laravel_60_senocaktk --result-file=dump.sql'));
    }
    public function index(){
        return view("index");
    }
    public function blog($kategori_url = null){
        $paginate = 11;
        $kategori_one="";
        $kategoriler = Kategori::whereNull('kategori_id')->with('children')->with("yazilar")->orderBy("sira","asc")->get();
        if ($kategori_url == null) {
            $yazilar = Yazi::whereAktif(1)->with("kategori")->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->orderBy("onecikarilan","desc")->orderBy("sira","asc")->paginate($this->_paginate);
        }else{
            $kategori_one = Kategori::whereUrl($kategori_url)->firstOrFail();
            $yazilar = Yazi::where("kategori_id",$kategori_one->id)->whereAktif(1)->with("kategori")->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->orderBy("onecikarilan","desc")->orderBy("sira","asc")->paginate($this->_paginate);
        }
        //return $yazilar;
        return view("blog", ["kategoriler"=>$kategoriler, "yazilar"=>$yazilar, "kategori_one"=>$kategori_one]);
    }
    public function yazi($url){
        $kategoriler = Kategori::whereNull('kategori_id')->with('children')->with("yazilar")->orderBy("sira","asc")->get();
        $yazi = Yazi::whereUrl($url)->with("kategori")->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->firstOrFail();
        return view("yazi", ["kategoriler"=>$kategoriler, "yazi" => $yazi]);
    }
    public function yorum(Request $request, $url){
        $yazi = Yazi::whereUrl($url)->firstOrFail();
        $email = $request->email;
        $body = $request->body;
        $yorum = new Yorum();
        $yorum->email = $email;
        $yorum->body = $body;
        $yorum->yazi_id = $yazi->id;
        $yorum->save();
        return Response::json(['mesaj'=>"Yorumunuz Onaylandıktan Sonra Yayınlanacaktır..."],201);
    }
    public function apiBlog(Request $request){
        if ($request->page < 2) {
            $offset = 0;
        }else{
            $offset = ($request->page-1)*$this->_paginate;
        }
        if ($request->kategori) {
            $kategori_one = Kategori::whereUrl($request->kategori)->firstOrFail();
            $yazilar = Yazi::where("kategori_id",$kategori_one->id)->whereAktif(1)->with("kategori")->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->orderBy("onecikarilan","desc")->orderBy("sira","asc")->offset($offset)->limit($this->_paginate)->get();
            $yazilar_count = Yazi::where("kategori_id",$kategori_one->id)->whereAktif(1)->count();
        } else {
            $yazilar = Yazi::whereAktif(1)->with("kategori")->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->orderBy("onecikarilan","desc")->orderBy("sira","asc")->offset($offset)->limit($this->_paginate)->get();
            $yazilar_count = Yazi::whereAktif(1)->count();
        }
        return response()->json([
            "yazilar"=>$yazilar,
            "toplam"=>ceil($yazilar_count / $this->_paginate)
        ]);
    }
}
