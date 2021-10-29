@extends('layouts.master')
@section('title')
    @lang('site.list-product')
@endsection
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.product')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.list-product')</span>
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
                            @can('product-create')
                                <a href="{{ route('dashboard.product.create') }}"
                                class="btn btn-sm btn-primary  mb-2"
                                style="color:white">
                                <i class="fas fa-plus"></i>&nbsp; @lang('site.add')
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 row align-items-center">
                        <form class="form-inline justify-content-end"
                            action="{{ route('dashboard.product.index') }}"
                            method="GET"
                            style="width: 100%"
                        >
                            <button type="submit" class="btn btn-sm btn-primary mb-2">@lang('site.search')</button>
                            <div class="form-group mb-2 col-4" >
                              <input type="text"
                                name="search"
                                class="form-control form-control-sm"
                                value="{{ request()->search }}"
                                placeholder="@lang('site.search')"
                              >
                            </div>
                            <div class="form-group mb-2 col-4">
                                <select name="category_id" class="form-control form-control-sm" style="width:90%">
                                    <option value="">@lang('site.category')</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                        {{request()->category_id == $category->id ? 'selected' : ''}}>
                                        {{$category->name}}
                                    </option>
                                    @endforeach
                                </select>
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
                                <th class="wd-15p border-bottom-0">@lang('site.description')</th>
                                <th class="wd-20p border-bottom-0">@lang('site.purchase_price')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.sale_price')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.profit')%</th>
                                <th class="wd-15p border-bottom-0">@lang('site.stock')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.categories')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.image')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $product)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ number_format( (($product->sale_price - $product->purchase_price)*100)/$product->sale_price , 2) }}%
                                    </td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <img
                                            src="{{ URL::asset('assets/img/product/'.$product->image) }}"
                                            alt="profile"
                                            class="img-thumbnail"
                                            width="100px"
                                        >
                                    </td>
                                    <td>
                                        @can('product-edit')
                                            <a href="{{ route('dashboard.product.edit', $product->id) }}"
                                                class="btn btn-sm btn-info"
                                                title="@lang('site.edit')"
                                                style="margin-bottom: 5px"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan
                                        @can('product-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-product_id="{{ $product->id }}"
                                                data-productname="{{ $product->name}}"
                                                data-toggle="modal"
                                                href="#modaldemo8"
                                                title="@lang('site.delete')">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>

                            @empty
                            <th class="text-center" colspan="10">@lang('site.no-data-found')</th>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $products->appends( request()->query() )->links() }}
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
                <form action="{{ route('dashboard.product.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>@lang('site.sure-delete')</p><br>
                        <input type="hidden" name="product_id" id="product_id" value="">
                        <input class="form-control" name="productname" id="productname" type="text" readonly>
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
        var product_id = button.data('product_id')
        var productname = button.data('productname')
        var modal = $(this)
        modal.find('.modal-body #product_id').val(product_id);
        modal.find('.modal-body #productname').val(productname);
    })

</script>


@endsection
