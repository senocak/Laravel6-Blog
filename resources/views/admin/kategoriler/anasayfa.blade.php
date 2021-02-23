@extends('admin.main')
@section('head')
    <style>
        .dd-expand, .dd-collapse{display: none !important;visibility: hidden;}
        .dd-handle, .dd-item{padding-left: 0px !important;}
        .dd-list{display:block;position:relative;margin:0;padding:0;list-style:none}
        .dd-list .dd-list{padding-left:30px}
        .dd-empty,.dd-item,.dd-placeholder{display:block;position:relative;margin:0;padding:0;min-height:20px;font-size:13px;line-height:20px}
        .dd-handle{display:block;height:30px;margin:5px 0;padding:5px 10px;color:#333;text-decoration:none;font-weight:700;border:1px solid #ccc;background:#fafafa;border-radius:3px;box-sizing:border-box}
        .dd-handle:hover{color:#2ea8e5;background:#fff}
        .dd-empty,.dd-placeholder{margin:5px 0;padding:0;min-height:30px;background:#f2fbff;border:1px dashed #b6bcbf;box-sizing:border-box;-moz-box-sizing:border-box}
        .dd-empty{border:1px dashed #bbb;min-height:100px;background-color:#e5e5e5;background-size:60px 60px;background-position:0 0,30px 30px}
        .dd-dragel{position:absolute;pointer-events:none;z-index:9999}
        .dd-dragel>.dd-item .dd-handle{margin-top:0}
        .dd-dragel .dd-handle{box-shadow:2px 4px 6px 0 rgba(0,0,0,.1)}
        .dd-nochildren .dd-placeholder{display:none}

        .one {width: 40%;float: left;}
        .two {margin-left: 45%;}
    </style>
	<script type="text/javascript">
		function showimagepreview(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {$('#imgview').attr('src', e.target.result);}
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
@endsection
@section('icerik')
    <div class="one">
        <div class="cf nestable-lists">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    @foreach ($kategoriler as $yazi)
                        @if (count($yazi->children) > 0)
                            <li class="dd-item" data-id="{{$yazi->id}}">
                                <div class="dd-handle">{{$yazi->baslik}}</div>
                                <ol class="dd-list">
                                    @foreach ($yazi->children as $yazi2)
                                        @if (count($yazi2->children) > 0)
                                            <li class="dd-item" data-id="{{$yazi2->id}}">
                                                <div class="dd-handle">{{$yazi2->baslik}}</div>
                                            </li>
                                        @else
                                            <li class="dd-item" data-id="{{$yazi2->id}}">
                                                <div class="dd-handle">{{$yazi2->baslik}}</div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </li>
                        @else
                            <li class="dd-item" data-id="{{$yazi->id}}">
                                <div class="dd-handle">{{$yazi->baslik}}</div>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div class="two">
        @if ($kategori_single)
            {!! Form::open(["route"=>["admin.yazi.kategoriler.guncelle", $kategori_single->url], "files"=>"true"]) !!}
                {!! Form::text('baslik', $kategori_single->baslik, array("autocomplete"=>"off","required"=>"required","autofocus"=>"autofocus","placeholder"=>"Kategori Başlığı")); !!}
                {!! Form::file('resim', array("class"=>"input",'onChange'=>'showimagepreview(this)')); !!}
                <br><img src="{{url('/')}}/img/{{$kategori_single->resim}}" style="width:100px"><img src="{{url('/')}}/img/no-image.png" style="width:100px" id="imgview" >
                {!! Form::submit("Güncelle", array("class"=>"input","style"=>"background: green; color:white")); !!}
            {!! Form::close() !!}
        @else
            {!! Form::open(["route"=>"admin.yazi.kategoriler.ekle", "files"=>"true"]) !!}
                {!! Form::text('baslik', null, array("autocomplete"=>"off","required"=>"required","autofocus"=>"autofocus","placeholder"=>"Kategori Başlığı")); !!}
                {!! Form::file('resim', array("class"=>"input",'onChange'=>'showimagepreview(this)',"required"=>"required")); !!}
                <br><img src="{{url('/')}}/img/no-image.png" style="width:100px" id="imgview" >
                {!! Form::submit("Ekle", array("class"=>"input","style"=>"background: green; color:white")); !!}
            {!! Form::close() !!}
        @endif
    </div>
    <div class="clear" style="height: 25px;"></div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Resim</th>
                    <th>Başlık</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategoriler_all as $kategori)
                    <tr>
                        <td>
                            <img src="/img/{{$kategori->resim}}" style="width: 100px" class="title">
                            <div class="magic-links">
                                <a href="/admin/kategoriler/{{$kategori->url}}">Güncelle</a> |
                                <a href="/admin/kategoriler/{{$kategori->url}}/sil" class="trash" onclick="return confirm('Emin misiniz?')">Sil</a>
                            </div>
                        </td>
                        <td>{{$kategori->baslik}}</td>
                        <td>{{date("d/m/Y H:ia", strtotime($kategori->created_at))}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('footer')
    <script src="/js/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function() {
            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                output = list.data('output');
                if(window.JSON) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                        type: "POST",
                        dataType: "json",
                        contentType: 'application/json',
                        data: window.JSON.stringify(list.nestable('serialize')),
                        url: '{{route("admin.yazi.kategoriler.hiyerarsi.post")}}',
                        success: function(msg){
                            console.log(msg);
                        }
                    });
                }else {
                    console.log('JSON browser support required for this demo.');
                }
            };
            $('#nestable').nestable({group: 1}).on('change', updateOutput);
        });
    </script>
@endsection
