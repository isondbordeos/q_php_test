@extends('layouts.app')

@section('content')

<div>
    <form action="{{url('create_author')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="padding: 15px;">
          <label>First Name:</label>
          <input type="text" class="form-control" style="color:black;" name="first_name" placeholder="First Name" required="">
        </div>
        <div style="padding: 15px;">
          <label>Last Name:</label>
          <input type="text" class="form-control" style="color:black;" name="last_name" placeholder="Last Name" required="">
        </div>
        <div style="padding: 15px;">
          <label>Birthday:</label>
          <input type="date" class="form-control" style="color:black;" name="birthday" placeholder="Birthday" required="">
        </div>
        <div style="padding: 15px;">
          <label>Biography:</label>
          <input type="text" class="form-control" style="color:black;" name="biography" placeholder="Biography" required="">
        </div>
        <div style="padding: 15px;">
          <label>Gender:</label>
          <select class="form-control" name="gender" style="color: black; background-color: white;" required="">
            <option value="">- Select -</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div style="padding: 15px;">
          <label>Place of Birth:</label>
          <input type="text" class="form-control" style="color:black;" name="place_of_birth" placeholder="Place of Birth" required="">
        </div>
        <div style="padding: 15px;">
          <input type="submit" class="btn btn-success">
        </div>
    </form>
</div>

@endsection