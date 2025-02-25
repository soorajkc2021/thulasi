<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class SubCategoryResourseController extends BaseController
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
        $categories   = Category::where('parent_id','!=',0)->orderBy('id',"desc")->get();
        return view('admin.subcategory.index',compact('categories'));
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
                'name'      => ['required', Rule::unique('categories')->where('parent_id','!=', '0')],
                'category'  =>  'required',
            ]);
        $attributes = $request->all();
        $attributes['parent_id'] = $attributes['category'];
        $category = Category::create($attributes);
        if(@$category->id){
            return response()->json(['url' =>  url('/admin/subcategories'),'message'=>'success']);
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
        return view('admin.subcategory.create');
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
        return view('admin.subcategory.edit',compact('category'));
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
            'name' => ['required', Rule::unique('categories')->where('parent_id','!=', '0')->ignore($id)],
            'category'  =>  'required',
        ]);
        $category       = Category::find($id);
        $attributes = $request->all();
        $attributes['parent_id'] = $attributes['category'];

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
        
        $product        = Product::where('subcategory_id',$id)->count();

        if($product > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete Category"]);
        }else{
            $category       = Category::find($id);
            $category->delete();
            return response()->json(['status' =>  "success",'message'=>'Category deleted successfully']);
        }
        
    }
    public function category_dropdown(Request $request)
    {
       
        $searchTerm = $request->get('search'); // Query parameter sent by Select2
        $categories = Category::where('name', 'like', "%$searchTerm%")
                        ->where('parent_id', '0')
                        ->limit(10)
                        ->get(['id', 'name']);

            $page               = $request->page;
            $resultCount        = 10;
            $offset             = ($page - 1) * $resultCount;
            $result['result']   = [];
            $data               = [];
            foreach($categories as $key=>$val){
                $data[$key]['text']=$val->name;
                $data[$key]['id'] = $val->id;
            }
            $data = array_slice($data, $offset, $resultCount);
            foreach($data as $key=>$value){
                array_push($result['result'],$value);
            }
            $result['count_filtered'] = $categories->count();
            $result['page'] = $request->page;          
        
        
        return $result;
    
       
    }
    public function subcategory_dropdown(Request $request)
    {
       
        $searchTerm = $request->get('search'); // Query parameter sent by Select2
        $categories = Category::where('name', 'like', "%$searchTerm%")
                        ->where('parent_id','!=', '0')
                        ->limit(10)
                        ->get(['id', 'name']);

            $page               = $request->page;
            $resultCount        = 10;
            $offset             = ($page - 1) * $resultCount;
            $result['result']   = [];
            $data               = [];
            foreach($categories as $key=>$val){
                $data[$key]['text']=$val->name;
                $data[$key]['id'] = $val->id;
            }
            $data = array_slice($data, $offset, $resultCount);
            foreach($data as $key=>$value){
                array_push($result['result'],$value);
            }
            $result['count_filtered'] = $categories->count();
            $result['page'] = $request->page;          
        
        
        return $result;
    
       
       
    }
    
}
