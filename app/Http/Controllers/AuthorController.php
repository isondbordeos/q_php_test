<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class AuthorController extends Controller
{
    private $options = [
        'connect_timeout' => 500,
        'read_timeout' => 500,
        'timeout' => 500,
    ];

    public function index(){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                $authorsResponse = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->get('https://symfony-skeleton.q-tests.com/api/v2/authors?orderBy=id&direction=ASC&limit=100&page=1');
    
                if($authorsResponse->status() == '401'){
                    refreshToken('authors');
                }
                else{
                    $response = [];
                    if($authorsResponse->successful()){
                        $response = json_decode($authorsResponse);
                    }
                    return view('authors', compact("response"));
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('authors');
            }
            else{
                return redirect('/');
            }
        }
        
    }

    public function view_author($author_id){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                $authorResponse = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->get('https://symfony-skeleton.q-tests.com/api/v2/authors/'.$author_id);
                if($authorResponse->successful()){
                    $authorResponse = json_decode($authorResponse);
                    $cntBooks = 0;
                    if($authorResponse->books instanceof stdClass){
                        $cntBooks = count($authorResponse->books);
                    }
                    
                    return view('view_author', compact("authorResponse"));
                }
                else{
                    return redirect('authors');
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('view_author/'.$author_id);
            }
            else{
                return redirect('/');
            }
        }
    }

    public function view_add_author(){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            return view('add_author_form');
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('add_author_form');
            }
            else{
                return redirect('/');
            }
        }
    }

    public function create_author(Request $request){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                $response = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->post('https://symfony-skeleton.q-tests.com/api/v2/authors', [
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "birthday" => date('c', strtotime($request->birthday)),
                    "biography" => $request->biography,
                    "gender" => $request->gender,
                    "place_of_birth" => $request->place_of_birth,
                ]);

                if($response->successful()){
                    return redirect('authors')->with("message", "Author successfully added.");
                }
                else{
                    return redirect('/');
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                if(Session()->has('token_key')){
                    $response = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                    ->post('https://symfony-skeleton.q-tests.com/api/v2/authors', [
                        "first_name" => $request->first_name,
                        "last_name" => $request->last_name,
                        "birthday" => date('c', strtotime($request->birthday)),
                        "biography" => $request->biography,
                        "gender" => $request->gender,
                        "place_of_birth" => $request->place_of_birth,
                    ]);

                    if($response->successful()){
                        return redirect('authors')->with("message", "Author successfully added.");
                    }
                    else{
                        return redirect('/');
                    }
                }
                else{
                    return redirect('/');
                }
            }
            else{
                return redirect('/');
            }
        }
        

        return redirect('/authors');
    }

    public function delete_author($author_id){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                $authorResponse = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->get('https://symfony-skeleton.q-tests.com/api/v2/authors/'.$author_id);
                if($authorResponse->successful()){
                    $authorResponse = json_decode($authorResponse);
                    if(is_countable($authorResponse->books) && count($authorResponse->books) == 0){
                        $deleteAuthor = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                        ->delete('https://symfony-skeleton.q-tests.com/api/v2/authors/'.$author_id);
    
                        $message = "Author successfully deleted.";
                    }
                    else{
                        $message = "Cannot delete author that has related book/s.";
                    }
                    return redirect('authors')->with("message", $message);
                }
                else{
                    return redirect('authors')->with("message", "Request error.");
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('delete_author/'.$author_id);
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
}
