@if(Session::has('error'))
    <div class="row mr-2 ml-2" >
            <div type="text col-4" class="btn btn-lg btn-block btn-danger mb-2"
                    id="type-error">{{Session::get('error')}}
            </div>
    </div>
@endif