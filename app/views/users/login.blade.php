@extends("layout")
@section("content")
<?php var_dump(Session::get('error')); ?>
    @if (isset($error))
      <h4>{{ $error }}</h4><br />
    @endif
  {{ Form::open(array('url'=>"/login", 'method'=>'post' )) }}
  {{ Form::label("username", "Username") }}
  {{ Form::text("username",Input::old("username")) }}
  {{ Form::label("password", "Password") }}
  {{ Form::password("password") }}
  {{ Form::submit("login") }}
  {{ Form::close() }}
@stop