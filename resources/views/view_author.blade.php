@extends('layouts.app')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
    <button type="button" class="close" data-bs-dismiss="alert">x</button>
    {{session()->get('message')}}
    </div>
@endif
<div>
    <div style="padding: 15px;">
        <label>First Name:</label>
        <input type="text" class="form-control" style="color:black;" name="first_name" placeholder="First Name" required="" readonly="readonly" value="{{ $authorResponse->first_name ?? '' }}">
      </div>
      <div style="padding: 15px;">
        <label>Last Name:</label>
        <input type="text" class="form-control" style="color:black;" name="last_name" placeholder="Last Name" required="" readonly="readonly" value="{{ $authorResponse->last_name ?? '' }}">
      </div>
      <div style="padding: 15px;">
        <label>Birthday:</label>
        <input type="date" class="form-control" style="color:black;" name="birthday" placeholder="Birthday" required="" readonly="readonly" value="{{ date("Y-m-d", strtotime($authorResponse->birthday)) ?? '' }}">
      </div>
      <div style="padding: 15px;">
        <label>Biography:</label>
        <input type="text" class="form-control" style="color:black;" name="biography" placeholder="Biography" required="" readonly="readonly" value="{{ $authorResponse->biography ?? '' }}">
      </div>
      <div style="padding: 15px;">
        <label>Gender:</label>
        <input type="text" class="form-control" style="color:black;" name="gender" placeholder="Gender" required="" readonly="readonly" value="{{ $authorResponse->gender ?? '' }}">
      </div>
      <div style="padding: 15px;">
        <label>Place of Birth:</label>
        <input type="text" class="form-control" style="color:black;" name="place_of_birth" placeholder="Place of Birth" required="" readonly="readonly" value="{{ $authorResponse->place_of_birth ?? '' }}">
      </div>
</div>

<div>
    <table>
        <tr>
            <th style="padding: 10px;">ID</th>
            <th style="padding: 10px;">Title</th>
            <th style="padding: 10px;">Release Date</th>
            <th style="padding: 10px;">ISBN</th>
            <th style="padding: 10px;">Format</th>
            <th style="padding: 10px;">Number of Pages</th>
            <th></th>
        </tr>
        @foreach($authorResponse->books as $book)
        <tr align="center" style="background-color: skyblue;">
            <td>{{$book->id ?? ''}}</td>
            <td>{{$book->title ?? ''}}</td>
            <td>{{date("Y-m-d", strtotime($book->release_date)) ?? ''}}</td>
            <td>{{$book->isbn ?? ''}}</td>
            <td>{{$book->format ?? ''}}</td>
            <td>{{$book->number_of_pages ?? ''}}</td>
            <td><a class="btn btn-danger" onClick="return confirm('Are you sure to delete this?')" href="{{url('delete_book', [$book->id, $authorResponse->id])}}">Delete</a></td>
        </tr>
        @endforeach
    </table>
</div>

@endsection