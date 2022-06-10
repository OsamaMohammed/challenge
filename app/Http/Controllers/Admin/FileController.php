<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validated = $this->validate($request, [
            'search' => 'nullable|string|max:200',
            'order' => 'nullable|in:asc,desc',
            'sort' => 'nullable|in:id,created_at',
        ]);
        $res = File::select('*');
        // Search
        $res = $request->has('search') ? $res->search($validated['search']) : $res;
        // Order
        $res = ($request->has('order') && $request->has('sort')) ? $res->orderBy($validated['sort'], $validated['order']) : $res;
        // Paginate
        $res = $res->paginate();
        return [
            'data' => $res->getCollection(),
            'total' => $res->total(),
            'current_page' => $res->currentPage(),
            'per_page' => $res->perPage(),
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        $validated = $request->validated();
        // try {
        $file = new File($validated);
        $file->save();
        // } catch (\Exception $e) {
        //     return response("Error while uploading file", 500);
        // }
        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return File::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FileUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $file = File::findOrFail($id);
        $file->fill($validated);
        $file->save();
        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete();
        return response('', 200);
    }
}
