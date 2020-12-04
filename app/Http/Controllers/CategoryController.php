<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            $category = new Category([
                'name' => $request->get('name')
            ]);
            $category->save();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/categories/create')->withErrors(
                    ['custom' => 'Category with such name already exists!']
                );
            }
        }

        return redirect('admin/categories')->with(
            'success', 'New category has been succesfully added!'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $category = Category::find($id);
            if (!($request->get('name') == $category->name)) {
                $category->name = $request->get('name');
                $category->save();
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect('admin/categories/{category}/edit')->withErrors(
                    ['custom' => 'Category with such number already exists!']
                );
            }
        }

        return redirect('admin/categories')->with(
            'success', 'The category has been succesfully edited!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->rooms()->delete();
        $category->delete();

        return redirect('admin/categories')->with(
            'success', 'The category has been succesfully deleted!'
        );
    }
}
