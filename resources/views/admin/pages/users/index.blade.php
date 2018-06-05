@extends('admin.layout.master')
@section('title', __('user.index.title'))
@section('content')
<div class="right_col" role="main">
  <div class="col-md-12 col-sm-12 col-xs-12">
    @include('admin.layout.message')
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ __('user.index.showuser') }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th class="column-title">{{ __('user.index.id') }}</th>
                <th class="column-title">{{ __('user.index.username') }}</th>
                <th class="column-title">{{ __('user.index.email') }} </th>
                <th class="column-title">{{ __('user.index.fullname') }}</th>
                <th class="column-title">{{ __('user.index.gender') }}</th>
                <th class="column-title">{{ __('user.index.is_active') }}</th>
                <th class="column-title no-link last"><span class="nobr">{{ __('user.index.action') }}</span>
                </th>
                <th class="column-title no-link last"><span class="nobr">{{ __('user.index.user_info') }}</span>
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($result as $user)
                <tr class="even pointer">
                  <td class=" ">{{ $user->id }}</td>
                  <td class=" ">{{ $user->username }}</td>
                  <td class=" ">{{ $user->email }}</td>
                  <td class=" ">{{ $user->userInfo['full_name'] }}</td>
                  @if ( $user->userInfo['gender'] == 1 )
                    <td class="a-right a-right ">{{ __('user.index.female') }}</td>
                  @else 
                    <td class="a-right a-right ">{{ __('user.index.male') }}</td>
                  @endif
                  <td class=""><i class="fa fa-times-circle icon-size fa-2x"></i></td>
                  <td class="last"><a class="col-md-3" href="{{ route('admin.users.edit', array('id' => $user->id)) }}"><button class="btn-success"><i class="fa fa-edit"></i></button></a>
                  <form class="col-md-3" id="delete-user{{ $user->id }}" action="{!! route('admin.users.destroy', ['id' => $user['id']]) !!}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn-danger" onclick="deleteUser(event, {{ $user->id }})" type="submit"><i class="fa fa-trash"></i></button>
                  </form>
                  <td class="last"><a href="{{ route('admin.users.show', array('id' => $user->id)) }}">{{ __('user.index.detail') }}</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          {{ $result->render() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection