<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
Use Image;

class AyarController extends Controller{
    public function profil(){
        $user = User::select("name","about","social","resim","email")->where("id",1)->firstOrFail();
        return view("admin.ayar.profil", ["user"=>$user]);
    }
    public function profilUpdate(Request $request){
        $user = User::where("id",1)->firstOrFail();
        $user->name = $request->name;
        $user->about = $request->about;
        $social = "mail:".$request->social[0].","."github:".$request->social[1].","."linkedin:".$request->social[2].","."stackoverflow:".$request->social[3];
        $user->social = $social;
        if ($request->hasFile('resim')) {
            $img=$request->file('resim');
            $filename=$this->self_url($request->name)."_".time().".".$img->getClientOriginalExtension();
            $location=public_path('img/'.$filename);
            Image::make($img)->save($location);
            $user->resim=$filename;
        }
        $user->save();
        return redirect()->route("admin.ayar.profil");
    }
    public function profilSifreUpdate(Request $request){
        $mesajlar = [
          'current_sifre.required' => 'Please enter current password',
          'yeni_sifre.required' => 'Please enter password',
          'yeni_sifre2.same' => 'Eşleşmiyor',
        ];
        $validator = Validator::make($request->all(), [
            'current_sifre' => 'required',
            'yeni_sifre' => 'required|min:5|max:10',
            'yeni_sifre2' => 'required|same:yeni_sifre|min:5|max:10',
        ], $mesajlar);
        if (Hash::check($request->current_sifre, Auth::user()->password)) {
            $user_id = Auth::user()->id;
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request->yeni_sifre);;
            $obj_user->save();
            Session::flash('message', "Şifre Değiştirme Başarılı");
            Auth::logout();
            return redirect()->route("admin.ayar.profil");
        } else {
            return redirect()->route("admin.ayar.profil")->withErrors($validator);
        }
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
}
