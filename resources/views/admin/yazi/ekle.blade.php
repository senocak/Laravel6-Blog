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
    {!! Form::open(['route' => 'admin.yazi.ekle.post']) !!}
        {!! Form::text('baslik', null, array("autocomplete"=>"off","required"=>"required","autofocus"=>"autofocus","placeholder"=>"Yazı Başlığı")); !!}
        {!! Form::textarea('icerik', null, array("id"=>"editor","placeholder"=>"Yazı İçerik")); !!}
        {!! Form::select('kategori_id', $kategoriler, null, ["class"=>"input","style"=>"width:100%"]) !!}
        {!! Form::text("etiketler", null, ["data-role"=>"tagsinput","class"=>"input","placeholder"=>"Etiketler arasına (,) koyunuz"]) !!}
        {!! Form::text("github_repo", null, ["class"=>"input","placeholder"=>"Kullanıcı Adı / Repo"]) !!}
        {!! Form::submit("Ekle", array("class"=>"input","style"=>"background: green; color:white")); !!}
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