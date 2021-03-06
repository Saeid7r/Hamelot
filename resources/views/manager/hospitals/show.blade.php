@extends('layouts.app')
@section('title', $hospital->title)
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ $hospital->title }}</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">{{$hospital->title}}</div>
            <div class="col-md-3">:{{__('hospitals.title')}}</div>
          </div>
          <div class="row">
            <div class="col-md-9">{{$hospital->address}}</div>
            <div class="col-md-3">:{{__('hospitals.address')}}</div>
          </div>
          <div class="row">
            <div class="col-md-9">{{$hospital->phone}}</div>
            <div class="col-md-3">:{{__('hospitals.phone')}}</div>
          </div>
          <div class="row">
            <div class="col-md-9">{{$hospital->mobile}}</div>
            <div class="col-md-3">:{{__('hospitals.mobile')}}</div>
          </div>
          <div class="row">
            <div class="col-md-9">{{$hospital->status_str()}}</div>
            <div class="col-md-3">:{{__('hospitals.status')}}</div>
          </div>
          <div class="row">
            <img src="{{asset($hospital->image)}}" />
          </div>
          <div class="row">
            <a href="{{route('hospitals.edit', ['hospital' => $hospital])}}" class="btn btn-primary" role="button">{{__('hospitals.edit')}}</a>
            <form action="{{route('hospitals.destroy', ['hospital' => $hospital])}}" method="post">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger">حذف</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8" style="margin-top: 1rem">
      <a href="{{route('departments.create',['hospital' => $hospital])}}" class="btn btn-info" role="button">{{__('departments.create')}}</a>
    </div>
    <div class="col-md-8" style="margin-top: 1rem">
      <div class="card">
        <div class="card-header">{{__('departments.index_title')}}</div>
        <div class="card-body">
          @if(sizeof($hospital->departments))
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{__('departments.row')}}</th>
                  <th>{{__('departments.title')}}</th>
                  <th>{{__('departments.status')}}</th>
                  <th>{{__('departments.operation')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($hospital->departments as $department)
                  <tr>
                    <td>{{$department->id}}</td>
                    <td><a href="{{route('departments.show', ['department' => $department])}}">{{$department->title}}</a></td>
                    <td>{{$department->status_str()}}</td>
                    <td>
                      <a href="{{route('departments.edit', ['department' => $department])}}" class="btn btn-info" role="button">{{__('departments.edit')}}</a>
                      <form action="{{route('departments.destroy', ['department' => $department])}}" style="display: inline" method="POST" class="trash-icon">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">{{__('departments.remove')}}</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="row">
              <div class="col-md-12" style="text-align: center">
                {{__('departments.not_found')}}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
