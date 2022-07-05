@extends('layouts.app')

@section('content')

{{-- <div>
    <table>
        <tr>
            <th style="padding: 10px;">ID</th>
            <th style="padding: 10px;">Title</th>
            <th style="padding: 10px;">Release Date</th>
            <th style="padding: 10px;">ISBN</th>
            <th style="padding: 10px;">Format</th>
            <th style="padding: 10px;">Number of Pages</th>
        </tr>
        @foreach($booksResponse->items as $book)
        <tr align="center" style="background-color: skyblue;">
            <td>{{$book->id ?? ''}}</td>
            <td>{{$book->title ?? ''}}</td>
            <td>{{date("Y-m-d", strtotime($book->release_date)) ?? ''}}</td>
            <td>{{$book->isbn ?? ''}}</td>
            <td>{{$book->format ?? ''}}</td>
            <td>{{$book->number_of_pages ?? ''}}</td>
        </tr>
        @endforeach
    </table>
</div> --}}
@if(session()->has('message'))
    <div class="alert alert-success">
    <button type="button" class="close" data-bs-dismiss="alert">x</button>
    {{session()->get('message')}}
    </div>
@endif
<div>
    <form action="{{url('create_book')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="padding: 15px;">
            <label>Author:</label>
            <select class="form-control" name="author" style="color: black; background-color: white;" required="">
              <option value="">- Select -</option>
              @foreach($authorsResponse->items as $authors)
                <option value="{{ $authors->id }}">{{$authors->first_name ." ". $authors->last_name}}</option>
              @endforeach
            </select>
          </div>
        <div style="padding: 15px;">
          <label>Title:</label>
          <input type="text" class="form-control" style="color:black;" name="title" placeholder="Write the title" required="">
        </div>
        <div style="padding: 15px;">
          <label>Description:</label>
          <input type="text" class="form-control" style="color:black;" name="description" placeholder="Write the description" required="">
        </div>
        <div style="padding: 15px;">
          <label>ISBN:</label>
          <input type="text" class="form-control" style="color:black;" name="isbn" placeholder="Write the ISBN" required="">
        </div>
        <div style="padding: 15px;">
          <label>Format:</label>
          <input type="text" class="form-control" style="color:black;" name="format" placeholder="Write the Format" required="">
        </div>
        <div style="padding: 15px;">
          <label>Number of Pages:</label>
          <input type="number" class="form-control" style="color:black;" name="number_of_pages" placeholder="Write the # of Pages" required="" value="0">
        </div>
        <div style="padding: 15px;">
          <input type="submit" class="btn btn-success">
        </div>
    </form>
</div>

@endsection