<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return view('admin.category.index',compact('data'));
    }

    public function userIndex()
    {
        $data = Category::select(['categories.id as id', 'categories.name as name', DB::raw('COUNT(*) as total')])->join('assets', 'categories.id', 'assets.category_id')->groupBy('categories.id')->orderBy('categories.name', 'ASC')->get();

        return view('category.index',compact('data'));
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
        ]);

        $data = new Category;
            $data->name = $request->name;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // $value = Category::findOrFail($category->id);
        $value = Category::join('users','categories.last_updated_by','users.id')->select('categories.id','categories.name','users.name as user')->where('categories.id',$category->id)->first();

        return view('admin.category.show',compact('value'));
    }

    public function userShow(Category $category)
    {
        // $value = Category::findOrFail($category->id);
        $value = Category::join('users','categories.last_updated_by','users.id')->select('categories.id','categories.name','users.name as user')->where('categories.id',$category->id)->first();

        return view('category.show',compact('value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
        ]);

        $data = Category::find($category->id);
            $data->name = $request->name;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        return redirect()->route('category.index');
    }
}
