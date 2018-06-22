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
        $data = Asset::join('categories','assets.category_id','categories.id')->select('assets.id','assets.name','categories.name as category','assets.status')->get();
        
        return view('admin.asset.index',compact('data'));
    }

    public function userIndex()
    {
        $data = Asset::join('categories','assets.category_id','categories.id')->select('assets.id','assets.name','categories.name as category', 'assets.status')->get();
        
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
            'picture.*' => 'nullable|max:5000',
            'status' => 'required',
        ]);

        // upload gambar dan mengembalikan string lokasi gambar
        // $pictPath = $request->file('picture')->store('public/images');

        $data = new Asset;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->region_id = $request->region_id;
            $data->status = $request->status;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        if ($request->file('picture')) {
            foreach ($request->file('picture') as $key => $value) {
                $pict = new \App\Picture;
                    $pict->path = $value->store('public/images');
                    $pict->asset_id = $data->id;
                $pict->save();
            }
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
                'assets.status',
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
                'assets.status',
                'users.name as user'
            )->first();

        $picts = \App\Picture::where('asset_id',$value->id)->get();

        $integration = \App\CertificateOnAsset::join('certificates','certificate_on_assets.certificate_id','certificates.id')->where('certificate_on_assets.asset_id',$asset->id)->select('certificates.name','certificate_on_assets.number','certificate_on_assets.id')->get();

        $category = \App\Category::where('id',$value->category_id)->first();
        $region = \App\Region::where('id',$value->region_id)->first();

        return view('asset.show',compact('value','category','region','picts','integration'));
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
            'status' => 'required',
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
            $data->status = $request->status;
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

        $coa = \App\CertificateOnAsset::where('asset_id',$asset->id)->first();
        
        $path = \App\CertificateOnAssetAttachment::where('coa_id',$coa->id)->get();
            foreach ($path as $key => $value) {
                \Storage::delete($value->link);
            }
        // hapus path gambar di tabel
        \App\Picture::where('asset_id',$asset->id)->delete();
        // hapus data
        Asset::destroy($asset->id);

        return redirect()->route('asset.index');
    }

    public function integrationShow(Asset $asset)
    {
        $value = Asset::join('users','assets.last_updated_by','users.id')->where('assets.id',$asset->id)->select('assets.id','assets.name','users.name as user')->first();
        $integration = \App\CertificateOnAsset::join('certificates','certificate_on_assets.certificate_id','certificates.id')->where('certificate_on_assets.asset_id',$asset->id)->select('certificate_on_assets.id','certificates.name','certificates.id as certificate_id','certificate_on_assets.number')->get();
        $integrationAttachment = \App\CertificateOnAssetAttachment::join('certificate_on_assets','coa_id','certificate_on_assets.id')->where('certificate_on_assets.asset_id',$asset->id)->select('certificate_on_assets_attachment.link')->get();
        
        $certificates = \App\Certificate::all();

        return view('admin.asset.document',compact('value','integration','certificates'));
    }

    public function integrationAttachment(Request $request)
    {
        $data = \App\CertificateOnAssetAttachment::where('coa_id',$request->coa_id)->get();

        $images = [];

        foreach ($data as $key => $value) {
            $images[] = \Storage::url($value->link);
        }

        return response()->json($images);
    }

    public function integrationStore(Request $request, Asset $asset)
    {
        $this->validate($request, [
                'certificate_id.*' => 'required',
                'number.*' => 'required',
            ], ['required' => "The fields can't be null"]);

        foreach ($request->certificate_id as $key => $value) {

            $data = new \App\CertificateOnAsset;
                $data->asset_id = $asset->id;
                $data->certificate_id = $request->certificate_id[$key];
                $data->number = $request->number[$key];
            $data->save();

            foreach ($request->file('attachment')[$key] as $v) {
                $attachment = new \App\CertificateOnAssetAttachment;
                    $attachment->link = $v->store('public/attachments');
                    $attachment->coa_id = $data->id;
                $attachment->save();
            }

            $asset = Asset::find($asset->id);
                $asset->last_updated_by = \Auth::user()->id;
            $asset->save();
        }

        return redirect()->back();
    }

    public function integrationDestroy(Request $request)
    {
        $images = \App\CertificateOnAssetAttachment::where('coa_id',$request->coa_id)->get();

        foreach ($images as $key => $value) {
            $data = \Storage::delete($value->link);
        }

        \App\CertificateOnAsset::find($request->coa_id)->delete();

        $asset = Asset::find($request->asset_id);
            $asset->last_updated_by = \Auth::user()->id;
        $asset->save();

        return response()->json(['success' => 'Certificate has been deleted!']);
    }
}
