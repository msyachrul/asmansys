<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
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
        $data = Asset::join('categories','assets.category_id','categories.id')->select('assets.id','assets.name','categories.name as category')->get();
        
        return view('admin.asset.index',compact('data'));
    }

    public function userIndex()
    {
        $data = Asset::join('categories','assets.category_id','categories.id')->select('assets.id','assets.name','categories.name as category')->get();
        
        return view('asset.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = \App\Category::all();
        $region = \App\Region::all();
        return view('admin.asset.create',compact('category','region'));
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
            'name' => 'required|unique:assets,name',
            'address' => 'required',
            'description'  => 'required',
            'category_id' => 'required',
            'region_id' => 'required',
            'picture[]' => 'nullable|max:5000',
        ]);

        // upload gambar dan mengembalikan string lokasi gambar
        // $pictPath = $request->file('picture')->store('public/images');

        $data = new Asset;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->region_id = $request->region_id;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        foreach ($request->file('picture') as $key => $value) {

            $pict = new \App\Picture;
                $pict->path = $value->store('public/images');
                $pict->asset_id = $data->id;
            $pict->save();
        }

        return redirect()->route('asset.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $value = Asset::join('categories','assets.category_id','categories.id')
        ->join('regions','assets.region_id','regions.id')
        ->join('users','assets.last_updated_by','users.id')
        ->where('assets.id',$asset->id)
            ->select(
                'assets.id',
                'assets.name',
                'assets.address',
                'assets.description',
                'assets.category_id',
                'assets.region_id',
                'users.name as user'
            )->first();

        $picts = \App\Picture::where('asset_id',$value->id)->get();

        $category = \App\Category::all();
        $region = \App\Region::all();

        return view('admin.asset.show',compact('value','category','region','picts'));
    }

    public function userShow(Asset $asset)
    {
        $value = Asset::join('categories','assets.category_id','categories.id')
        ->join('regions','assets.region_id','regions.id')
        ->join('users','assets.last_updated_by','users.id')
        ->where('assets.id',$asset->id)
            ->select(
                'assets.id',
                'assets.name',
                'assets.address',
                'assets.description',
                'assets.category_id',
                'assets.region_id',
                'users.name as user'
            )->first();

        $picts = \App\Picture::where('asset_id',$value->id)->get();

        $integration = \App\Value::join('certificates','values.certificate_id','certificates.id')->where('values.asset_id',$asset->id)->select('certificates.name','values.price','values.attachment')->get();

        $category = \App\Category::all();
        $region = \App\Region::all();

        return view('asset.show',compact('value','category','region','picts','integration'));
    }

    public function integration(Asset $asset)
    {
        $value = Asset::join('users','assets.last_updated_by','users.id')->where('assets.id',$asset->id)->select('assets.id','assets.name','users.name as user')->first();
        $integration = \App\Value::join('certificates','values.certificate_id','certificates.id')->where('values.asset_id',$asset->id)->select('certificates.name','values.price','values.attachment')->get();
        $certificates = \App\Certificate::all();

        return view('admin.asset.document',compact('value','integration','certificates'));
    }

    public function integrationStore(Request $request, Asset $asset)
    {

        $this->validate($request, [
            'price' => 'required',
            'certificate_id' => 'required',
            'attachment' => 'nullable',
        ]);
        for ($i=0; $i < count($request->certificate_id) ; $i++) { 
            $data = new \App\Value;
                $data->asset_id = $asset->id;
                $data->certificate_id = $request->certificate_id[$i];
                $data->price = $request->price[$i];
                $data->attachment = $request->file('attachment')[$i]->store('public/images');
                $data->last_updated_by = \Auth::user()->id;
            $data->save();
        }

        return redirect()->route('asset.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {

        $this->validate($request, [
            'address' => 'required',
            'description'  => 'required',
            'category_id' => 'required',
            'region_id' => 'required',
            'picture' => 'nullable|max:5000',
        ]);


        // cek file
        if (!empty($request->file('picture'))) {
            // hapus gambar-gambar sebelumnya
            $path = \App\Picture::where('asset_id',$asset->id)->get();
            
            foreach ($path as $key => $value) {
                \Storage::delete($value->path);
            }
            // hapus gambar pada tabel
            \App\Picture::where('asset_id',$asset->id)->delete();
            
            // upload gambar dan mengembalikan string lokasi gambar
            // $pictPath = $request->file('picture')->store('public/images');
            foreach ($request->file('picture') as $key => $value) {

                $pict = new \App\Picture;
                    $pict->path = $value->store('public/images');
                    $pict->asset_id = $asset->id;
                $pict->save();
            }
        }

        $data = Asset::find($asset->id);
            $data->name = $request->name;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->region_id = $request->region_id;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('asset.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        // hapus gambar
        $path = \App\Picture::where('asset_id',$asset->id)->get();
            foreach ($path as $key => $value) {
                \Storage::delete($value->path);
            }
        // hapus path gambar di tabel
        \App\Picture::where('asset_id',$asset->id)->delete();
        // hapus data
        Asset::destroy($asset->id);

        return redirect()->route('asset.index');
    }
}
