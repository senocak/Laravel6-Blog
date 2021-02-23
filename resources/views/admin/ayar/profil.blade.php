@extends('admin.main')
@section('head')
	<script type="text/javascript">
		function showimagepreview(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {$('#imgview').attr('src', e.target.result);}
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
    <style>
        .one {
            width: 5%;
            float: left;
            margin-top: 10px;
        }
        .two {
            margin-left: 5%;
            width: 95%;
        }
    </style>
@endsection
@section('icerik')
    <div class="box-container" style="margin: auto;text-align: center;width: 20%">
        <div class="box" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
            <img class="img" src="{{url('/')}}/img/{{$user->resim}}" style="width:100%">
            <div></div>
            <h1>{{$user->name}}</h1>
            <p style="color: grey;font-size: 18px;">{{$user->about}}</p>
            <br>
            @php($virgul = explode(",",$user->social))
            @for ($i = 0; $i < count($virgul); $i++)
                @php($nokta = explode(":",$virgul[$i]))
                @if ($nokta[0] == "mail")
                    <a href="mailto:{{ $nokta[1] }}" target="_blank" style="color:black"><i class="fa fa-envelope"></i></a>
                @endif
                @if ($nokta[0] == "github")
                    <a href="https://github.com/{{ $nokta[1] }}" target="_blank" style="color:black"><i class="fa fa-github"></i></a>
                @endif
                @if ($nokta[0] == "linkedin")
                    <a href="https://www.linkedin.com/in/{{ $nokta[1] }}" target="_blank" style="color:black"><i class="fa fa-linkedin"></i></a>
                @endif
                @if ($nokta[0] == "stackoverflow")
                    <a href="https://www.stackoverflow.com/users/{{ $nokta[1] }}" target="_blank" style="color:black"><i class="fa fa-stack-overflow"></i></a>
                @endif
            @endfor
        </div>
    </div>
    <div class="box-container" style="width: 50%">
        <div class="box" id="div-1">
            <h3>Profil Bilgileri Değiştir</h3>
            <div class="box-content" style="display: block;">
                {!! Form::open(["route"=>["admin.ayar.profil.post"], "files"=>"true"]) !!}
                    {!! Form::file("resim", ['onChange'=>'showimagepreview(this)']) !!}
                    <br>
                    <img src="/img/no-image.png" width="100px" id="imgview">
                    {!! Form::text("name", $user->name, ["placeholder"=>"İsim","required"=>"required"]) !!}
                    {!! Form::textarea("about", $user->about, ["placeholder"=>"Hakkında","required"=>"required", "rows"=>"2","style"=>"resize:none;"]) !!}
                    <div class="one"><i class="fa fa-envelope"></i></div><div class="two">{!! Form::text("social[]", explode(":",explode(",",$user->social)[0])[1], []) !!}</div>
                    <div class="one"><i class="fa fa-github"></i></div><div class="two">{!! Form::text("social[]", explode(":",explode(",",$user->social)[1])[1], []) !!}</div>
                    <div class="one"><i class="fa fa-linkedin"></i></div><div class="two">{!! Form::text("social[]", explode(":",explode(",",$user->social)[2])[1], []) !!}</div>
                    <div class="one"><i class="fa fa-stack-overflow"></i></div><div class="two">{!! Form::text("social[]", explode(":",explode(",",$user->social)[3])[1], []) !!}</div>
                    {!! Form::submit("Kaydet", ["class"=>"submit","style"=>"background-color:#0085ba; color:white;"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="box-container container-25" style="width: 30%">
        <div class="box" id="div-1">
            <h3>Şifre Değiştir</h3>
            <div class="box-content" style="display: block;">
                @if($errors->any())
                    {{ implode('', $errors->all(':message')) }}
                @endif
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                {!! Form::open(["route"=>["admin.ayar.profil.sifre.post"]]) !!}
                    {!! Form::text("email", $user->email, ["disabled"=>"disabled","style"=>"background-color:#8080807a;"]) !!}
                    {!! Form::password("current_sifre", ["placeholder"=>"Şimdiki Şifreniz","required"=>"required","min"=>"6","max"=>"10"]) !!}
                    {!! Form::password("yeni_sifre", ["placeholder"=>"Yeni Şifreniz","required"=>"required","min"=>"6","max"=>"10"]) !!}
                    {!! Form::password("yeni_sifre2", ["placeholder"=>"Yeni Şifreniz Tekrar","required"=>"required","min"=>"6","max"=>"10"]) !!}
                    {!! Form::submit("Kaydet", ["class"=>"submit","style"=>"background-color:#0085ba; color:white;"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
