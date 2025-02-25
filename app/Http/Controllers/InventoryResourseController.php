<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class InventoryResourseController extends BaseController
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
        $inventories   = Inventory::orderBy('id',"desc")->get();
        return view('admin.inventory.index',compact('inventories'));
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
            'product'       => ['required'],
            'unit'          => ['required'],
            'unit_quantity' => ['required'],
            'cost_price'    => 'required|numeric',
            'sell_price'    => 'required|numeric',
            'stock'         => 'required|integer',
        ]);
        $attributes = $request->all();
        $attributes['product_id']   = $attributes['product'];
        $attributes['unit_id']      = $attributes['unit'];
        $inventory = Inventory::create($attributes);
        if(@$inventory->id){
            return response()->json(['url' =>  url('/admin/inventories'),'message'=>'success']);
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
        return view('admin.inventory.create');
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

        $order        = OrderProduct::where('inventory_id',$id)->count();

        if($order > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete invetory"]);
        }else{
            $inventory       = Inventory::find($id);
            $inventory->delete();
            return response()->json(['status' =>  "success",'message'=>'invetory deleted successfully']);
        }
       
       
        
    }

    public function inventory_dropdown(Request $request)
    {
       
        $searchTerm         = $request->get('search'); 
        $product            = $request->get('product'); 
        $inventories        = Inventory::leftJoin('units','units.id','=','inventories.unit_id')
                            ->where('inventories.product_id',  $product)
                            ->where('units.name', 'like', "%$searchTerm%")
                            ->limit(10)
                            ->get([\DB::raw("CONCAT(units.name,' - ',inventories.unit_quantity)  AS name"), 'inventories.id']);
       
            $page               = $request->page;
            $resultCount        = 10;
            $offset             = ($page - 1) * $resultCount;
            $result['result']   = [];
            $data               = [];
            foreach($inventories as $key=>$val){
                $data[$key]['text']=$val->name;
                $data[$key]['id'] = $val->id;
            }
            $data = array_slice($data, $offset, $resultCount);
            foreach($data as $key=>$value){
                array_push($result['result'],$value);
            }
            $result['count_filtered'] = $inventories->count();
            $result['page'] = $request->page;   
        return $result;
    }
    public function inventory_dropdown_change(Request $request)
    {
        $attributes         = $request->all();
        $inventory          = Inventory::find(@$attributes['inventory']);
        if(@$inventory->id){;
            $inventory_data['cost_price']   = $inventory->cost_price;
            $inventory_data['sell_price']   = $inventory->sell_price;
            return response()->json(['inventory' =>  $inventory_data]);
        }
    }
}
