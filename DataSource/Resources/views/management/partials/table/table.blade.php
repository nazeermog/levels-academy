<table class="table table-hover">
    <thead>
    <tr>
        <th style="color: #f8310e">#</th>
        <th style="color: #f8310e"> Image</th>
        <th style="color: #f8310e">Title Arabic</th>
        <th style="color: #f8310e">Title English</th>
        <th style="color: #f8310e">Status</th>
        <th style="color: #f8310e">Actions</th>

    </tr>
    </thead>
    <tbody>

    @foreach($list as $item)
        @if ($item->type != 8)
            <tr>
                <td>{{  $item->id}}</td>
                <td><img src="{{  $item->primary_image}}" width="50"></td>
                <td>{{  $item->translate('ar')->title}}</td>
                <td>{{  $item->translate('en')->title}}</td>
                <td>
                    <input type="checkbox"
                           name="my-checkbox"
                           data-bootstrap-switch
                           {{  $item->status?'checked':''}}
                           value="{{$item->id}}"
                           data-off-color="danger"
                           data-on-color="success">
                </td>
                <td>
                    <div class="row">

                        <div class="col-6">
                            <a href="{{route('admin.'.$route_name.'.edit',$item->id)}}" class="btn btn-outline-primary">
                                Edit
                            </a>
                        </div>

                        <div class="col-6">
                            <button class="btn btn-outline-danger" data-toggle="modal"
                                    data-target="#exampleModal{{$item->id}}">
                                Delete
                            </button>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        Are You Sure You Wont Delete {{$item->translate('ar')->title}}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form action="{{route('admin.'.$route_name.'.delete')}}" method="POST">
                                            <input type="hidden" value="{{$item->id}}" name="id">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </td>

            </tr>
        @else
            <tr>
                <td>{{  $item->id}}</td>
                <td><img src="{{  $item->primary_image}}" width="50"></td>
                <td></td>
                <td></td>
                <td>
                    <input type="checkbox"
                           name="my-checkbox"
                           data-bootstrap-switch
                           {{  $item->status?'checked':''}}
                           value="{{$item->id}}"
                           data-off-color="danger"
                           data-on-color="success">
                </td>
                <td>
                    <div class="row">

                        <div class="col-6">
                            <a href="{{route('admin.'.$route_name.'.edit',$item->id)}}" class="btn btn-outline-primary">
                                Edit
                            </a>
                        </div>

                        <div class="col-6">
                            <button class="btn btn-outline-danger" data-toggle="modal"
                                    data-target="#exampleModal{{$item->id}}">
                                Delete
                            </button>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        Are You Sure You Wont Delete ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form action="{{route('admin.'.$route_name.'.delete')}}" method="POST">
                                            <input type="hidden" value="{{$item->id}}" name="id">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </td>

            </tr>
        @endif

    @endforeach
    </tbody>
</table>
