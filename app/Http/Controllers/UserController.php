<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
    private $options = [
        'connect_timeout' => 500,
        'read_timeout' => 500,
        'timeout' => 500,
    ];

    public function index(){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                return redirect('dashboard');
            }
            else{
                return view('index');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('dashboard');
            }
            else{
                return view('index');
            }
        }
    }

    public function login_auth(Request $request){
        $email = $request->email;
        $password = $request->password;

        if($email && $password){
            $response = Http::withOptions($this->options)->post('https://symfony-skeleton.q-tests.com/api/v2/token', [
                'email' => $email,
                'password' => $password,
            ]);

            if($response->successful()){
                $response = json_decode($response);
                $cookieResponse = new Response("Hello World");
                $minutes = 60;
                Cookie::queue('token_key', $response->token_key, $minutes);
                Session::put('id', $response->id);
                Session::put('token_key', $response->token_key);
                Session::put('refresh_token_key', $response->refresh_token_key);
                Session::put('user_id', $response->user->id);
                Session::put('user_email', $response->user->email);
                Session::put('user_first_name', $response->user->first_name);
                Session::put('user_last_name', $response->user->last_name);

                return redirect('dashboard');
            }
            else{
                return redirect('/')->with("message", "User credential not existing. Please try again.");
            }
        }
        else{
            return redirect('/')->with("message", "User credential not existing. Please try again.");
        }
    }

    public function dashboard(){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                return view('dashboard');
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return view('dashboard');
            }
            else{
                return redirect('/');
            }
        }
    }

    private function refreshToken(){
        if(Session()->has('refresh_token_key')){
            $response = Http::withOptions($this->options)->get('https://symfony-skeleton.q-tests.com/api/v2/token/refresh/'.Session::get('refresh_token_key'));
            if($response->successful()){
                $response = json_decode($response);
                $minutes = 120;
                Cookie::queue('token_key', $response->token_key, $minutes);
                Session::put('id', $response->id);
                Session::put('token_key', $response->token_key);
                Session::put('refresh_token_key', $response->refresh_token_key);

                return true;
            }
            else{
                return false;
            }
        }
    }

    public function logout(){
        Cookie::queue('token_key', '');
        Cookie::forget('token_key');
        Session::flush();
        return redirect('/');
    }
}
