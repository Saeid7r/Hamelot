@extends('layouts.app')
@section('title', __('hospital_users.index.title'))
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <a href="{{route('hospital_users.create')}}" class="btn btn-info" role="button">{{__('hospital_users.create')}}</a>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="{{route('hospital_users.index',['sort' => $sort])}}" method="get">
          <div class="input-group">
            <input type="text" class="form-control" name="search" value="{{old('search')}}" placeholder="{{__('hospital_users.index_title')}}" aria-label="آزمون‌ها">
            <span class="input-group-btn">
              <button type="submit" class="btn accent-color text-primary-color">{{__('hospital_users.search')}}</button>
            </span>
          </div>
        </form>
      </div>
    </div>
    <br />
    @if(sizeof($hospital_users))
      <table class="table table-striped">
        <thead>
          <tr>
            <th ><a href="{{route('hospital_users.index',['search' => $search,'sort' => 'id'    ,'page' => $hospital_users->currentPage()])}}">{{__('hospital_users.row')}}</a></th>
            <th ><a href="{{route('hospital_users.index',['search' => $search,'sort' => 'hospital_id'    ,'page' => $hospital_users->currentPage()])}}">{{__('hospital_users.hospital_id')}}</a></th>
            <th ><a href="{{route('hospital_users.index',['search' => $search,'sort' => 'user_id'    ,'page' => $hospital_users->currentPage()])}}">{{__('hospital_users.user_id')}}</a></th>
            <th >{{__('hospital_users.operation')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($hospital_users as $hospital_user)
            <tr>
            <td>{{$hospital_user->id}}</td>
            <td><a href="{{route('hospitals.show', ['hospital' => $hospital_user->hospital])}}">{{$hospital_user->hospital->title}}</a></td>
            <td><a href="{{route('users.show', ['user' => $hospital_user->user])}}">{{$hospital_user->user->first_name}} {{$hospital_user->user->last_name}}</a></td>
            <td>
              <form action="{{route('hospital_users.destroy', ['hospital_user' => $hospital_user])}}" style="display: inline" method="POST" class="trash-icon">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">{{__('hospital_users.remove')}}</button>
              </form>
              <a href="{{route('hospital_users.edit', ['hospital_user' => $hospital_user])}}" class="btn btn-info" role="button">{{__('hospital_users.edit')}}</a>
            </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div class="row">
        <div class="col-md-12" style="text-align: center">
          {{__('hospital_users.not_found')}}
        </div>
      </div>
    @endif
    </table>
  </div>
  <div class="row" style="text-align: center;">
    {{$hospital_users->links()}}
  </div>
@endsection
