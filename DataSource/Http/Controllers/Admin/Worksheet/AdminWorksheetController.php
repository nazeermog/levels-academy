<?php

namespace DataSource\Http\Controllers\Admin\Worksheet;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Worksheet\Worksheet;

/**
 * Admin management of worksheets (PDF / Word files) that can be attached to any
 * course step in the course builder.
 */
class AdminWorksheetController extends BaseController
{
    /** Accepted upload types + max size (KB). */
    private const FILE_RULES = 'file|mimes:pdf,doc,docx|max:20480';

    public function index()
    {
        $worksheets = Worksheet::orderByDesc('id')->paginate(20);

        return view('datasource::management.worksheets.index', compact('worksheets'));
    }

    public function create()
    {
        return view('datasource::management.worksheets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|'.self::FILE_RULES,
            'is_active'   => 'nullable|boolean',
        ]);

        $worksheet = new Worksheet();
        $worksheet->title = $data['title'];
        $worksheet->description = $data['description'] ?? null;
        $worksheet->is_active = (bool) ($data['is_active'] ?? true);
        $this->attachFile($request, $worksheet);
        $worksheet->save();

        return redirect()->route('admin.worksheets.index')->withSuccess('Worksheet uploaded successfully.');
    }

    public function edit($id)
    {
        $worksheet = Worksheet::findOrFail($id);

        return view('datasource::management.worksheets.edit', compact('worksheet'));
    }

    public function update(Request $request, $id)
    {
        $worksheet = Worksheet::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'nullable|'.self::FILE_RULES,
            'is_active'   => 'nullable|boolean',
        ]);

        $worksheet->title = $data['title'];
        $worksheet->description = $data['description'] ?? null;
        $worksheet->is_active = (bool) ($data['is_active'] ?? false);
        $this->attachFile($request, $worksheet); // only replaces when a new file is sent
        $worksheet->save();

        return redirect()->route('admin.worksheets.index')->withSuccess('Worksheet updated successfully.');
    }

    public function destroy($id)
    {
        $worksheet = Worksheet::findOrFail($id);
        $worksheet->delete();

        return redirect()->route('admin.worksheets.index')->withSuccess('Worksheet deleted.');
    }

    /**
     * Store the uploaded file on the public disk and record its metadata.
     */
    private function attachFile(Request $request, Worksheet $worksheet): void
    {
        if (!$request->hasFile('file')) {
            return;
        }

        $upload = $request->file('file');
        $path = $upload->store('public/worksheets');

        $worksheet->file = Storage::url($path);
        $worksheet->original_name = $upload->getClientOriginalName();
    }
}
