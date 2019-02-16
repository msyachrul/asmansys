<?php

namespace App\Http\Controllers;

use App\Asset;
use DataTables;
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

    public function createLog($information)
    {
        $log = new \App\Log;
            $log->information = $information . " by " . \Auth::user()->name;
        $log->save();

    }

    public function getAssetData($asset_id)
    {
        $data['asset'] = Asset::join('categories','assets.category_id','categories.id')
        ->join('regions','assets.region_id','regions.id')
        ->join('users','assets.last_updated_by','users.id')
        ->where('assets.id',$asset_id)
            ->select(
                'assets.id',
                'assets.name',
                'assets.nop',
                'assets.address',
                'assets.description',
                'assets.category_id',
                'assets.region_id',
                'assets.status',
                'assets.note',
                'users.name as user'
            )->first();

        $data['picts'] = \App\Picture::where('asset_id',$data['asset']->id)->get();

        $data['category'] = \App\Category::all();
        $data['region'] = \App\Region::all();

        return $data;
    }

    public function index()
    {
        return view('admin.asset.index');
    }

    public function userIndex()
    {
        $regions = \App\Region::select(['id', 'name'])->orderBy('name', 'ASC')->get();
        $categories = \App\Category::select(['id', 'name'])->orderBy('name', 'ASC')->get();
        $listAsset = Asset::select(['assets.id as id', 'assets.name as asset', 'regions.name as region', 'categories.name as category', 'assets.status as status'])->join('regions', 'assets.region_id', 'regions.id')->join('categories', 'assets.category_id', 'categories.id');

        if (request('region')) {
            $listAsset = $listAsset->where('assets.region_id', request('region'));
        }

        if (request('category')) {
            $listAsset = $listAsset->where('assets.category_id', request('category'));
        }
        
        $listAsset = $listAsset->orderBy('assets.name', 'ASC')->paginate(9);
        
        return view('asset.index',compact('regions', 'categories', 'listAsset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = \App\Category::select(['id', 'name'])->orderBy('name', 'ASC')->get();
        $region = \App\Region::select(['id', 'name'])->orderBy('name', 'ASC')->get();
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
            'nop' => 'required',
            'address' => 'required',
            'description'  => 'required',
            'category_id' => 'required',
            'region_id' => 'required',
            'picture.*' => 'nullable|max:5000',
            'status' => 'required',
            'note' => 'required',
        ]);

        // upload gambar dan mengembalikan string lokasi gambar
        // $pictPath = $request->file('picture')->store('public/images');

        $data = new Asset;
            $data->name = $request->name;
            $data->nop = $request->nop;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->region_id = $request->region_id;
            $data->status = $request->status;
            $data->note = $request->note;
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

        $this->createLog('Create new asset : ' . $request->name);

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

        $data = $this->getAssetData($asset->id);

        return view('admin.asset.show',compact('data'));
    }

    public function userShow(Asset $asset)
    {

        $data = $this->getAssetData($asset->id);

        $data['category'] = \App\Category::where('id',$data['asset']->category_id)->first();

        $data['region'] = \App\Region::where('id',$data['asset']->region_id)->first();


        $data['integration'] = \App\CertificateOnAsset::join('certificates','certificate_on_assets.certificate_id','certificates.id')->where('certificate_on_assets.asset_id',$asset->id)->select('certificates.name','certificates.shortname','certificate_on_assets.number','certificate_on_assets.id','certificate_on_assets.concerned')->get();

        // $this->createLog('Open Asset ' . $data['asset']->name);

        return view('asset.show',compact('data'));
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
            'name' => 'required',
            'nop' => 'required',
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
            $data->nop = $request->nop;
            $data->address = $request->address;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->region_id = $request->region_id;
            $data->status = $request->status;
            $data->note = $request->note;
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
        $this->createLog('Remove asset : ' . $asset->id . " - " . $this->getAssetData($asset->id)['asset']->name );

        // hapus gambar
        $path = \App\Picture::where('asset_id',$asset->id)->get();
            foreach ($path as $key => $value) {
                \Storage::delete($value->path);
            }

        $coa = \App\CertificateOnAsset::where('asset_id',$asset->id)->first();
        
        if ($coa) {
            $path = \App\CertificateOnAssetAttachment::where('coa_id',$coa->id)->get();
                foreach ($path as $key => $value) {
                    \Storage::delete($value->link);
                }
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
        
        $integration = \App\CertificateOnAsset::join('certificates','certificate_on_assets.certificate_id','certificates.id')->where('certificate_on_assets.asset_id',$asset->id)
            ->select(
                'certificate_on_assets.id',
                'certificates.name',
                'certificates.id as certificate_id',
                'certificate_on_assets.number',
                'certificate_on_assets.last_owner',
                'certificate_on_assets.current_owner',
                'certificate_on_assets.concerned')->get();
        
        $certificates = \App\Certificate::all();

        return view('admin.asset.document',compact('value','integration','certificates'));
    }

    public function integrationAttachment(Request $request)
    {
        $data = \App\CertificateOnAssetAttachment::where('coa_id',$request->coa_id)->get()->toArray();

        if ($data == null) {
            $data[] = ['link' => 'public/attachments/blank.png'];
        }

        $images = [];

        foreach ($data as $key => $value) {
            $images[] = asset(\Storage::url($value['link']));
        }

        return response()->json($images);
    }

    public function integrationStore(Request $request, Asset $asset)
    {
        $this->validate($request, [
                'certificate_id' => 'required',
                'number' => 'required',
                // 'concerned' => 'required',
            ], ['required' => "The fields can't be null"]);

        $data = new \App\CertificateOnAsset;
            $data->asset_id = $asset->id;
            $data->certificate_id = $request->certificate_id;
            $data->number = $request->number;
            $data->last_owner = $request->last_owner;
            $data->current_owner = $request->current_owner;
            $data->concerned = $request->concerned;
        $data->save();

        if ($request->file('attachment')) {
            foreach ($request->file('attachment') as $v) {
                $attachment = new \App\CertificateOnAssetAttachment;
                    $attachment->link = $v->store('public/attachments');
                    $attachment->coa_id = $data->id;
                $attachment->save();
            }
        }

        $asset = Asset::find($asset->id);
            $asset->last_updated_by = \Auth::user()->id;
        $asset->save();

        $this->createLog('Add certificate on asset : ' . $asset->id . " - " . $this->getAssetData($asset->id)['asset']->name);

        return redirect()->back();
    }

    public function integrationUpdate(Request $request)
    {
        $this->validate($request, [
                'certificate_id' => 'required',
                'number' => 'required',
                'coa_id' => 'required',
                'asset_id' => 'required',
                // 'concerned' => 'required',
            ], ['required' => "The fields can't be null"]);

        $data = \App\CertificateOnAsset::find($request->coa_id);
            $data->certificate_id = $request->certificate_id;
            $data->number = $request->number;
            $data->last_owner = $request->last_owner;
            $data->current_owner = $request->current_owner;
            $data->concerned = $request->concerned;
        $data->save();

        if ($request->file('attachment')) {
            $images = \App\CertificateOnAssetAttachment::where('coa_id',$request->coa_id)->get();

                foreach ($images as $key => $value) {
                    $data = \Storage::delete($value->link);
                }
                
            \App\CertificateOnAssetAttachment::where('coa_id',$request->coa_id)->delete();

            foreach ($request->file('attachment') as $v) {
                $attachment = new \App\CertificateOnAssetAttachment;
                    $attachment->link = $v->store('public/attachments');
                    $attachment->coa_id = $request->coa_id;
                $attachment->save();
            }
        }

        $asset = Asset::find($request->asset_id);
            $asset->last_updated_by = \Auth::user()->id;
        $asset->save();

        $this->createLog('Update certificate on asset : ' . $request->asset_id . " - " . $this->getAssetData($request->asset_id)['asset']->name);

        return redirect()->back();   
    }

    public function integrationDestroy(Request $request)
    {
        $this->createLog('Remove certificate on asset : ' . $request->asset_id . " - " . $this->getAssetData($request->asset_id)['asset']->name);

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

    public function adminAssetApi()
    {
        $query = Asset::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status', function ($query) {
                return $query->status ? 'Available' : 'Not Available';
            })
            ->addColumn('action', function ($query) {
                return view('layout._action', [
                    'urlDetail' => route('asset.show', $query->id),
                    'urlIntegration' => route('asset.integrationShow', $query->id),
                ]);
            })
            ->make(true);
    }
}
