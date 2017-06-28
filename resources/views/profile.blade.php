@extends('layouts.app')

@section('css')
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
@endsection

@section('navbar2')
<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
      <button type="submit" class="btn btn-default">Submit</button>
  </div>
</form>
@endsection

@section('content')
<div class="container">
    <div class="row">
      <!--Section Left Image and Details-->
      <div class="col-lg-offset-0 col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">{{$user_name}}</h3>
          </div>
          <div class="panel-body" id="Section">
              <ul class="list-group">
                  <!--List of options-->
                  @if (isset($url) && file_exists($url))
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
                  Email: {{$user_email}}
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
                      @if (Auth::user()->id == $iduser)
                      <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                      </a>
                      @endif
                    </h3>
                </div>
                <div class="panel-body" id="posts">
                    <ul class="list-group">
                        @foreach ($posts as $post)
                            @if (Auth::user()->id == $iduser)
                                <li class="list-group-item list-group-item-info Post" data-toggle="modal" data-target="#myModal">
                            @else
                                <li class="list-group-item list-group-item-info Post">
                            @endif
                                <a class="ourItem">{{$post->body}}</a>
                                <input type="hidden" id="itemId" value="{{$post->id}}">
                            </li>
                            <li class="list-group-item">
                                @if (file_exists('storage/posts/' . $post->id . '.jpeg'))
                                <img class="img-responsive" src='/storage/posts/{{$post->id}}.jpeg' />
                                @endif
                                <span class="pull-right">
                                  {{$post->updated_at}}
                                </span>
                                <br>
                            </li>
                            <br>
                        @endforeach
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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script>
    $(document).ready(function() {
        $(document).on('click', '.ourItem', function(event) {
              var text = $.trim($(this).text());
              var id = $(this).find('#itemId').val();
              $('#title').text('Edit Item');
              $('#addItem').val(text);
              $('#delete').show('400');
              $('#saveChanges').show('400');
              $('#AddButton').hide('400');
              $('#id').val(id);
              console.log(text);
        });

        $(document).on('click', '#addNew', function(event) {
              $('#title').text('Add New Item');
              $('#addItem').val("");
              $('#delete').hide('400');
              $('#saveChanges').hide('400');
              $('#AddButton').show('400');
        });

        $('#AddButton').click(function(event) {
            var text = $('#addItem').val();
            if (text == "")
            {
                alert('Please type anything fot your post');
            }else
            {
                $.post('/profile', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
                    console.log(data);
                    $('#posts').load(location.href + ' #posts');
                });
            }
        });

        $('#delete').click(function(event) {
            var id = $("#id").val();
            $.post('/profile/post/delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
                $('#posts').load(location.href + ' #posts');
                console.log(data);
            });
        });

        $('#saveChanges').click(function(event) {
            var id = $("#id").val();
            var value = $.trim($("#addItem").val());
            $.post('/profile/post/update', {'id': id,'value': value,'_token':$('input[name=_token]').val()}, function(data) {
                $('#posts').load(location.href + ' #posts');
                console.log(data);
            });
        });

    });
</script>
@endsection
