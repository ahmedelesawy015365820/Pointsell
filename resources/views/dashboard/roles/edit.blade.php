@extends('layouts.master')
@section('css')
@endsection
@section('title')
@lang('site.Permission-edit')
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.Permission')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.Permission-edit')</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>@lang('site.error')</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($role, ['method' => 'PATCH','route' => ['dashboard.roles.update', $role->id]]) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="form-group">
                        <p>@lang('site.permissions-name') :</p>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-10">
                        <ul>
                            <li>@lang('site.Permission')
                                <ul>
                                    <li>
                                        @foreach($permission as $value)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"

                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : "" }}
                                                type="checkbox"
                                                id="{{$value->name}}" value="{{$value->id}}"
                                                name="permission[]"
                                            >
                                            <label class="form-check-label" for="{{$value->name}}">{{ $value->name }}</label>
                                        </div>
                                        @endforeach
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-main-primary">@lang('site.update')</button>
                    </div>
                    <!-- /col -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
{!! Form::close() !!}
@endsection
@section('js')
@endsection
