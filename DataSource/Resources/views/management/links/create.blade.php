@extends('datasource::management.layout.master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Add Link</h3></div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif

                <form method="POST" action="{{ route('admin.links.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Intro video" required>
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="url" id="url" name="url" class="form-control" value="{{ old('url') }}" placeholder="https://..." required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.links.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
