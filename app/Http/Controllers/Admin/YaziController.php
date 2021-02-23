<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kategori;
use App\Yazi;

class YaziController extends Controller{
    public function anasayfa(Request $request){
        $limit = $request->input('limit') ? $request->input('limit') : 10;
        $kategori = $request->input('kategori') ? $request->input('kategori') : "";
        $kategoriler = Kategori::all();
        if ($kategori != "") {
            $kategori_id = Kategori::whereUrl($kategori)->firstOrFail()->id;
            $yazilar = Yazi::where("kategori_id",$kategori_id)->with("kategori")->with("yorum")->orderBy("sira","asc")->paginate($limit);
        }else{
            $yazilar = Yazi::with("kategori")->with("yorum")->orderBy("sira","asc")->paginate($limit);
        }
        //$yazilar = Yazi::with("kategori")->with("yorum")->paginate($limit);
        return view("admin.yazi.anasayfa", ["kategoriler"=>$kategoriler, "yazilar"=>$yazilar]);
    }
    public function sirala(Request $request){
        foreach ($request->item as $key => $value) {
            //$post=Yazi::where("id",$value);
            $post = Yazi::whereId($value)->firstOrFail();
            $post->sira=($key+1);
            $post->save();
        }
        return array( 'islemSonuc' => true , 'islemMsj' => 'İçeriklerin sırala işlemi güncellendi' );
    }
    public function aktifPasif(Request $request){
        $id = $request->id;
        $yazi = Yazi::findOrFail($id);
        if ($yazi->aktif == 1) {
            $yazi->aktif = 0;
        } else {
            $yazi->aktif = 1;
        }
        $yazi->save();
        return array( 'islemSonuc' => true , 'islemMsj' => 'Yazı Durumu Güncellendi' );
    }
    public function ekle(){
        $kategoriler = Kategori::pluck('baslik',"id");
        return view("admin.yazi.ekle", ["kategoriler"=>$kategoriler]);
    }
    public function eklePost(Request $request){
        $yazi = new Yazi();
        $yazi->baslik = $request->baslik;
        $yazi->icerik = $request->icerik;
        $yazi->kategori_id = $request->kategori_id;
        $yazi->etiketler = $request->etiketler;
        $yazi->github_repo = $request->github_repo;
        $yazi->url = $this->self_url($request->baslik);
        $yazi->save();
        return redirect()->route("admin.anasayfa")->with('success','Yazı Başarıyla Oluşturuldu');
    }
    public function duzenle($url){
        $yazi = Yazi::whereUrl($url)->firstOrFail();
        $kategoriler = Kategori::pluck('baslik',"id");
        return view("admin.yazi.duzenle", ["yazi"=>$yazi,"kategoriler"=>$kategoriler]);
    }
    public function duzenlePost($url, Request $request){
        $yazi = Yazi::whereUrl($url)->firstOrFail();
        $yazi->baslik = $request->baslik;
        $yazi->icerik = $request->icerik;
        $yazi->kategori_id = $request->kategori_id;
        $yazi->etiketler = $request->etiketler;
        $yazi->github_repo = $request->github_repo;
        $yazi->url = $this->self_url($request->baslik);
        $yazi->save();
        return redirect()->route("admin.anasayfa")->with('success','Yazı Başarıyla Güncellendi');
    }
    public function oneCikar($url, Request $request){
        $yazi = Yazi::whereUrl($url)->firstOrFail();
        if ($yazi->onecikarilan == 1) {
            $yazi->onecikarilan = 0;
        }else{
            $yazi->onecikarilan = 1;
        }
        $yazi->save();
        return redirect()->route("admin.anasayfa");
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
}
