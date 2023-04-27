@extends('datasource::management.layout.master')
@section('title')
    {{$table_name}}
@endsection
@push('css')
    <style>
        .alert-danger-edited {
            color: #000;
            background-color: #dc35457a;
            border-color: #dc35457a;
        }

        .alert-success-edited {
            color: #000;
            background-color: #28a7457a;
            border-color: #28a7457a;
        }
    </style>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- page-header-->
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                {{--                <div class="breadcrumb-title pe-3">   {{$table_name}}</div>--}}

            </div>
            <!--end breadcrumb-->
            <!--EN FOR  page-header-->
            <div class="card border-top border-0 border-4 border-primary table-responsive">
                <div class="card-header">
                    <h3 class="card-title float-left">List of {{$table_name}}</h3>
                </div>
                <div class="card-body ">
                    @if (isset($list)&&$list->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>

                                    <th>Level</th>
                                    <th>Result Real</th>
                                    <th>Result Student</th>
                                    <th>Duration</th>
                                    <th>Card Number</th>
                                    <th>Range Number</th>
                                    <th>Winner</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr >
                                        <td>{{ $item->id}}</td>
                                        <td>
                                            {{--                                            {{$item->student->first_name .' '.$item->student->last_name}}--}}
                                            Student Name
                                        </td>

                                        <td>
                                            {{$item->level_title}}
                                        </td>
                                        <td>
                                            {{$item->result_true}}
                                        </td>
                                        <td>
                                            {{$item->result_student}}
                                        </td>
                                        <td>
                                            {{$item->resultsType->seconds_speed}} Second
                                        </td>
                                        <td>
                                            {{$item->resultsType->card_number}}
                                        </td>
                                        <td>
                                            [ {{$item->resultsType->range_number_from.' ,'.$item->resultsType->range_number_to}}
                                            ]

                                        </td>
                                        <td class="{{$item->is_true?'alert-success-edited':'alert-danger-edited'}}">
                                            @if($item->is_true)
                                                <i class="fas fa-check text-success " style="padding-left: 2rem!important;"></i>

                                            @else
                                                <i class=" fas fa-ban text-danger " style="padding-left: 2rem!important;"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 mb-3 mx-3">
                                {{$list->links('datasource::management.partials.pagination',['paginator'=>$list])}}
                            </div>
                            @else
                                <h2>
                                    There is no {{$table_name}} Yet
                                </h2>
                            @endif
                        </div>
                </div>
            </div>
        </div>

@endsection

