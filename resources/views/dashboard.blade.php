@extends('layouts.app')

@section('content')

<h1>{{ Session::get('user_first_name') }} {{ Session::get('user_last_name') }}</h1>

@endsection