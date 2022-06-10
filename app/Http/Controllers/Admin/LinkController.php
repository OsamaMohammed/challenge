<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
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
        $res = Link::select('*');
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
     * @param  \App\Http\Requests\LinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        $validated = $request->validated();
        // try {
        $link = new Link($validated);
        $link->save();
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
        return Link::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LinkRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LinkRequest $request, $id)
    {
        $validated = $request->validated();
        $link = Link::findOrFail($id);
        $link->fill($validated);
        $link->save();
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
        $link = Link::findOrFail($id);
        $link->delete();
        return response('', 200);
    }
}
