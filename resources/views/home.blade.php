@extends('layouts.app')

@section('css')
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
@endsection

@section('navbar')
<a class="navbar-brand" href="{{ url('/profile') }}">
    Profile
</a>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <!--Section Left-->
        <div class="col-lg-offset-0 col-lg-3">
          <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Section<a href="#" id="addNewsection" class="pull-right" data-toggle="modal" data-target="#SectionModal"><i class="fa fa-plus" aria-hidden="true">Create</i></a></h3>
            </div>
            <div class="panel-body" id="Section">
                <ul class="list-group">
                    <!--List of section-->
                    <button id="ourSection" class="list-group-item ourSection" value="-5">
                        No-Section
                    </button>
                    @foreach ($sections as $section)
                        <button id="ourSection" class="list-group-item ourSection" value="{{$section->id}}" data-toggle="modal" data-target="#SectionModal">
                            {{$section->name}}
                        </button>
                    @endforeach
                </ul>
            </div>
          </div>
        </div>
        <!--Center Body-->
        <div class="col-lg-offset-0 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">All Post<a href="#" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true">Add</i></a></h3>
                </div>
                <div class="panel-body" id="posts">
                    <ul class="list-group">
                      @foreach ($posts as $post)
                          @if ($post->section_id == 0)
                              <li class="list-group-item list-group-item-info Post" data-toggle="modal" data-target="#myModal">
                                  <a class="ourItem">{{$post->body}}</a>
                                  <input type="hidden" id="itemId" value="{{$post->id}}">
                              </li>
                              <li class="list-group-item">
                                  <a>
                                    @if ($post->name == Auth::user()->name)
                                        You
                                    @else
                                        {{$post->name}}
                                    @endif
                                  </a>
                              </li>
                              <br>
                          @endif
                      @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--Search-->
        <div class="col-lg-2">
            <input type="text" class="form-control" name="searchPost" id="searchPost" placeholder="Search">
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
                <p> <label id="file2">Upload a File</label>
                <input type="file" id="image" name="image"></p>
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
              console.log(text);
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
            if (text == "")
            {
                alert('Please type anything fot your post');
            }else
            {
                $.post('profile', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
                    console.log(data);
                    $('#posts').load(location.href + ' #posts');
                });
            }
        });

        $('#delete').click(function(event) {
            var id = $("#id").val();
            $.post('profile/post/delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
                $('#posts').load(location.href + ' #posts');
                console.log(data);
            });
        });

        $('#saveChanges').click(function(event) {
            var id = $("#id").val();
            var value = $.trim($("#addItem").val());
            $.post('profile/post/update', {'id': id,'value': value,'_token':$('input[name=_token]').val()}, function(data) {
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
              $.post('section/create', {'name': name,'_token':$('input[name=_token]').val()}, function(data) {
                  console.log(data);
                  $('#Section').load(location.href + ' #Section');
              });
          }
        });

        $('#AddFile').click(function(event) {
            var file = $('#file').val();
            $.post('profile', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
                console.log(data);
                $('#posts').load(location.href + ' #posts');
            });
        });

        $( function() {
            $( "#searchPost" ).autocomplete({
              source: 'http://127.0.0.1:8000/profile/post/search'
            });
          } );
    });
</script>
@endsection
