@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection
@section('title')
    @lang('site.add-product')
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">@lang('site.product')</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                @lang('site.add-product')</span>
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
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.product.index') }}">@lang('site.back')</a>
                    </div>
                </div><br>
                <form class="parsley-style-1"
                    id="selectForm2"
                    autocomplete="off"
                    name="selectForm2"
                    action="{{route('dashboard.product.update', $product->id)}}"
                    method="POST"
                    enctype="multipart/form-data"
                    >

                    @csrf
                    {{method_field('put')}}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-12" id="fnWrapper">
                                <label>@lang('site.name') : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper"
                                    name="name"
                                    required
                                    type="text"
                                    value="{{$product->name}}"
                                >
                            </div>

                            <div class="parsley-input col-md-12 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>@lang('site.description') : <span class="tx-danger">*</span></label>
                                <textarea class="form-control ckeditor"
                                id="summary-ckeditor"
                                name="description">
                                    {{$product->description}}
                                </textarea>
                            </div>

                        </div>

                        <div class="row mg-b-20">

                            <div class="col-lg-6 mg-t-20 mg-md-t-0">
                                <label class="form-label">@lang('site.category')</label>
                                <select name="category_id" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="{{$product->category->id}}">
                                        {{$product->category->name}}
                                    </option>

                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
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
                                    <img src="{{URL::asset('assets/img/product/' . $product->image )}}"
                                        alt="profile"
                                        width="100px"
                                        class="img-thumbnail"
                                        id="output"
                                    >
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>@lang('site.purchase_price') : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper"
                                    name="purchase_price"
                                    required
                                    type="number"
                                    value="{{$product->purchase_price}}"
                                >
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>@lang('site.sale_price') : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper"
                                    name="sale_price"
                                    required
                                    type="number"
                                    step="0.01"
                                    value="{{$product->sale_price}}"
                                >
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>@lang('site.stock') : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper"
                                    name="stock"
                                    required
                                    type="number"
                                    step="0.01"
                                    value="{{$product->stock}}"
                                >
                            </div>

                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">@lang('site.add')</button>
                    </div>
                </form>
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

{{-- /start ckeditor --}}
<script src="{{URL::asset('assets/ckeditor/ckeditor.js')}}"></script>

<script>
    // jquery image preview

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    // ckeditor direction
    CKEDITOR.config.language = '{{app()->getLocale()}}';


</script>

@endsection
