<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowroomModel;
use Illuminate\Http\Request;

class ShowroomController extends Controller
{
    public function index()
    {
        $models = ShowroomModel::orderBy('sort_order')->paginate(20);
        return view('admin.showroom.index', compact('models'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'room_type'   => 'nullable|string|max:100',
            'model_file'  => 'required|file|mimes:glb,gltf|max:51200',
            'thumbnail'   => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $data['model_path'] = $request->file('model_file')->store('showroom/models', 'public');
        $data['is_active']  = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('showroom/thumbnails', 'public');
        }

        unset($data['model_file']);
        ShowroomModel::create($data);

        return back()->with('success', '3D Model uploaded successfully!');
    }

    public function update(Request $request, ShowroomModel $showroomModel)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'room_type'   => 'nullable|string|max:100',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('showroom/thumbnails', 'public');
        }

        $showroomModel->update($data);
        return back()->with('success', 'Showroom model updated!');
    }

    public function destroy(ShowroomModel $showroomModel)
    {
        $showroomModel->delete();
        return back()->with('success', 'Model deleted.');
    }
}
