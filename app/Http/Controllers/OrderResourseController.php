<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
Use DB;
class OrderResourseController extends BaseController
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
        if($this->guardName() == "admin"){
            $orders   = Order::orderBy('id',"desc")->get();
            return view('admin.order.index',compact('orders'));
        }else{
            $user_id  = \Auth::guard('web')->user()->id;
            $orders   = Order::where('user_id',$user_id)->orderBy('id',"desc")->get();
            return view('order.index',compact('orders'));
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

        DB::beginTransaction();

        try {
          
        $attr = $request->all();
        $rules      = [
           
            'order'                 =>  'required',
            'order.product.*'       =>  'required',
            'order.quantity.*'      =>  'required|gte:1', 
        ];
       
      
        $request->validate($rules);

        $attrribute['user_id'] =  \Auth::guard('web')->user()->id;
        $attrribute['shop_id'] =  @$attr['shop_id'];

        $order      = Order::create($attrribute);
        $number     = 1000;


        $products   = @$attr['order']['product'];
        $quantity   = @$attr['order']['quantity'];
        $quantity   = @$attr['order']['quantity'];

        
      
        foreach(@$attr['order']['inventory']  as $inventory_id){
          
            $data['order_id']           =  $order->id;
            $data['inventory_id']       =  $inventory_id;
            $data['quantity']           =  @$quantity[$inventory_id];
            $inventory    = Inventory::find($inventory_id);
            $stock        = $inventory->stock - $data['quantity'];
            $inventory->update(['stock' => $stock]);

            $data['product_id']         =  @$products[$inventory_id];
           
            $data['unit_price']         =  @$inventory->cost_price;
            $data['unit_cost_price']    =  @$inventory->sell_price * $data['quantity'];
            $data['total_price']        =  @$inventory->sell_price;
            $data['total_cost_price']   =  @$inventory->sell_price * $data['quantity'];
           
            $order_product              =  OrderProduct::create($data);
        }
        $code                           = $number + $order->id;
        $update['code']                 = "ORD-". $code;
       // dd($order->products->sum('total_price'));
        $update['total_cost_price']     = $order->products->sum('total_cost_price');
        $update['total_sell_price']     = $order->products->sum('total_price');
       
        $order->update($update);

        DB::commit();
        return response()->json(['status'=>'success','message'=>'Order created successfully']);
     
      
        // all good
    } catch (\Exception $e) {
       
        DB::rollback();
        return response()->json(['status'=>'failed','message'=>'Order failed']);

    }
   
    }


    public function orderSummary(Request $request)
    {
        $attributes = $request->all();
        if(@$attributes['order']['sell_price']){
            $summary['sell_price']       = array_sum(@$attributes['order']['sell_price']);
            $summary['total_price']      = array_sum(@$attributes['order']['total_price']);
            $summary['total_quantity']   = array_sum(@$attributes['order']['quantity']);
            return view('shop.table_footer',compact('summary'));
        }else{
            return '';
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $attributes = $request->all();
        $rules      = [
           
            'product'        =>  'required',
            'inventory'      =>  'required',
            'quantity'       =>  'required|gte:1',
            'cost_price'       => 'required',
            'sell_price'     =>  'required',
        ];
        $message = $inventory = [];
        if(@$attributes['sell_price'] && @$attributes['cost_price']){
            $rules['sell_price']  = "required|gte:".$attributes['cost_price'];
        }
        if(@$attributes['inventory'] && @$attributes['quantity']){
            $inventory    = Inventory::find(@$attributes['inventory']);
            if($inventory->stock < @$attributes['quantity']){
                $rules['quantity']  = "required|lt:$inventory->stock";
                $message['quantity.lt']  = "Only $inventory->stock stock is available";
            }
        }
      
        $request->validate($rules,$message);
        $productLists   = @$attributes['order']['inventory'] ?  $attributes['order']['inventory'] : [];
        $array_search   = array_search(@$attributes['inventory'],$productLists);
        
        if(is_int($array_search )){
            return response()->json(['status'=>'failed','message'=>'Product entry already exist']);
        }
        
        $product    = Product::find(@$attributes['product']);
        $html       = view('shop.table_body',compact('attributes','product','inventory'))->render();
    
        return response()->json(['status'=>'success','html'=>$html]);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order       = Order::find($id);
        if($this->guardName() == "admin"){
            return view('admin.order.show',compact('order'));
        }else{
            return view('order.show',compact('order'));
        }
    }
    public function cancel_order($id)
    {
        $order       = Order::find($id);

        foreach($order->products  as $product){
            $inventory    = Inventory::find($product->inventory_id);
            $stock        = $inventory->stock + $product->quantity;
            $inventory->update(['stock' => $stock]);
        }
        $order->update(['status' => "Cancelled"]);
        if($this->guardName() == "admin"){
            return redirect('/admin/orders');
        }else{
            return redirect('/orders');
        }
      

    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory       = Inventory::find($id);
        return view('admin.inventory.edit',compact('inventory'));
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
            'product'       => ['required'],
            'unit'          => ['required'],
            'unit_quantity' => ['required'],
            'cost_price'    => 'required|numeric',
            'sell_price'    => 'required|numeric',
            'stock'         => 'required|integer',
        ]);
      
        $inventory                  = Inventory::find($id);
        $attributes                 = $request->all();
        $attributes['product_id']   = $attributes['product'];
        $attributes['unit_id']      = $attributes['unit'];
        $inventory->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory       = Inventory::find($id);
        $inventory->delete();
        return redirect('admin/inventories');
        
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
