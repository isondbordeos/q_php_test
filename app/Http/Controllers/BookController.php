<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Book;
use Illuminate\Support\Facades\Cookie;

class BookController extends Controller
{
    private $options = [
        'connect_timeout' => 500,
        'read_timeout' => 500,
        'timeout' => 500,
    ];
    public function index(){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session::has('token_key')){
                $authorsResponse = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->get('https://symfony-skeleton.q-tests.com/api/v2/authors?orderBy=id&direction=ASC&limit=100&page=1');

                $authorsResponse = json_decode($authorsResponse);
                return view('books', compact("authorsResponse"));
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('view_add_book');
            }
            else{
                return redirect('/');
            }
        }
    }

    public function create_book(Request $request){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session::has('token_key')){
                $response = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->post('https://symfony-skeleton.q-tests.com/api/v2/books', [
                    "author" => [
                        "id" => $request->author
                    ],
                    "title" => $request->title,
                    "release_date" => date("c"),
                    "description" => $request->description,
                    "isbn" => $request->isbn,
                    "format" => $request->format,
                    "number_of_pages" => (int)$request->number_of_pages,
                ]);
                if($response->successful()){
                    return redirect('view_add_book')->with("message", "Book successfully created.");
                }
                else{
                    return redirect('view_add_book')->with("message", "Creating book failed.");
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                if(Session::has('token_key')){
                    $response = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                    ->post('https://symfony-skeleton.q-tests.com/api/v2/books', [
                        "author" => [
                            "id" => $request->author
                        ],
                        "title" => $request->title,
                        "release_date" => date("c"),
                        "description" => $request->description,
                        "isbn" => $request->isbn,
                        "format" => $request->format,
                        "number_of_pages" => (int)$request->number_of_pages,
                    ]);
                    if($response->successful()){
                        return redirect('view_add_book')->with("message", "Book successfully created.");
                    }
                    else{
                        return redirect('view_add_book')->with("message", "Creating book failed.");
                    }
                }
                else{
                    return redirect('/');
                }
            }
        }
    }

    public function delete_book($book_id, $author_id){
        if(Cookie::has('token_key') && Cookie::get('token_key') != ''){
            if(Session()->has('token_key')){
                $bookResponse = Http::withOptions($this->options)->withToken(Session::get('token_key'))
                ->delete('https://symfony-skeleton.q-tests.com/api/v2/books/'.$book_id);
                if($bookResponse->successful()){
                    return redirect('view_author/'.$author_id)->with("message", "Book successfully deleted.");
                }
                else{
                    return redirect('view_author/'.$author_id)->with("message", "Request error.");
                }
            }
            else{
                return redirect('/');
            }
        }
        else{
            if(Session()->has('refresh_token_key') && $this->refreshToken()){
                return redirect('delete_book/'.$book_id.'/'.$author_id);
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
        else{
            return false;
        }
    }
}
