@extends('layouts.master')
@section('css')
@endsection
@section('title')
    @lang('site.add-orders')
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.clients')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.add-orders')</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    <div class="col-lg-6 col-md-6">

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.client.index') }}">@lang('site.back')</a>
                    </div>
                </div><br>

                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex">
                            <h4 class="content-title mb-0 my-auto">@lang('site.category')</h4>
                        </div>
                    </div>
                </div>

                @foreach ($categories as $category)

                <p>
                    <a class="btn btn-info btn-block"
                    data-toggle="collapse"
                    href="#{{str_replace(' ','-', $category->name)}}"
                    role="button" aria-expanded="false"
                    aria-controls="collapseExample">
                      {{$category->name}}
                    </a>
                </p>
                <div class="collapse" id="{{str_replace(' ','-', $category->name)}}">

                    @if ($category->product->count() > 0)

                    <div class="table-responsive">
                        <table class="table table-hover"  style=" text-align: center;">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">@lang('site.name')</th>
                                    <th class="wd-15p border-bottom-0">@lang('site.stock')</th>
                                    <th class="wd-10p border-bottom-0">@lang('site.sale_price')</th>
                                    <th class="wd-10p border-bottom-0">@lang('site.add')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category->product as $product)

                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td id="product-{{$product->id}}">{{ number_format($product->sale_price,2) }}</td>
                                    <td>
                                        <a href="#"
                                        id="products-{{ $product->id }}"
                                        class="btn btn-success btn-sm btn-click"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->sale_price }}"
                                        data-stock="{{ $product->stock }}"
                                        data-id="{{ $product->id }}"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else

                        @lang('site.no-data-found')

                    @endif

                </div>

                @endforeach

            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">

        <div class="card">
            <div class="card-body">

                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex">
                            <h4 class="content-title mb-0 my-auto">@lang('site.orders')</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <form
                        class="parsley-style-1 order-add"
                        action="{{route('dashboard.client.orders.store', $client->id)}}"
                        method="POST"
                    >

                        @csrf

                        <table class="table table-hover"  style=" text-align: center;">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">@lang('site.name')</th>
                                    <th class="wd-15p border-bottom-0">@lang('site.amount')</th>
                                    <th class="wd-10p border-bottom-0">@lang('site.sale_price')</th>
                                    <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                                </tr>
                            </thead>
                            <tbody class="row-now"></tbody>
                        </table>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>@lang('site.Totel'): <span class="total-price">0</span></h4>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button
                                class="btn btn-main-primary btn-block disabled"
                                id="submit-order"
                                type="submit"
                            >
                                @lang('site.add')
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

        @if ($orders->count() > 0)
            <div class="card">
                <div class="card-body">

                    <div class="breadcrumb-header justify-content-between">
                        <div class="my-auto">
                            <div class="d-flex">
                                <h4 class="content-title mb-0 my-auto">@lang('site.previous-orders')</h4>
                            </div>
                        </div>
                    </div>

                    @foreach ($orders as $order)

                        <p>
                            <a
                                class="btn btn-danger btn-block"
                                data-toggle="collapse"
                                href="#order-{{$order->id}}{{$order->created_at->format('s')}}"
                                role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                {{ $order->created_at->toFormattedDateString() }}
                            </a>
                        </p>

                        <div class="collapse" id="order-{{$order->id}}{{$order->created_at->format('s')}}">

                            <div class="table-responsive">
                                <table class="table table-hover"  style=" text-align: center;">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">@lang('site.name')</th>
                                            <th class="wd-15p border-bottom-0">@lang('site.stock')</th>
                                            <th class="wd-10p border-bottom-0">@lang('site.sale_price')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->pivot->amount }}</td>
                                                <td>{{ $product->pivot->amount * $product->sale_price}}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    @endforeach

                    {{ $orders->links() }}

                </div>
            </div>
        @endif
    </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<script>

    $('.btn-click').on('click', function (e) {

        e.preventDefault();

        var id = $(this).data('id'),
            name = $(this).data('name'),
            price = $(this).data('price'),
            stock = $(this).data('stock');

            let html = `
                <tr id="order-${id}">
                    <td>${name}</td>
                        <input type='hidden' name='products[]' value='${id}'>
                        <input type='hidden' class='price-total-request' name='price' value=''>
                    <td>
                        <input
                            type='number'
                            min='1'
                            value='1'
                            max='${stock}'
                            class='form-control form-control-sm amount'
                            name='amounts[]'
                            required
                            data-id='${id}'
                        >
                    </td>
                    <td class='price-order' id='price-${id}'>${ $.number( price, 2 ) }</td>
                    <td>
                        <a class="btn btn-sm btn-danger delete-row"
                            data-effect="effect-scale"
                            data-id="${id}"
                            data-name="${name}"
                            data-toggle="modal"
                            href="#"
                            title="@lang('site.delete')">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $('.row-now').append(html);

            $(this).removeClass('btn-success').addClass('disabled btn-default');

            if(price > 0){
                $('#submit-order').removeClass('disabled');
            }else{
                ('#submit-order').addClass('disabled');
            }

            calculate();

    });

    // remove order
    $('body').on('click', '.delete-row',function (e) {

        e.preventDefault();

        $('#order-' + $(this).data('id')).remove();
        $('#products-' + $(this).data('id'))
            .removeClass('disabled btn-default')
            .addClass('btn-success');

        calculate();

    });

    // change price
    $('body').on('keyup change', '.amount',function () {

        var amount = $(this).val(),
            i = $('.row-now tr #price-' + $(this).data('id')),
            o = $('#product-' + $(this).data('id')),
            value = parseFloat(amount) * parseFloat(o.text()),
            price = 0;

            i.html($.number( value, 2 ));

            calculate();
    });

    // total price
    function calculate(){

        var price = 0;

        $('.row-now tr .price-order').each(function () {

            price += parseFloat( $(this).html() );

        });

        $('span.total-price').html($.number( price, 2 ));

        $('.price-total-request').val(price);

    }

    $('.order-add').submit(function (e) {

        var i = document.querySelector('.row-now').childElementCount;

        if(i == 0){
            e.preventDefault();
        }

    });


</script>

@endsection
