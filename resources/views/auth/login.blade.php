@extends('main')
@section('icerik')
    <style>
        .input{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 18px;
            margin-bottom: 5px;
            background: #eaeaea;
            text-decoration: none;
            text-align: center;
            font-weight: 500;
            border-radius: 8px;
            border: 1px solid transparent;
            appearance: none;
            outline: none;
            width: 100%;
        }
    </style>
    <main class="post">
        <h1 style="text-align: center">Giriş Yap</h1>
        {!! Form::open(['route' => 'login']) !!}
            {!! Form::email('email', null, array("autocomplete"=>"off","required"=>"required","autofocus"=>"autofocus","class"=>"input")); !!}
            {!! Form::password('password', array("autocomplete"=>"off","required"=>"required","class"=>"input")); !!}
            {!! Form::submit("Giriş Yap", array("class"=>"input","style"=>"background: #3b3d42; color:white")); !!}
            {{ Form::hidden('remember', 'true') }}
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        {!! Form::close() !!}
    </main>
@endsection
