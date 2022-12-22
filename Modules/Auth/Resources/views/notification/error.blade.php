@if (isset($errors)&&count($errors)>0)
    @foreach ($errors->all() as $error)


    <div class="alert alert-soft-accent alert-dismissible fade show"
         role="alert">
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
                    <strong>Error - </strong>{{$error}}
                </small>
            </div>
        </div>
    </div>
    @endforeach

@endif
