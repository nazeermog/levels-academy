<?php

namespace DataSource\Http\Controllers\Admin\Link;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Link\Link;

/**
 * Admin management of saved links (a titled URL) that can be attached to any
 * course step. Links can also be created inline in the course builder.
 */
class AdminLinkController extends BaseController
{
    public function index()
    {
        $links = Link::orderByDesc('id')->paginate(20);

        return view('datasource::management.links.index', compact('links'));
    }

    public function create()
    {
        return view('datasource::management.links.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url|max:2048',
        ]);

        Link::create($data);

        return redirect()->route('admin.links.index')->withSuccess('Link created successfully.');
    }

    public function edit($id)
    {
        $link = Link::findOrFail($id);

        return view('datasource::management.links.edit', compact('link'));
    }

    public function update(Request $request, $id)
    {
        $link = Link::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url|max:2048',
        ]);

        $link->update($data);

        return redirect()->route('admin.links.index')->withSuccess('Link updated successfully.');
    }

    public function destroy($id)
    {
        Link::findOrFail($id)->delete();

        return redirect()->route('admin.links.index')->withSuccess('Link deleted.');
    }
}
