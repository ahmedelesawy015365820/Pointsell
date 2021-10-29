@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('title')
@lang('site.edit-admins')
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.add-admins')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.edit-admins')</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

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

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.users.index') }}">@lang('site.back')</a>
                    </div>
                </div><br>

                {!! Form::model($user, ['method' => 'PATCH',
                                        'route' => ['dashboard.users.update', $user->id],
                                        'enctype' => 'multipart/form-data'])
                                        !!}

                <div class="">

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>@lang('site.First') : <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper"
                                value="{{$user->first_name}}"
                                name="first_name"
                                required
                                type="text">
                        </div>

                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>@lang('site.Last') : <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                value="{{$user->last_name}}"
                                data-parsley-class-handler="#lnWrapper"
                                name="last_name"
                                required
                                type="text"
                            >
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>@lang('site.image') : <span class="tx-danger">*</span></label>
                            <input
                                class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper"
                                name="image"
                                type="file"
                                accept=".jpg, .png, image/jpeg, image/png"
                                onchange="loadFile(event)"
                                >
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>@lang('site.E-mail'): <span class="tx-danger">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <img src="{{URL::asset('assets/img/faces/'. $user->image)}}"
                            alt="profile"
                            width="100px"
                            class="img-thumbnail"
                            id="output"
                            >
                        </div>
                    </div>

                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>@lang('auth.password'): <span class="tx-danger">*</span></label>
                        {!! Form::password('password', array('class' => 'form-control','required')) !!}
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> @lang('site.confirm-password'): <span class="tx-danger">*</span></label>
                        {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                    </div>
                </div>

                <div class="row mg-b-20">
                    <div class="col-lg-6">
                        <label class="form-label">@lang('site.Status')</label>
                        <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                            <option value="{{ $user->Status}}">{{ $user->Status}}</option>
                            <option value="active">active</option>
                            <option value="pending">pending</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>@lang('site.Permission')</strong>
                            <select name="roles_name" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{$role->name == $user->roles_name? 'selected' : ''}}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mg-t-30">
                    <button class="btn btn-main-primary pd-x-20" type="submit">@lang('site.update')</button>
                </div>
                {!! Form::close() !!}
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
@endsection
@section('js')

<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

<script>
    // jquery image preview

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

</script>
@endsection
