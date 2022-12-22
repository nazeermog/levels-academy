@if (session()->has('success'))
{{--    <div class="alert alert-success alert-dismissible">--}}
{{--        <button type="button" class="close text-danger" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--        <h5><i class="icon fas fa-check"></i> Success!</h5>--}}
{{--        {{session('success')}}--}}
{{--    </div>--}}

    <div class="alert alert-soft-success alert-dismissible fade show" role="alert">
        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex flex-wrap align-items-start">
            <div class="mr-8pt">
                <i class="material-icons">access_time</i>
            </div>
            <div class="flex"
                 style="min-width: 180px">
                <small class="text-black-100">
                    <strong>Success - </strong> {{session('success')}}
                </small>
            </div>
        </div>
    </div>
@endif
