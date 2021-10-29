@extends('layouts.master')
@section('title')
    @lang('site.category')
@endsection
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.category')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.list-category')</span>
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
                            @can('category-create')
                                <a href="{{ route('dashboard.categories.create') }}"
                                class="btn btn-sm btn-primary  mx-sm-3 mb-2"
                                style="color:white">
                                <i class="fas fa-plus"></i>&nbsp; @lang('site.add')
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-4 row align-items-center">
                        <form class="form-inline" action="{{ route('dashboard.categories.index') }}" method="GET">
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
                                <th class="wd-15p border-bottom-0">@lang('site.number-of-products')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $key => $category)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ route('dashboard.product.index', ['category_id' => $category->id] )}}">
                                        {{ $category->name }}
                                        </a>
                                    </td>
                                    <td>{{ $category->product->count() }}</td>
                                    <td>
                                        @can('category-edit')
                                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-info"
                                                title="@lang('site.edit')"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan
                                        @can('category-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-category_id="{{ $category->id }}"
                                                data-categoryname="{{ $category->name}}"
                                                data-toggle="modal"
                                                href="#modaldemo8"
                                                title="@lang('site.delete')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                            <th class="text-center" colspan="4">@lang('site.no-data-found')</th>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $categories->appends( request()->query() )->links() }}
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
                <form action="{{ route('dashboard.categories.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>@lang('site.sure-delete')</p><br>
                        <input type="hidden" name="category_id" id="category_id" value="">
                        <input class="form-control" name="categoryname" id="categoryname" type="text" readonly>
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
        var category_id = button.data('category_id')
        var categoryname = button.data('categoryname')
        var modal = $(this)
        modal.find('.modal-body #category_id').val(category_id);
        modal.find('.modal-body #categoryname').val(categoryname);
    })

</script>


@endsection
