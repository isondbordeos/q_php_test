@extends('layouts.app')

@section('content')

<h2>Login Page</h2><br>    
<div class="login">    
    <form>  
  
        <label> Firstname </label>         
            <input type="text" name="firstname" size="15"/> <br> <br>  
        <label> Middlename: </label>     
            <input type="text" name="middlename" size="15"/> <br> <br>  
        <label> Lastname: </label>         
            <input type="text" name="lastname" size="15"/> <br> <br>
          
        <label> Phone: </label>  
        <input type="text" name="country code"  value="+91" size="2"/>   
        <input type="text" name="phone" size="10"/> <br> <br>  
        <label> Address </label> 
        <textarea cols="80" rows="5" value="address">  
        </textarea>  
        <label>Email: </label>  
        <input type="email" id="email" name="email"/> <br>    
        <label> Password: </label>
        <input type="Password" id="pass" name="pass"> <br>   
        <label>Re-type password: </label>
        <input type="Password" id="repass" name="repass"> <br> <br>  
        <input type="button" value="Submit"/>  
        </form>  

@endsection