@extends('layouts.app')

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success">
    <button type="button" class="close" data-bs-dismiss="alert">x</button>
    {{session()->get('message')}}
    </div>
@endif
<table>
    <tr>
        <th style="padding: 10px;">ID</th>
        <th style="padding: 10px;">First Name</th>
        <th style="padding: 10px;">Last Name</th>
        <th style="padding: 10px;">Birthday</th>
        <th style="padding: 10px;">Gender</th>
        <th style="padding: 10px;">Place of Birth</th>
        <th></th>
    </tr>
    @foreach($response->items as $authors)
    <tr align="center" style="background-color: skyblue;">
        <td>{{$authors->id ?? ''}}</td>
        <td>{{$authors->first_name ?? ''}}</td>
        <td>{{$authors->last_name ?? ''}}</td>
        <td>{{date("Y-m-d", strtotime($authors->birthday)) ?? ''}}</td>
        <td>{{$authors->gender ?? ''}}</td>
        <td>{{$authors->place_of_birth ?? ''}}</td>
        <td><a class="btn btn-success" href="{{url('view_author', $authors->id)}}">View</a></td>
        <td><a class="btn btn-danger" onClick="return confirm('Are you sure to delete this?')" href="{{url('delete_author', $authors->id)}}">Delete</a></td>
    </tr>
    @endforeach
</table>

@endsection