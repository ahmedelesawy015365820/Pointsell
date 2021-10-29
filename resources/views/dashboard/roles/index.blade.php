@extends('layouts.master')
@section('css')
@endsection
@section('title')
    @lang('site.Permission')
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.admins')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                @lang('site.Permission')</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@include('layouts.alerts.success')
@include('layouts.alerts.errors')

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            @can('Permission-create')
                                <a class="btn btn-primary" href="{{ route('dashboard.roles.create') }}">@lang('site.add')</a>
                            @endcan
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)

                                @if (Auth::user()->roles_name == 'SuperAdmin')
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>

                                        @can('Permission-show')
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('dashboard.roles.show', $role->id) }}"
                                                >
                                                @lang('site.show')
                                                <i class="typcn typcn-document-text"></i>
                                            </a>
                                        @endcan

                                        @can('Permission-edit')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                title="{{ __('site.edit')}}"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan

                                        @can('Permission-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-user_id="{{ $role->id }}"
                                                data-username="{{ $role->name}}"
                                                data-toggle="modal"
                                                href="#modaldemo8"
                                                title="{{ __('site.delete')}}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan

                                    </td>
                                </tr>
                                @elseif($role->name != 'SuperAdmin')
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>

                                            @can('Permission-show')
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('dashboard.roles.show', $role->id) }}"
                                                    >
                                                    @lang('site.show')
                                                    <i class="typcn typcn-document-text"></i>
                                                </a>
                                            @endcan

                                            @can('Permission-edit')
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                    title="{{ __('site.edit')}}"
                                                    >
                                                    <i class="las la-pen"></i>
                                                </a>
                                            @endcan

                                            @can('Permission-delete')
                                                <a class="modal-effect btn btn-sm btn-danger"
                                                    data-effect="effect-scale"
                                                    data-user_id="{{ $role->id }}"
                                                    data-username="{{ $role->name}}"
                                                    data-toggle="modal"
                                                    href="#modaldemo8"
                                                    title="{{ __('site.delete')}}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endcan
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>

<!--start Modal delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('site.u-del')</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('dashboard.roles.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>@lang('site.sure-delete')</p><br>
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input class="form-control" name="username" id="username" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.back')</button>
                    <button type="submit" class="btn btn-danger">@lang('site.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Modal delete -->

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var username = button.data('username')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #username').val(username);
    })

</script>
@endsection
