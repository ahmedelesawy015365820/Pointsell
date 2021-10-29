@extends('layouts.master')
@section('title')
    @lang('site.clients')
@endsection
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.clients')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.list-clients')</span>
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
                            @can('client-create')
                                <a href="{{ route('dashboard.client.create') }}"
                                class="btn btn-sm btn-primary  mx-sm-3 mb-2"
                                style="color:white">
                                <i class="fas fa-plus"></i>&nbsp; @lang('site.add')
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 row align-items-center">
                        <form class="form-inline" action="{{ route('dashboard.client.index') }}" method="GET">
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
                                <th class="wd-15p border-bottom-0">@lang('site.name')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.phone')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.address')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.add-orders')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $key => $client)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>
                                        @can('orders-add')
                                            <a href="{{route('dashboard.client.orders.create', $client->id)}}"
                                                class="btn btn-sm btn-primary"
                                                >
                                                @lang('site.add-orders')
                                            </a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('client-edit')
                                            <a href="{{ route('dashboard.client.edit', $client->id) }}"
                                                class="btn btn-sm btn-info"
                                                title="@lang('site.edit')"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan
                                        @can('client-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-client_id="{{ $client->id }}"
                                                data-clientname="{{ $client->name}}"
                                                data-toggle="modal"
                                                href="#modaldemo8"
                                                title="@lang('site.delete')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                            <th class="text-center" colspan="6">@lang('site.no-data-found')</th>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $clients->appends( request()->query() )->links() }}
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
                <form action="{{ route('dashboard.client.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>@lang('site.sure-delete')</p><br>
                        <input type="hidden" name="client_id" id="client_id" value="">
                        <input class="form-control" name="clientname" id="clientname" type="text" readonly>
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
        var client_id = button.data('client_id')
        var clientname = button.data('clientname')
        var modal = $(this)
        modal.find('.modal-body #client_id').val(client_id);
        modal.find('.modal-body #clientname').val(clientname);
    })

</script>


@endsection
