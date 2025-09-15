@extends('datasource::management.layout.master')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    
    <div class="text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-teal-600">Import Students via CSV</h2>
        <p class="text-gray-600 mt-2">Upload your student list quickly and securely.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Upload CSV File</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-teal-500 transition cursor-pointer">
                    <input type="file" name="file" class="hidden" id="fileInput" required>
                    <label for="fileInput" class="cursor-pointer">
                        <span class="material-icons text-teal-500 text-4xl mb-2">upload_file</span>
                        <p class="text-gray-600">Click to browse or drag & drop your CSV file here</p>
                    </label>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-teal-600 text-black px-6 py-2.5 rounded-lg hover:bg-teal-700 transition font-semibold shadow">
                    Import Students
                </button>
            </div>
        </form>
    </div>

    @if(Storage::exists('imports'))
        <div class="mt-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📂 Previous Import Files</h3>
            <div class="bg-gray-50 p-4 rounded-lg border">
                <ul class="space-y-2">
                    @foreach(Storage::files('imports') as $file)
                        <li>
                            <a href="{{ route('admin.download.csv', basename($file)) }}" 
                               class="text-teal-600 hover:underline flex items-center space-x-2">
                                <span class="material-icons text-sm">insert_drive_file</span>
                                <span>{{ basename($file) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</div>
@endsection
