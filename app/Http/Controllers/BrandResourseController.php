<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BrandResourseController extends BaseController
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
        $brands   = Brand::orderBy('id',"desc")->get();
        return view('admin.brand.index',compact('brands'));
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
            'name'     => 'required|unique:brands,name',
        ]);
        $attributes = $request->all();

        $brand = Brand::create($attributes);
        if(@$brand->id){
            return response()->json(['url' =>  url('/admin/brands'),'message'=>'success']);
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
        return view('admin.brand.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand       = Brand::find($id);
        return view('admin.brand.edit',compact('brand'));
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
            'name' => 'required|unique:brands,name,' . $id
        ]);
        $brand       = Brand::find($id);
        $attributes = $request->all();
        $brand->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
       
        
        if(Product::where('brand_id',$id)->count() > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete brand"]);
        }else{
            $brand       = Brand::find($id);
            $brand->delete() ;
            return response()->json(['status' =>  "success",'message'=>'Brand deleted successfully']);
        }
        

       // return redirect('admin/brands');
        
    }

    public function brand_dropdown(Request $request)
    {
       
        $searchTerm = $request->get('search'); // Query parameter sent by Select2
        $brands     = Brand::where('name', 'like', "%$searchTerm%")
                        ->limit(10)
                        ->get(['id', 'name']);

            $page               = $request->page;
            $resultCount        = 10;
            $offset             = ($page - 1) * $resultCount;
            $result['result']   = [];
            $data               = [];
            foreach($brands as $key=>$val){
                $data[$key]['text']=$val->name;
                $data[$key]['id'] = $val->id;
            }
            $data = array_slice($data, $offset, $resultCount);
            foreach($data as $key=>$value){
                array_push($result['result'],$value);
            }
            $result['count_filtered'] = $brands->count();
            $result['page'] = $request->page;   
        return $result;
    }
}
