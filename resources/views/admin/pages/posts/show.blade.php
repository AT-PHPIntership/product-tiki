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
            <form action="{{ route('admin.posts.show', ['id' => $post_id]) }}" method="GET">
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
              <h2>{{ __('post.admin.show.subtitle') }}{{ $post_id }}</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" class="list-table">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-1">{{ __('post.admin.list.user_col') }}</th>
                    <th class="col-md-8">{{ __('post.admin.list.content_col') }}</th>
                    <th class="col-md-3">{{ __('post.admin.list.action_col') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($comments as $comment )
                  <tr>
                    <td>{{ $comment['user']->username }}</td>
                    <td>{{ $comment['content'] }}</td>
                    <td>
                      <form action="" class="col-md-4">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-edit icon-size" ></i></button>
                      </form>
                      <form action="" class="col-md-4">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-trash icon-size" ></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{ $comments->render() }}
        <div class="clearfix"></div>       
      </div>
    </div>
  </div>

@endsection