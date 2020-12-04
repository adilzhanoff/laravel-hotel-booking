<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $views = View::all();
        return view('admin.views.index', compact('views'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.views.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $view = new View([
                'name' => $request->get('name')
            ]);
            $view->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/views/create')->withErrors(
                    ['custom' => 'View with such name already exists!']
                );
            }
        }

        return redirect('admin/views')->with(
            'success', 'New view has been succesfully added!'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = View::find($id);
        return view('admin.views.show', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $view = View::find($id);
        return view('admin.views.edit', compact('view'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $view = View::find($id);
            if (!($request->get('name') == $view->name)) {
                $view->name = $request->get('name');
                $view->save();
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/views/{view}/edit')->withErrors(
                    ['custom' => 'View with such number already exists!']
                );
            }
        }

        return redirect('admin/views')->with(
            'success', 'The view has been succesfully edited!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $view = View::find($id);
        $view->rooms()->delete();
        $view->delete();

        return redirect('admin/views')->with(
            'success', 'The view has been succesfully deleted!'
        );
    }
}
