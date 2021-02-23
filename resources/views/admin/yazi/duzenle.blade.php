@extends('admin.main')
@section('head')
    {!! Html::script('https://cdn.ckeditor.com/4.13.1/full-all/ckeditor.js') !!}
    <style>
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
            content: "x";
            padding: 0px 2px;
            color:red;
        }
    </style>
@endsection
@section('icerik')
    {!! Form::open(['route' => ['admin.yazi.duzenle.post', $yazi->url]]) !!}
        {!! Form::text('baslik', $yazi->baslik, array("autocomplete"=>"off","required"=>"required","autofocus"=>"autofocus","placeholder"=>"Yazı Başlığı")); !!}
        {!! Form::textarea("icerik", htmlspecialchars($yazi->icerik), ["id"=>"editor","class"=>"ckeditor"])!!}
        {!! Form::select('kategori_id', $kategoriler, $yazi->kategori_id, ["class"=>"input","style"=>"width:100%"]) !!}
        {!! Form::text("etiketler", $yazi->etiketler, ["data-role"=>"tagsinput","class"=>"input","placeholder"=>"Etiketler arasına (,) koyunuz"]) !!}
        {!! Form::text("github_repo", $yazi->github_repo, ["class"=>"input","placeholder"=>"Kullanıcı Adı / Repo"]) !!}
        {!! Form::submit("Güncelle", array("class"=>"input","style"=>"background: green; color:white")); !!}
    {!! Form::close() !!}
@endsection
@section('footer')
    {!! Html::script('js/bootstrap-tagsinput.min.js') !!}
    <script>
        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: "{{url('/')}}/editor/fileman/index.html",
            filebrowserImageBrowseUrl: "{{url('/')}}/editor/fileman/index.html",
            extraPlugins: 'codesnippet,tableresize',
            height: '230px',
        });
    </script>
@endsection