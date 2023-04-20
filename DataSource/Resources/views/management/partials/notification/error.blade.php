@if (isset($errors)&&count($errors)>0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        @foreach ($errors->all() as $error)
            <div class=" ml-4 mr-4 ">{{$error}}</div>
        @endforeach
    </div>
@endif
