@extends('layouts.app')

@section('content')

<h2>Login Page</h2><br>
@if(session()->has('message'))
    <div class="alert alert-success">
    <button type="button" class="close" data-bs-dismiss="alert">x</button>
    {{session()->get('message')}}
    </div>
@endif    
<div class="login">    
<form id="login" method="POST" action="{{ url('login') }}" enctype="multipart/form-data">    
    @csrf
    <label><b>User Name     
    </b>    
    </label>    
    <input type="text" name="email" id="email" placeholder="Username">    
    <br><br>    
    <label><b>Password     
    </b>    
    </label>    
    <input type="Password" name="password" id="password" placeholder="Password">    
    <br><br>    
    <input type="submit" name="log" id="log" value="Log In Here">
</form>  

@endsection