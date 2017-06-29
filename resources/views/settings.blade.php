@extends('layouts.app')

@section('css')
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
@endsection

@section('navbar1')
<a class="navbar-brand" href="{{ url('/profile') }}">
    Profile
</a>
@endsection

@section('content')
<div class="container">
    <div class="row">
      <!--Section Left Image and Details-->
      <div class="col-lg-offset-3 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">Your Profile</h3>
          </div>
          <div class="panel-body" id="Profile">
              <ul class="list-group">
                  <!--List of options-->
                  @if (file_exists($url))
                      <img class="img-responsive" src='{{$url}}' />
                  @endif
                  <form enctype="multipart/form-data" action="/profile/upload" method="post">
                      {{csrf_field()}}
                      <div class="form-group">
                          <label>Change Image</label>
                          <input type="file" class="form-control-file" name="image">
                      </div>
                      <input type="submit" value="Upload">
                  </form>
              </ul>
              <ul class="list-group">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Name</span>
                    <input type="text" class="form-control" id="name" placeholder="{{$user->name}}" value="{{$user->name}}" aria-describedby="basic-addon1">
                </div>
              </ul>
              <ul class="list-group">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Email</span>
                    <input type="text" class="form-control" id="email" placeholder="{{$user->email}}" value="{{$user->email}}" aria-describedby="basic-addon1">
                </div>
              </ul>
              <ul class="list-group">
                  <a type="button" class="btn" href="/settings/password">
                    Change Password
                  </a>
              </ul>
              <ul class="list-group">
                  <button type="button" class="btn btn-warning" id="noChanges">No changes</button>
                  <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
              </ul>
          </div>
        </div>
      </div>

    </div>
</div>

@endsection
@section('script')
<script>
$(document).ready(function() {
  $('#saveChanges').click(function(event) {
      var text = $('#name').val();
      var email = $('#email').val();
      if (text == "" || email == "")
      {
          alert('Please type your Name');
      }else
      {
          $.post('/settings/name', {'name': text,'email': email,'_token':$('input[name=_token]').val()}, function(data) {
              console.log(data);
              $('#Profile').load(location.href + ' #Profile');
          });
      }
  });

  $('#noChanges').click(function(event) {
      $('#Profile').load(location.href + ' #Profile');
  });

});
</script>
@endsection
