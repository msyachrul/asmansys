<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
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
        $data = Region::all();
        return view('admin.region.index',compact('data'));
    }

    public function userIndex()
    {
        $data = Region::all();
        return view('region.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.region.create');
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
            'name' => 'required|unique:regions,name',
        ]);

        $data = new Region;
            $data->name = $request->name;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('region.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        $value = Region::join('users','regions.last_updated_by','users.id')->select('regions.id','regions.name','users.name as user')->where('regions.id',$region->id)->first();

        return view('admin.region.show',compact('value'));
    }

    public function userShow(Region $region)
    {
        $value = Region::join('users','regions.last_updated_by','users.id')->select('regions.id','regions.name','users.name as user')->where('regions.id',$region->id)->first();

        return view('region.show',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $this->validate($request, [
            'name' => 'required|unique:regions,name',
        ]);

        $data = Region::find($region->id);
            $data->name = $request->name;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('region.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        Region::destroy($region->id);
        return redirect()->route('region.index');
    }
}
