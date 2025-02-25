<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class UnitResourseController extends BaseController
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
        $units   = Unit::orderBy('id',"desc")->get();
        return view('admin.unit.index',compact('units'));
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
                Rule::unique('units'),
            ],
        ]);
        $attributes = $request->all();

        $unit = Unit::create($attributes);
        if(@$unit->id){
            return response()->json(['url' =>  url('/admin/units'),'message'=>'success']);
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
        return view('admin.unit.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit       = Unit::find($id);
        return view('admin.unit.edit',compact('unit'));
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
                Rule::unique('units')->ignore($id),
            ],
        ]);
      
        $unit   = Unit::find($id);
        $attributes = $request->all();
        $unit->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory        = Inventory::where('unit_id',$id)->count();
      
        if($inventory > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete Unit"]);
        }else{
            $unit       = Unit::find($id);
            $unit->delete();
            return response()->json(['status' =>  "success",'message'=>'Unit deleted successfully']);
        }
        
    }

    public function unit_dropdown(Request $request)
    {
       
        $searchTerm = $request->get('search'); // Query parameter sent by Select2
        $brands     = Unit::where('name', 'like', "%$searchTerm%")
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
