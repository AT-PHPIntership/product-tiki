@extends('admin.layout.master')
@section('title', __('post.admin.show.title') )
@section('content')
  <div class="right_col" role="main" class="index-main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ __('post.admin.show.title') }}</h3>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <form action="{{ route('admin.posts.show', ['id' => $post->id]) }}" method="GET">
              <div class="input-group">
                <input type="text" name="content" class="form-control" placeholder="{{ __('post.admin.list.search') }}">
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
              <h2>{{ __('post.admin.show.subtitle') }}{{ $post->id }}</h2>
              <table class="table table-hover">
                <thead>
                  <thead>
                    <tr>
                      <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                      <th class="col-md-2">{{ __('post.admin.list.product_col') }}</th>
                      <th class="col-md-6">{{ __('post.admin.list.content_col') }}</th>
                      <th class="col-md-1">{{ __('post.admin.list.type_col') }}</th>
                      <th class="col-md-1">{{ __('post.admin.list.status_col') }}</th>
                      <th class="col-md-1"># <i class="fa fa-star"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ $post['user']->username }}</td>
                      <td>{{ $post['product']->name }}</td>
                      <td>{{ $post->content }}</td>
                      <td>
                        @if ($post['type'] == App\Models\Post::TYPE_REVIEW )
                          {{ __('post.admin.form.type_reviews') }}
                        @else
                          {{ __('post.admin.form.type_comments') }}
                        @endif
                      </td>
                      <td id='status{{ $post['id'] }}'>
                          @if ($post['status'] )
                            {{ __('common.approve') }}
                          @else
                            {{ __('common.pending') }}
                          @endif
                      </td>
                      <td>{{ $post['rating'] }}</td>
                    </tr>
                  </tbody>
                </thead>
              </table>
              <div class="clearfix"></div>
            </div>
            <h2 id="info-message">@if (session()->has('message')) {{ session()->pull('message', 'default') }} @endif</h2>
            <div class="col-md-11 col-md-offset-1" class="list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                    <th class="col-md-9">{{ __('post.admin.list.content_col') }}</th>
                    <th class="col-md-2">{{ __('post.admin.list.action_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($comments as $comment )
                  <tr id="comment{{ $comment['id'] }}">
                    <td>{{ $comment['user']->username }}</td>
                    <td>{{ $comment['content'] }}</td>
                    <td>
                      <form action="" class="col-md-4">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-edit icon-size" ></i></button>
                      </form>
                      <form class="col-md-4 col-md-offset-2" method="POST" id="delete{{ $comment['id'] }}">
                        <button onclick="deleteComment(event, {{ $comment['id'] }}, '{{ route('admin.api.comments.destroy', ['id' => $comment['id']]) }}')" class="btn btn-danger" type="button"><i class="fa fa-trash icon-size" ></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $comments->render() }}
            </div>
          </div>
        </div>
        {{ $comments->render() }}
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

@endsection
@section('js')
<script src="/js/admin/post.js"></script>
@endsection
