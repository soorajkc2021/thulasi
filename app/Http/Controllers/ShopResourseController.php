<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\OrderProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class ShopResourseController extends BaseController
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
        $shops   = Shop::orderBy('id',"desc")->get();
        if($this->guardName() == "admin"){
            return view('admin.shop.index',compact('shops'));
        }else{
            return view('shop.index',compact('shops'));
        }
        
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
            'name'          => [ 'required', Rule::unique('shops')],
            'address'       => 'required',
            'city'          => 'required',
            'contact_name'  => 'required',
            'contact_phone'  => 'required|numeric|digits:10',
        ],[
            'contact_phone.numeric'=>'please enate a valid mobile number.',
            'contact_phone.digits'=>'please enate a valid 10 digit number.',
        ]
    );
        $attributes = $request->all();

        $shop = Shop::create($attributes);
        if(@$shop->id){
            return response()->json(['url' =>  url('/admin/shops'),'message'=>'success']);
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop           = Shop::find($id);
        $mostproducts   = OrderProduct::selectRaw("sum(order_products.quantity) as qty, CONCAT(products.name,' ',inventories.unit_quantity,' ', units.name) as name")
                        ->leftJoin('orders','orders.id','=','order_products.order_id')
                        ->leftJoin('products','products.id','=','order_products.product_id')
                        ->leftJoin('inventories','inventories.id','=','order_products.inventory_id')
                        ->leftJoin('units','units.id','=','inventories.unit_id')
                        ->where('orders.shop_id',$shop->id)
                        ->groupby('order_products.product_id','order_products.inventory_id')
                        ->limit(10)->get();
        return view('shop.show',compact('shop','mostproducts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shop.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop       = Shop::find($id);
        return view('admin.shop.edit',compact('shop'));
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
            'name'          => ['required',Rule::unique('shops')->ignore($id)],
            'address'       => 'required',
            'city'          => 'required',
            'contact_name'  => 'required',
            'contact_phone'  => 'required|numeric|digits:10',

        ],[
            'contact_phone.numeric'=>'please enate a valid mobile number.',
            'contact_phone.digits'=>'please enate a valid 10 digit number.',
        ]);
      
        $shop       = Shop::find($id);
        $attributes = $request->all();
        $shop->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $order        = Order::where('shop_id',$id)->count();

        if($order > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete shop"]);
        }else{
            $shop       = Shop::find($id);
            $shop->delete();
            return response()->json(['status' =>  "success",'message'=>'shop deleted successfully']);
        }
        
    }

    public function guardName()
    {
        $guard = auth()->guard(); // Retrieve the guard
        $sessionName = $guard->getName(); 
        $parts = explode("_", $sessionName);
        unset($parts[count($parts)-1]);
        unset($parts[0]);
        return implode("_",$parts);
    }
}
