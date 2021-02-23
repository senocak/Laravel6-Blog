<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Http\Request;
Use Image;

class KategoriController extends Controller{
    public function kategoriler($url = null){
        $kategoriler_nestable = Kategori::whereNull('kategori_id')->with('children')->orderBy("sira","asc")->get();
        $kategoriler_all = Kategori::orderBy("sira","asc")->get();
        if ($url == null) $kategori_single = null;
        if ($url != null) $kategori_single = Kategori::whereUrl($url)->firstOrFail();
        return view("admin.kategoriler.anasayfa", ["kategoriler"=>$kategoriler_nestable, "kategoriler_all"=>$kategoriler_all,"kategori_single"=>$kategori_single]);
    }
    public function guncelle ($url, Request $request){
        $kategori = Kategori::whereUrl($url)->firstOrFail();
        $kategori->baslik = $request->baslik;
        $kategori->url = $this->self_url($request->baslik);
        if ($request->hasFile('resim')) {
            $img=$request->file('resim');
            $filename=$this->self_url($request->baslik)."_".time().".".$img->getClientOriginalExtension();
            $location=public_path('img/'.$filename);
            Image::make($img)->save($location);
            $kategori->resim=$filename;
        }
        $kategori->save();
        return redirect()->route("admin.yazi.kategoriler");
    }
    public function kategorilerEkle(Request $request){
        $kategori = new Kategori;
        $kategori->baslik = $request->baslik;
        $kategori->url = $this->self_url($request->baslik);
        if ($request->hasFile('resim')) {
            $img=$request->file('resim');
            $filename=$this->self_url($request->baslik)."_".time().".".$img->getClientOriginalExtension();
            $location=public_path('img/'.$filename);
            Image::make($img)->save($location);
            $kategori->resim=$filename;
        }
        $kategori->save();
        return redirect()->route("admin.yazi.kategoriler");
    }
    private $_sira = 0;
    public function hiyerarsiPost(Request $request){
        for ($i=0; $i < count($request->all()); $i++) {
            if (isset($request[$i]["children"])) {
                for ($j=0; $j < count($request[$i]["children"]); $j++) {
                    $this->updateKategori($request[$i]["children"][$j]["id"], $request[$i]["id"]);
                }
            }else{
                $this->updateKategori($request[$i]["id"], null);
            }
        }
    }
    public function updateKategori($kategori_id, $parent_id){
        $kategori = Kategori::findOrFail($kategori_id);
        $kategori->sira = $kategori->sira;
        $kategori->sira = $this->_sira;
        $kategori->kategori_id = $parent_id;
        $kategori->save();
        $this->_sira++;
    }
    public function sil($url){
        $kategori = Kategori::whereUrl($url)->firstOrFail();
        @unlink(public_path("img/$kategori->resim"));
        $kategori->delete();
        return redirect()->route("admin.yazi.kategoriler");
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
}
