@extends('datasource::management.layout.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Organization Dashboard @if($org) ({{ $org->name }}) @endif</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $stats['users'] }}</h3>
                                            <p>Total Users</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $stats['students'] }}</h3>
                                            <p>Students</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $stats['instructors'] }}</h3>
                                            <p>Instructors</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


