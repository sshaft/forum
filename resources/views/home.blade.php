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
        <!--Section Left-->
        <div class="col-lg-offset-0 col-lg-4">
          <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Section
                  <a href="#" id="addNewsection" class="pull-right" data-toggle="modal" data-target="#SectionModal">
                    <i class="fa fa-plus" aria-hidden="true">
                    </i>
                  </a>
                </h3>
            </div>
            <div class="panel-body" id="Section">
                <ul class="list-group">
                    <!--List of section-->
                    <a id="ourSection" class="list-group-item ourSection active" value="-5">
                        No-Section
                    </a>
                    @foreach ($sections as $section)
                        <a id="ourSection" class="list-group-item ourSection" href="/section/{{$section->id}}">
                            {{$section->name}}
                        </a>
                    @endforeach
                </ul>
            </div>
          </div>
        </div>
        <!--Center Body-->
        <div class="col-lg-offset-2 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">All Post
                      <a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                      </a>
                    </h3>
                </div>
                <div class="panel-body" id="posts">
                    <ul class="list-group">
                        @foreach ($posts as $post)
                        @if ($post->user_id == Auth::user()->id)
                            <li class="list-group-item list-group-item-info Post" data-toggle="modal" data-target="#myModal">
                        @else
                            <li class="list-group-item list-group-item-info Post">
                        @endif
                            <a class="ourItem">{{$post->body}}</a>
                                <input type="hidden" class="ourItem2" id="itemId" value="{{$post->id}}">
                            </li>
                              <li class="list-group-item">
                                  @if (file_exists('storage/posts/' . $post->id . '.jpeg'))
                                      <img class="img-responsive" src='/storage/posts/{{$post->id}}.jpeg' />
                                      @if ($post->user_id == Auth::user()->id)
                                          <div class="imagepost">
                                            <input type="hidden" class="ourItem2" id="imageid" value="{{$post->id}}">
                                            <span id="deleteImage" value="{{$post->id}}" class="label label-default imagedelete">Delete image</span>
                                          </div>
                                      @endif
                                  @else
                                      @if ($post->user_id == Auth::user()->id)
                                          <p>Upload Image</p>
                                          <form enctype="multipart/form-data" action="/post/image/add" method="post">
                                              {{csrf_field()}}
                                              <input type="file" name="image">
                                              <input type="hidden" name="imageid" value="{{$post->id}}">
                                              <input type="submit" value="Upload">
                                          </form>
                                      @endif
                                  @endif
                                  <a href="/profile/{{$post->user_id}}">
                                    @if ($post->name == Auth::user()->name)
                                        You
                                    @else
                                        {{$post->name}}
                                    @endif
                                  </a>
                                  <span class="pull-right">
                                      {{$post->updated_at}}
                                  </span>
                              </li>
                              <br>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!--Modal-->
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

        <!--Section Modal-->
        <div class="modal fade" id="SectionModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title">Add New Section</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" id="id">
                <p> <input type="text" placeholder="Write Name Here" id="addSectionName" class="form-control"></p>
                <p> <label>Email secondo proprietario</label>
                <input type="text" placeholder="Email" id="addSectionEmail" class="form-control"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
                <button type="button" class="btn btn-primary" id="saveChanges" style="display: none" data-dismiss="modal">Save changes</button>
                <button type="button" class="btn btn-primary" id="AddSection" data-dismiss="modal">Add Section</button>
                <!--inserisci gli utenti-->
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
        $(document).on('click', '.Post', function(event) {
              var text = $.trim($(this).text());
              var id = $(this).find('#itemId').val();
              $('#title').text('Edit Item');
              $('#addItem').val(text);
              $('#delete').show('400');
              $('#saveChanges').show('400');
              $('#AddButton').hide('400');
              $('#file2').hide('400');
              $('#image').hide('400');
              $('#id').val(id);
              console.log(id);
        });

        $(document).on('click', '#addNew', function(event) {
              $('#title').text('Add New Item');
              $('#addItem').val("");
              $('#delete').hide('400');
              $('#saveChanges').hide('400');
              $('#AddButton').show('400');
              $('#file2').show('400');
              $('#image').show('400');
        });

        $('#AddButton').click(function(event) {
            var text = $('#addItem').val();
            var section_id = 0;
            if (text == "")
            {
                alert('Please type anything fot your post');
            }else
            {
                $.post('profile/post', {'text': text,'section_id': section_id,'_token':$('input[name=_token]').val()}, function(data) {
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

        $(document).on('click', '#addNewsection', function(event) {
              $('#AddSection').show('400');
        });

        $('#ourSection').click(function(event) {
            var id = $('#ourSection').val();
            if (id!=-5)
            {
                console.log(text);
            } else {
                console.log("no section");
            }
        });

        $('#AddSection').click(function(event) {
          var name = $('#addSectionName').val();
          var email = $('#addSectionEmail').val();
          if (name == "")
          {
              alert('Please type anything fot your Section');
          }else
          {
              $.post('/section/create', {'name': name,'_token':$('input[name=_token]').val()}, function(data) {
                  console.log(data);
                  $('#Section').load(location.href + ' #Section');
              });
          }
        });

        $(document).on('click', '.imagepost', function(event) {
            var id_image = $(this).find('#imageid').val();
                $.post('/post/image/delete', {'id_image': id_image,'_token':$('input[name=_token]').val()}, function(data) {
                    console.log(data);
                    $('#posts').load(location.href + ' #posts');
                });
        });

    });
</script>
@endsection
