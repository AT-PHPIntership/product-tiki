@extends('admin.layout.master')
@section('title', __('post.admin.list.title') )
@section('content')
<script src="/js/messages.js"></script>
<script src="/js/post.js"></script>
  <div class="right_col" role="main" class="index-main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('post.admin.list.title') }}</h3>
        </div>

        <div class="title_right">
          <div class="col-md-10 col-sm-10 col-xs-12 form-group pull-right top_search">
            <form action="{{ route('admin.posts.index') }}" method="GET">
              <div class="input-group">   
                <div class="col-md-6">
                  <select name="post_status" class="form-control">
                    <option value="">{{ __('post.admin.list.subtitle_index') }}</option>
                    <option value="{{ App\Models\Post::UNAPPROVED }}">{{ __('post.admin.list.unapproved_post') }}</option>
                    <option value="{{ App\Models\Post::APPROVED }}">{{ __('post.admin.list.approved_post') }}</option>
                  </select>
                </div>          
                <div class="col-md-6">
                  <input type="text" name="content" class="form-control" placeholder="{{ __('post.admin.list.search') }}">
                </div>        
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit">{{ __('post.admin.list.go') }}</button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
      
        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>
                  {{ __('post.admin.list.subtitle_index') }}
              </h2>
              <div class="clearfix"></div>
            </div>
              <h2 id="info-message">@if (session()->has('message')) {{ session()->pull('message', 'default') }} @endif</h2>
            
            <div class="x_content" class="list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.product_col') }}</th>
                    <th class="col-md-1">{{ __('post.admin.list.type_col') }}</th>
                    <th class="col-md-4">{{ __('post.admin.list.content_col') }}</th>
                    <th class="col-md-1">{{ __('post.admin.list.status_col') }}</th>
                    <th class="col-md-1"># <i class="fa fa-star"></i></th>
                    <th class="col-md-2">{{ __('post.admin.list.action_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post )
                  <tr>
                    <td>{{ $post['user']->username }}</td>
                    <td>{{ $post['product']->name }}</td>
                    <td>
                      @if ($post['type'] == App\Models\Post::TYPE_REVIEW ) 
                        {{ __('post.admin.form.type_reviews') }}
                      @else 
                        {{ __('post.admin.form.type_comments') }}
                      @endif
                    </td>
                    <td>{{ $post['content'] }}</td>
                    <td id='status{{ $post['id'] }}'>
                        @if ($post['status'] ) 
                          {{ __('common.approve') }}
                        @else
                          {{ __('common.pending') }}
                        @endif
                    </td>
                    <td>{{ $post['rating'] }}</td>
                    <td>
                      <form action="" class="col-md-4" method="POST">
                        @method('PUT')
                        @csrf
                        <button id="update{{ $post['id'] }}" onclick="updateStatus(event, {{ $post['id'] }}, '{{ route('admin.posts.update.status', ['id' => $post['id']]) }}')" class="btn btn-primary update-btn" type="button">
                          @if ($post['status'])
                            <i class="fa fa-times-circle icon-size" ></i>
                          @else
                            <i class="fa fa-check-circle icon-size" ></i>
                          @endif
                        </button>
                      </form>
                      <form action="{{ route('admin.posts.destroy', ['id' => $post['id']]) }}" class="col-md-4" method="POST" id="delete{{ $post['id'] }}">
                        @csrf
                        @method('DELETE')
                        <button onclick="deletePost(event, {{ $post['id'] }})" class="btn btn-danger" type="submit"><i class="fa fa-trash icon-size" ></i></button>
                      </form>
                      <form action="{{ route('admin.posts.show', ['id' => $post['id']]) }}" class="col-md-4">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-eye icon-size" ></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{ $posts->render() }}
        <div class="clearfix"></div>       
      </div>
    </div>
  </div>

@endsection
