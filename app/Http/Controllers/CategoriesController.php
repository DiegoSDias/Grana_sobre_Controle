<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoriesIncome = Category::where('type', 'income')
                                ->where('user_id', $request->user()->id)
                                ->get();

        $categoriesExpense = Category::where('type', 'expense')
                                ->where('user_id', $request->user()->id)
                                ->get();

        return view('categories.index', compact('categoriesIncome', 'categoriesExpense'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $groups = Group::where('user_id', $request->user()->id)->get();
     
        return view('categories.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $name = $request->name;
        $type = $request->type;
        $group_id = $request->group_id;

        Category::create([
            'user_id' => $user_id,
            'name' => $name,
            'type' => $type,
            'group_id' => $group_id 
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $category = Category::find($id);
        $groups = Group::where('user_id', $request->user()->id)->get();
        
        return view('categories.edit', compact('category', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        $user_id = $request->user()->id;
        $name = $request->name;
        $type = $request->type;
        $group_id = $request->group_id;

        $category->update([
            'user_id' => $user_id,
            'name' => $name,
            'type' => $type,
            'group_id' => $group_id
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->route('categories.index');
    }
}
