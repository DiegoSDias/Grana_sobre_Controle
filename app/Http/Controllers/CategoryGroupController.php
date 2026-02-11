<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = Group::with('categories')
                        ->where('user_id', $request->user()->id)->get();

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $incomeCategories = Category::where('user_id', $request->user()->id)
            ->where('type', 'income')
            ->where('group_id', null)
            ->get();

        $expenseCategories = Category::where('user_id', $request->user()->id)
            ->where('type', 'expense')
            ->where('group_id', null)
            ->get();

        return view('groups.create', compact('incomeCategories', 'expenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $name = $request->name;
        $income = $request->input('income_categories', []);
        $expense = $request->input('expense_categories', []);

        $categories_id = array_merge($income, $expense);
        
        $group = Group::create([
            'user_id' => $user_id,
            'name' => $name
        ]);

        foreach($categories_id as $category_id) {
            $category = Category::find($category_id);

            $category->update([
                'group_id' => $group->id
            ]);
        }

        return redirect()->route('category-groups.index');
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
        $group = Group::with('categories')->findOrFail($id);


        $incomeCategories = Category::where('user_id', $request->user()->id)
            ->where('type', 'income')
            ->where(function ($query) use ($group) {
                $query->whereNull('group_id')
                    ->orWhere('group_id', $group->id);
            })
            ->get();

        $expenseCategories = Category::where('user_id', $request->user()->id)
            ->where('type', 'expense')
            ->where(function ($query) use ($group) {
                $query->whereNull('group_id')
                    ->orWhere('group_id', $group->id);
            })
            ->get();

        return view('groups.edit', compact(
            'group',
            'incomeCategories',
            'expenseCategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::find($id);

        $name = $request->name;
        $income = $request->input('income_categories', []);
        $expense = $request->input('expense_categories', []);

        $categories_id = array_merge($income, $expense);

        $group->update([
            'name' => $name
        ]);

        foreach($categories_id as $category_id) {
            $category = Category::find($category_id);

            $category->update([
                'group_id' => $group->id
            ]);
        }

        return redirect()->route('category-groups.index');
        
        }
        
        /**
         * Remove the specified resource from storage.
        */
        public function destroy(string $id)
        {
            $group = Group::find($id);
            
            $group->delete();

        return redirect()->route('category-groups.index');
    }
}
