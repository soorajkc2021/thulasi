<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class CategoryResourseController extends BaseController
{
    public function __construct()
    {
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories   = Category::where('parent_id',0)->orderBy('id',"desc")->get();
        return view('admin.category.index',compact('categories'));
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
            'name' => [
                'required',
                Rule::unique('categories')->where('parent_id', '0'),
            ],
        ]);
        $attributes = $request->all();

        $brand = Category::create($attributes);
        if(@$brand->id){
            return response()->json(['url' =>  url('/admin/categories'),'message'=>'success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category       = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('categories')->where('parent_id', '0')->ignore($id),
            ],
        ]);
      
        $category       = Category::find($id);
        $attributes = $request->all();
        $category->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $product        = Product::where('category_id',$id)->count();
        $parent         = Category::where('parent_id',$id)->count();

        if($product > 0 || $parent > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete category"]);
        }else{
            $category       = Category::find($id);
            $category->delete() ;
            return response()->json(['status' =>  "success",'message'=>'category deleted successfully']);
        }
       
        
    }
}
