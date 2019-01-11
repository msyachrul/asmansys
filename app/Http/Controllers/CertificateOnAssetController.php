<?php

namespace App\Http\Controllers;

use App\CertificateOnAsset;
use DataTables;
use Illuminate\Http\Request;

class CertificateOnAssetController extends Controller
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
        $certificates = \App\Certificate::all();

        $selectedCertificate = \App\Certificate::where('id',request('id'))->first();

        $apiUrl = route('certificate.coaApi');

        if (request()->query()) {
            $apiUrl = $apiUrl . '?' . explode('?', request()->fullUrl())[1];
        }

        return view('certificate.index',compact('certificates','selectedCertificate','apiUrl'));
    }

    public function coaApi()
    {
        $query = CertificateOnAsset::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($query) {
                return view('certificate.row',[
                    'model' => $query,
                    'url' => route('asset.userShow', $query->asset_id)
                ]);
            })
            ->rawColumns(['name'])
            ->make(true);
    }
}
