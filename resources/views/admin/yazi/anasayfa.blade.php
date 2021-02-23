@extends('admin.main')
@section('head')
    <style type="text/css">.sortable { cursor: move; }</style>
    <style>
        .tag {
            background-color: #f0ad4e;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            border-radius: 4em;
        }
    </style>
@endsection
@section('icerik')
    <div class="box-">
        @if ($message = Session::get('success'))
            <div class="message success box-">{{ $message }}</div>
        @endif
        @if ($message = Session::get('error'))
            <div class="message error box-">{{ $message }}</div>
        @endif
        <h1>
            Tüm Yazılar
            <a href="/admin/yazilar/ekle">Yeni Yazı</a>

            @if (app('request')->input('kategori')) @php($url = "?kategori=".app('request')->input('kategori')."&" ) @else @php($url = "?" ) @endif
            <select style="float:right;" name="limit"  onchange="this.options[this.selectedIndex].value && (window.location = '{{$url }}limit='+this.options[this.selectedIndex].value);">
                <option value="" disabled selected>Kayıt Göster</option>
                <option value="10" @if (app('request')->input('limit') == "10") selected @endif>10</option>
                <option value="20" @if (app('request')->input('limit') == "20") selected @endif>20</option>
                <option value="30" @if (app('request')->input('limit') == "30") selected @endif>30</option>
                <option value="50" @if (app('request')->input('limit') == "50") selected @endif>50</option>
                <option value="100" @if (app('request')->input('limit') == "100") selected @endif>100</option>
            </select>
            @if (app('request')->input('limit')) @php($url = "?limit=".app('request')->input('limit')."&" ) @else @php($url = "?" ) @endif
            <select style="float:right;" name="kategori" onchange="this.options[this.selectedIndex].value && (window.location = '{{$url }}kategori='+this.options[this.selectedIndex].value);">
                <option value="" disabled selected>Kategori Seç</option>
                @forelse ($kategoriler as $kategori)
                    <option value="{{$kategori->url}}" @if (app('request')->input('kategori') == $kategori->url) selected @endif>{{$kategori->baslik}}</option>
                @empty
                @endforelse
            </select>
        </h1>
    </div>
    <div class="message success box-" id="mesaj"><a style="float: left;padding-right: 18px;" onclick="hide()"><span class="fa fa-times"></span></a><div id="icerik"></div></div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Başlık</th>
                    <th class="hide">Kategori</th>
                    <th class="hide">Etiketler</th>
                    <th class="hide">Aktif/Pasif</th>
                    <th></th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @php($i=1)
                @forelse ($yazilar as $yazi)
                    <tr id="item-{{ $yazi->id }}">
                        <td class="sortable">{{$i}}</td>
                        <td>
                            <a class="title" style="color:black">{{$yazi->baslik}}</a>
                            <div class="magic-links">
                                <a href="/admin/yazilar/{{$yazi->url}}/duzenle">Güncelle</a> |
                                <a href="/admin/yazilar/{{$yazi->url}}/sil" class="trash">Sil</a> |
                                <a href="/blog/{{$yazi->url}}" target="_blank">Görüntüle</a> |
                                <a style="color:black">{{count($yazi->yorum)}} Yorum</a>
                            </div>
                        </td>
                        <td>
                            <a href="/admin/kategori/{{$yazi->kategori->url}}" style="padding: 7px 8px;background: #e0e0e0;font-size: 13px;color: black;font-weight: 500;">{{$yazi->kategori->baslik}}</a>
                        </td>
                        <td>
                            @if (count(explode(',', $yazi->etiketler)) > 1)
                                @php($item = 0)
                                @foreach (explode(',', $yazi->etiketler) as $etiket)
                                    @if ($item < 3)
                                        <span class="tag" title="{{$etiket}}">{{$etiket}}</span>
                                    @endif
                                    @php($item++)
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button onclick="aktifPasif({{$yazi->id}})" id="aktifPasifButton_{{$yazi->id}}">
                                @if ($yazi->aktif == 1)
                                    Pasif Yap
                                @else
                                    Aktif Yap
                                @endif
                            </button>
                        </td>
                        <td>
                            @if ($yazi->onecikarilan == 1)
                                <a href="/admin/yazilar/{{$yazi->url}}/oneCikar" style="padding: 7px 8px;background: green;font-size: 13px;color: white;font-weight: 500;">Öne Çıkarıldı</a>
                            @else
                                <a href="/admin/yazilar/{{$yazi->url}}/oneCikar" style="padding: 7px 8px;background: #e0e0e0;font-size: 13px;color: black;font-weight: 500;">Öne Çıkar</a>
                            @endif
                        </td>
                        <td>{{date("d/m/Y H:ia", strtotime($yazi->created_at))}}</td>
                    </tr>
                    @php($i++)
                @empty
                    Yazı Bulunamadı
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $yazilar->appends(request()->query())->links("admin.pagination") }}
    <script type="text/javascript">
        $("#mesaj").hide();
        $(function() {
            $( "#sortable" ).sortable({
                revert: true,
                handle: ".sortable",
                stop: function (event, ui){
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                        type: "POST",
                        dataType: "json",
                        data: $(this).sortable('serialize'),
                        url: '{{route("admin.yazi.sirala")}}',
                        success: function(msg){
                            $("#mesaj").show();
                            $("#icerik").empty();
                            $("#icerik").append(""+msg.islemMsj);
                        }
                    });
                }
            });
            $( "#sortable" ).disableSelection();
        });
        function hide() {
            $("#mesaj").hide();
        }
        function aktifPasif(id) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                type: "POST",
                dataType: "json",
                data: "id="+id,
                url: '{{route("admin.yazi.aktifPasif")}}',
                success: function(msg){
                    if ($.trim($("#aktifPasifButton_"+id).text()) == "Aktif Yap") {
                        $("#aktifPasifButton_"+id).text("Pasif Yap")
                    }else{
                        $("#aktifPasifButton_"+id).text("Aktif Yap")
                    }
                    $("#mesaj").show();
                    $("#icerik").empty();
                    $("#icerik").append(""+msg.islemMsj);
                }
            });
        }
    </script>
@endsection