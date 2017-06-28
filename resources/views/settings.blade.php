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
      <div class="col-lg-offset-0 col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">{{$user->name}}</h3>
          </div>
          <div class="panel-body" id="Section">
              <ul class="list-group">
                  <!--List of options-->
                  @if (file_exists($url))
                      <img class="img-responsive" src='{{$url}}' />
                  @else
                  <p>Upload Image</p>
                  <form enctype="multipart/form-data" action="/profile/upload" method="post">
                      {{csrf_field()}}
                      <input type="file" name="image">
                      <br>
                      <input type="submit" value="Upload">
                  </form>
                  @endif
              </ul>
              <ul class="list-group">
                  Email: {{$user->email}}
              </ul>
              <ul class="list-group">

          </div>
        </div>
      </div>
      <!--Center Body-->
        <div class="col-lg-offset-2 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Post

                    </h3>
                </div>
                <div class="panel-body" id="posts">
                    <ul class="list-group">

                    </ul>
                </div>
            </div>
        </div>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="title">Add new post</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id">
              <p> <input type="text" placeholder="Write Item Here" id="addItem" class="form-control"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
              <button type="button" class="btn btn-primary" id="saveChanges" style="display: none" data-dismiss="modal">Save changes</button>
              <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Add Item</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    </div>
</div>

@endsection
@section('script')
@endsection
