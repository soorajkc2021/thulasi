<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class ProductResourseController extends BaseController
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
        $products   = Product::orderBy('id',"desc")->get();
        return view('admin.product.index',compact('products'));
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
                'name'          => ['required', Rule::unique('products')],
                'brand'         =>  'required',
                'category'      =>  'required',
                'subcategory'   =>  'required',
                'status'        =>  'required',
                
            ]);
         
        $attributes = $request->all();
        $attributes['brand_id']         = $attributes['brand'];
        $attributes['category_id']      = $attributes['category'];
        $attributes['subcategory_id']   = $attributes['subcategory'];
        $product    = Product::create($attributes);
        if(@$product->id){
            return response()->json(['url' =>  url('/admin/products'),'message'=>'success']);
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
        return view('admin.product.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product       = Product::find($id);
        return view('admin.product.edit',compact('product'));
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
            'name'          => ['required', Rule::unique('products')->ignore($id)],
            'brand'         =>  'required',
            'category'      =>  'required',
            'subcategory'   =>  'required',
            'status'        =>  'required',
        ]);
        $product        = Product::find($id);
        $attributes     = $request->all();
        $attributes['category_id']      = $attributes['category'];
        $attributes['brand_id']         = $attributes['brand'];
        $attributes['subcategory_id']   = $attributes['subcategory'];

        $product->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order        = OrderProduct::where('inventory_id',$id)->count();

        if($order > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete product"]);
        }else{
            $product       = Product::find($id);
            $product->delete();
            return response()->json(['status' =>  "success",'message'=>'product deleted successfully']);
        }
        
        
    }

    public function product_dropdown(Request $request)
    {
       
        $searchTerm = $request->get('search'); // Query parameter sent by Select2
        $brands     = Product::where('name', 'like', "%$searchTerm%")
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
