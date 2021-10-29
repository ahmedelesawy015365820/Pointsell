@extends('layouts.master')
@section('title')
    @lang('site.admins')
@endsection
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.admins')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.list-admins')</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

@include('layouts.alerts.success')
@include('layouts.alerts.errors')

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row justify-content-between">
                    <div class="col-xl-3 col-xl-3 col-md-4 row">
                        <div class="form-inline">
                            @can('user-create')
                                <a href="{{ route('dashboard.users.create') }}"
                                class="btn btn-sm btn-primary  mx-sm-3 mb-2"
                                style="color:white">
                                <i class="fas fa-plus"></i>&nbsp; @lang('site.add')
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 row align-items-center">
                        <form class="form-inline" action="{{ route('dashboard.users.index') }}" method="GET">
                            <button type="submit" class="btn btn-sm btn-primary mb-2">@lang('site.search')</button>
                            <div class="form-group mx-sm-3 mb-2">
                              <input type="text"
                                name="search"
                                class="form-control form-control-sm"
                                value="{{ request()->search }}"
                                placeholder="@lang('site.search')"
                              >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover"  style=" text-align: center;">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">@lang('site.First')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.Last')</th>
                                <th class="wd-20p border-bottom-0">@lang('site.E-mail')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.Status')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.image')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.Permission')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $user)
                                @if ($user->roles_name != 'SuperAdmin')

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->Status == 'active')
                                            <span class="label text-success d-flex">
                                                <div class="bg-success ml-1"></div>{{ $user->Status }}
                                                <span class="pulse" style="position: static;"></span>
                                            </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                <div class="bg-danger ml-1"></div>{{ $user->Status }}
                                                <span class="pulse"
                                                style="position: static;background-color:#ee335e;" >
                                                </span>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <img
                                        src="{{ URL::asset('assets/img/faces/'.$user->image) }}"
                                        alt="profile"
                                        class="img-thumbnail"
                                        width="100px"
                                        >
                                    </td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))

                                                @foreach ($user->getRoleNames() as $v)

                                                    <label class="badge badge-success">
                                                        {{ $v }}
                                                    </label>

                                                @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        @can('user-edit')
                                            <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-info"
                                                title="@lang('site.edit')"
                                                style="margin-bottom: 5px"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan
                                        @can('user-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-user_id="{{ $user->id }}"
                                                data-username="{{ $user->first_name}} {{$user->last_name }}"
                                                data-toggle="modal"
                                                href="#modaldemo8"
                                                title="@lang('site.delete')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>

                                @endif
                            @empty
                            <th class="text-center" colspan="8">@lang('site.no-data-found')</th>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $data->appends( request()->query() )->links() }}
            </div>
        </div>
    </div>
    <!--/div-->


<!--start Modal delete -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('site.u-del')</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('dashboard.users.destroy', 'test') }}" method="post">
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

</div>


</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

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
