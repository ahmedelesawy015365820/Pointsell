@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            }
            .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 40px;
            height: 40px;
            margin: 5px;
            border: 5px solid #fff;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #00b9ff transparent transparent transparent;
            }
            .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
            }
            .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
            }
            .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
            }
            @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
            }
    </style>
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


    <div class="col-lg-8 col-md-8">

        <div class="card">

            <div class="card-header pb-0">
                <div class="row justify-content-between">
                    <div class="col-xl-3 col-xl-3 col-md-4 row">
                        <div class="form-inline">
                            <div class="d-flex">
                                <h4 class="content-title mb-0 my-auto">@lang('site.orders')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 row align-items-center">
                        <form class="form-inline" action="{{ route('dashboard.orders.index') }}" method="GET">
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
                                <th class="wd-15p border-bottom-0">@lang('site.client_name')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.price')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.time')</th>
                                <th class="wd-10p border-bottom-0">@lang('site.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)

                                <tr>
                                    <td>{{ $order->clients->name }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                    <td>

                                        <a class="btn btn-success btn-sm show-product"
                                            href="#"
                                            data-url="{{ route('dashboard.orders.product', $order->id) }}"
                                            data-method="Get"
                                            title="@lang('site.show')"
                                            >
                                            <i class="typcn typcn-document-text"></i>
                                        </a>

                                        @can('order-edit')
                                            <a href="{{route('dashboard.client.orders.edit',[$order->clients->id,$order->id] )}}"
                                                class="btn btn-sm btn-info"
                                                title="@lang('site.edit')"
                                                >
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endcan
                                        @can('order-delete')
                                            <a class="modal-effect btn btn-sm btn-danger"
                                                data-effect="effect-scale"
                                                data-order_id="{{ $order->id }}"
                                                data-orderyname="{{ $order->clients->name }}"
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

                {{ $orders->appends( request()->query() )->links() }}
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4">

        <div class="card" id="print">
            <div class="card-body">

                <div class="breadcrumb-header justify-content-between">
                    <div class="my-auto">
                        <div class="d-flex">
                            <h4 class="content-title mb-0 my-auto">@lang('site.View-products')</h4>
                        </div>
                    </div>
                </div>

                <div class="breadcrumb-header justify-content-center" id="lds-ring" style="display: none">
                    <div class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

                <div class="table-responsive product-order" style="display:none">
                    <table class="table table-hover"
                        style=" text-align: center;"
                    >
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">@lang('site.client_name')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.amount')</th>
                                <th class="wd-15p border-bottom-0">@lang('site.price')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4>@lang('site.Totel'): <span class="total-price">0</span></h4>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button
                            class="btn btn-main-primary btn-block"
                            id="print_Button"
                            type="button"
                            onclick='printDiv()'
                        >
                            @lang('site.print')
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<!--start Modal delete -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">@lang('site.u-del')</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('dashboard.orders.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>@lang('site.sure-delete')</p><br>
                    <input type="hidden" name="order_id" id="order_id" value="">
                    <input class="form-control" name="orderyname" id="orderyname" type="text" readonly>
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
    $('.show-product').on('click', function (e) {

        $('#lds-ring').css('display', 'flex');

        $('.product-order').css('display' ,'none');

        $('.product-order table tbody').empty();;

        e.preventDefault();

        var url = $(this).data('url'),
            method = $(this).data('method');

        $.ajax({
            type: method,
            dataType: "json",
            url: url,
            cache: false,
            proccessData: false,
            contentType: false,
            success: function (data) {

                $('.product-order').css('display' ,'block');

                $.each(data.products, function(key, value) {
                    var html = `
                        <tr>
                            <td>${value['name']}</td>
                            <td>${ value['pivot']['amount'] }</td>
                            <td class='price-order'>${ $.number(value['pivot']['amount'] * value['sale_price'],2)}</td>
                        </tr>
                    `;

                    $('#lds-ring').css('display', 'none');

                    $('.product-order table tbody').append(html);

                });

                calculate();

            }
        });

    });

    // total price
    function calculate(){

        var price = 0;

        $('tr .price-order').each(function () {

            price += parseFloat( $(this).html() );

        });

        $('span.total-price').html($.number( price, 2 ));

    }

    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var client_id = button.data('order_id')
        var clientname = button.data('orderyname')
        var modal = $(this)
        modal.find('.modal-body #order_id').val(client_id);
        modal.find('.modal-body #orderyname').val(clientname);
    })

</script>

@endsection
