@extends('instructor.layouts.dashboard')
@section('title')
{{$table_name}}
@endsection

@section('content')
<div class="container py-5">
    <!-- page-header-->
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"></div>

    </div>
    <!--end breadcrumb-->
    <!--EN FOR  page-header-->
    <div class="card border-top border-0 border-4 border-primary table-responsive">

        <div class="card-header">
            <h3 class="card-title float-left">
                @if(session('locale', config('app.locale')) == 'en')
                List of Practice Type Details
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                قائمة تفاصيل التمرين
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                Liste der Details zum Übungstyp
                @endif
            </h3>

            <a href="{{route('instructor.'.$route_name.'.create')}}" class="btn btn-primary float-right">
                @if(session('locale', config('app.locale')) == 'en')
                + Add New
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                + إضافة جديد
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                + Neu hinzufügen
                @endif
            </a>


        </div>
        <div class="card-body ">
            @if (isset($list)&&$list->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if(session('locale', config('app.locale')) == 'en')
                            <th> Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                            @endif
                            @if(session('locale', config('app.locale')) == 'ar')
                            <th>العنوان</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                            @endif
                            @if(session('locale', config('app.locale')) == 'de')
                            <th>Titel</th>
                            <th>Status</th>
                            <th>Aktionen</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $item)
                        <tr>
                            <td>{{ $item->id}}</td>
                            <td>{{($item->title)}}</td>
                            <td>
                                <input type="checkbox" name="my-checkbox" data-bootstrap-switch {{($item->is_active)?'checked':''}} value="{{$item->id}}" data-off-color="danger" data-on-color="success">
                            </td>
                            <td>
                                <div class="row">

                                    <div class="ml-1">
                                        <a href="{{route('instructor.'.$route_name.'.show',$item->id)}}" class="btn btn-outline-primary ">
                                            @if(session('locale', config('app.locale')) == 'en')
                                            Edit
                                            @endif
                                            @if(session('locale', config('app.locale')) == 'ar')
                                            تعديل
                                            @endif
                                            @if(session('locale', config('app.locale')) == 'de')
                                            Bearbeiten
                                            @endif
                                            </a>
                                        <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal{{$item->id}}">
                                        @if(session('locale', config('app.locale')) == 'en')
                                        Delete
                                        @endif
                                        @if(session('locale', config('app.locale')) == 'ar')
                                        حذف
                                        @endif
                                        @if(session('locale', config('app.locale')) == 'de')
                                        Löschen
                                        @endif
                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        @if(session('locale', config('app.locale')) == 'en')
                                                        Delete Confirmation
                                                        @endif
                                                        @if(session('locale', config('app.locale')) == 'ar')
                                                        تأكيد الحذف
                                                        @endif
                                                        @if(session('locale', config('app.locale')) == 'de')
                                                        Bestätigung löschen
                                                        @endif
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                @if(session('locale', config('app.locale')) == 'en')
                                                Are You Sure You Want Delete
                                                @endif
                                                @if(session('locale', config('app.locale')) == 'ar')
                                                هل أنت متأكد أنك تريد حذف
                                                @endif
                                                @if(session('locale', config('app.locale')) == 'de')
                                                Sind Sie sicher, dass Sie löschen möchten
                                                @endif
                                                     {{$item->title}}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        @if(session('locale', config('app.locale')) == 'en')
                                                        Close
                                                        @endif
                                                        @if(session('locale', config('app.locale')) == 'ar')
                                                        اغلاق
                                                        @endif
                                                        @if(session('locale', config('app.locale')) == 'de')
                                                        Schließen
                                                        @endif    
                                                    </button>
                                                    <form action="{{route('instructor.'.$route_name.'.destroy',$item->id)}}" method="POST">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" class="btn btn-danger">
                                                            @if(session('locale', config('app.locale')) == 'en')
                                                            Delete
                                                            @endif
                                                            @if(session('locale', config('app.locale')) == 'ar')
                                                            حذف
                                                            @endif
                                                            @if(session('locale', config('app.locale')) == 'de')
                                                            Löschen
                                                            @endif   
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 mb-3 mx-3">
                    {{$list->links('datasource::management.partials.pagination',['paginator'=>$list])}}
                </div>

            </div>
            @else
            <h2>
            @if(session('locale', config('app.locale')) == 'en')
                There Is No Practice Type Details Yet.
                @endif
                @if(session('locale', config('app.locale')) == 'ar')
                لا توجد تفاصيل عن اي نوع تمارين حتى الآن.
                @endif
                @if(session('locale', config('app.locale')) == 'de')
                Es gibt noch keine Details zum Übungstyp.
                @endif
            </h2>
            @endif
        </div>
    </div>
</div>

@endsection
@push('js')

<script>
$('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
{{--$.ajax({--}}
{{--    method: "POST",--}}
{{--    url: "{{ route('admin.'.$route_name.'.toggleStatus')}}",--}}
{{--    data: {--}}
{{--        model_id: event.target.value--}}
{{--    },--}}
{{--    success: function (one, two, three) {--}}
{{--        toastr.success('updated successfully')--}}
{{--    },--}}
{{--    error: function (one, two, three) {--}}
{{--        toastr.error('error')--}}
{{--    },--}}
{{--});--}}
});

</script>
@endpush