<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class UserResourseController extends BaseController
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
        
        $users   = User::orderBy('id','desc')->orderBy('id',"desc")->get();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
      
        $user = Auth::user();
        return view('admin.user.profile',compact('user'));
    }


    public function create()
    {
       
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        $request->validate([
                'name'      => 'required',
                'email'     => 'required|unique:users,email',
                'password'  => 'required|confirmed',
        ]);
        $attributes = $request->except(['password','password_confirmation','token']);
        $attributes['password'] = Hash::make($request->password);
        $user = User::create($attributes);

        if(@$user->id){
            return response()->json(['url' =>  url('/admin/users'),'message'=>'success']);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user       = User::find($id);
        return view('admin.user.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id=null)
    {
      
        $rules      = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ];
        if(@$request->update_password == 1){
            $rules['password'] = 'required|confirmed';
        }
        $request->validate($rules);
        $attributes = $request->except(['update_password','password','password_confirmation','token']);


        $user       = Auth::user();
        $user->update($attributes);
    }
    public function update(Request $request, $id)
    {
        $attributes = $request->except(['update_password','password','password_confirmation','token']);
        $rules      = [
                        'name' => 'required',
                        'email' => 'required|email|unique:users,email,' . $id
                    ];
        if(@$request->update_password == 1){
            $rules['password'] = 'required|confirmed';
        }

        $request->validate($rules);
        if(@$request->update_password == 1){
            $attributes['password'] = Hash::make($request->password);
        }

        $user       = User::find($id);
        
        $user->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $order        = Order::where('user_id',$id)->count();

        if($order > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete user"]);
        }else{
            $user       = User::find($id);
            $user->delete();
            return response()->json(['status' =>  "success",'message'=>'user deleted successfully']);
        }

    }

    public function adminDashboard(Request $request)
    {
      
        $data['order_count']        = Order::count();
        $data['shop_count']         = Shop::count();
        $data['product_count']      = Product::count();
        $data['inventory_count']    = Inventory::count();
        

    
        $month_orders = [];

        for ($i = 1; $i <= 12; $i++) {
            $month_orders[]   = 0;
        }

        $currentYear    = Carbon::now()->year;
        $ordersByMonth  = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as order_count')
            ->whereYear('created_at', $currentYear)  // Filter by current year
            ->groupBy('month')
            ->orderBy('month', 'asc')  // To order by month (1 = January, 12 = December)
            ->get();
            if($ordersByMonth){
                foreach ($ordersByMonth as $order) {
                    $month_orders[$order->month -1]    =  $order->order_count;
                }
            }
            $items  = OrderProduct::selectRaw("sum(order_products.quantity) as qty, products.name")
           
                                            ->leftJoin('products','products.id','=','order_products.product_id')
                                            ->groupBy('product_id')
                                            ->pluck('qty','name')->toArray();
                                         
           $backgroundColors = array_map(function($item) {
               // Generate a color from the hash of the item name
               $hash = md5($item); // md5 hash of the item name
               return '#' . substr($hash, 0, 6); // Take the first 6 characters of the hash as the color code
           }, array_keys($items));
                                        
             $products = [
                   'datasets' =>[
                        [
                        'data' => array_values($items),  // The data values for each slice
                        'backgroundColor' => array_values($backgroundColors),
                       ]
                   ],
                   'labels' => array_keys($items), 
            ]; 
               
      
        return view('admin.dashboard',compact('data','month_orders','products'));
    }

    public function userDashboard(Request $request)
    {
        $user_id                    = \Auth::user()->id;
         
        $data['order_count']        = Order::where('user_id',$user_id)->count();
     
        $data['shop_count']         = Order::where('user_id',$user_id)
                                    ->distinct('shop_id')->count('shop_id');
                         

       
        $data['total_sell_price']    =Order::where('user_id',$user_id)->sum('total_sell_price');
      


        $items  = OrderProduct::selectRaw("sum(order_products.quantity) as qty, products.name")
        ->leftJoin('orders','orders.id','=','order_products.order_id')
        ->leftJoin('products','products.id','=','order_products.product_id')
        ->where('orders.user_id',$user_id)
        ->groupBy('product_id')
        ->pluck('qty','name');
        
        $data['product_count']      = $items->count(); 
       

        $month_orders = [];

        for ($i = 1; $i <= 12; $i++) {
            $month_orders[]   = 0;
        }

        $currentYear    = Carbon::now()->year;
        $ordersByMonth  = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as order_count')
                        ->where('user_id',$user_id)
                        ->whereYear('created_at', $currentYear)  // Filter by current year
                        ->groupBy('month')
                        ->orderBy('month', 'asc')  // To order by month (1 = January, 12 = December)
                        ->get();
            if($ordersByMonth){
                foreach ($ordersByMonth as $order) {
                    $month_orders[$order->month -1]    =  $order->order_count;
                }
            }

            $items  = $items->toArray();
         
                $backgroundColors = array_map(function($item) {
                // Generate a color from the hash of the item name
                $hash = md5($item); // md5 hash of the item name
                return '#' . substr($hash, 0, 6); // Take the first 6 characters of the hash as the color code
                }, array_keys($items));
                        
                $products = [
                            'datasets' =>[
                                [
                                'data' => array_values($items),  // The data values for each slice
                                'backgroundColor' => array_values($backgroundColors),
                                ]
                            ],
                '           labels' => array_keys($items), 
                        ]; 
        return view('dashboard',compact('data','month_orders','products'));
        
    }
}
