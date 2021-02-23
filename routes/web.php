<?php
Route::get('/', "HomeController@index");
Route::get('/blog', "HomeController@blog");
Route::get('/blog/kategori/{url}', "HomeController@blog");
Route::get('/blog/{url}', "HomeController@yazi")->name("index.yazi");
Route::post('/blog/{url}', "HomeController@yorum")->name("index.yorum.ekle");

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
Route::get('admin', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware("auth")->group(function () {
    Route::get('/admin/anasayfa', 'Admin\YaziController@anasayfa')->name('anasayfa');
    Route::prefix('/admin/yazilar')->group(function () {
        Route::get('/', 'Admin\YaziController@anasayfa')->name('admin.anasayfa');
        Route::post('/sirala','Admin\YaziController@sirala')->name("admin.yazi.sirala");
        Route::post('/aktifPasif','Admin\YaziController@aktifPasif')->name("admin.yazi.aktifPasif");
        Route::get('/ekle', 'Admin\YaziController@ekle')->name('admin.yazi.ekle');
        Route::post('/ekle', 'Admin\YaziController@eklePost')->name('admin.yazi.ekle.post');
        Route::get('/{url}/duzenle', 'Admin\YaziController@duzenle')->name('admin.yazi.duzenle');
        Route::post('/{url}/duzenle', 'Admin\YaziController@duzenlePost')->name('admin.yazi.duzenle.post');
        Route::get('/{url}/oneCikar', 'Admin\YaziController@oneCikar')->name('admin.yazi.oneCikar');
    });
    Route::prefix('/admin/kategoriler')->group(function () {
        Route::post('/hiyerarsi', 'Admin\KategoriController@hiyerarsiPost')->name('admin.yazi.kategoriler.hiyerarsi.post');
        Route::get('/{url?}', 'Admin\KategoriController@kategoriler')->name('admin.yazi.kategoriler');
        Route::post('/{url}', 'Admin\KategoriController@guncelle')->name('admin.yazi.kategoriler.guncelle');
        Route::post('/', 'Admin\KategoriController@kategorilerEkle')->name('admin.yazi.kategoriler.ekle');
        Route::get('/{url}/sil', 'Admin\KategoriController@sil')->name('admin.yazi.kategoriler.sil');
    });
    Route::prefix('/admin/profil')->group(function () {
        Route::get('/', 'Admin\AyarController@profil')->name('admin.ayar.profil');
        Route::post('/', 'Admin\AyarController@profilUpdate')->name('admin.ayar.profil.post');
        Route::post('/sifreGuncelle', 'Admin\AyarController@profilSifreUpdate')->name('admin.ayar.profil.sifre.post');
    });
});



Route::post('/api/blog', "HomeController@apiBlog");