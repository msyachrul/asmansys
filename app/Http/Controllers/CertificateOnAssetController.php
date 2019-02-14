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

        $selectedCertificate = \App\Certificate::where('id',request('certificate_id'))->first();

        return view('certificate.index',compact('certificates', 'selectedCertificate'));
    }

    public function coaApi()
    {
        $data = CertificateOnAsset::select(['certificate_on_assets.asset_id as id', 'assets.name as asset', 'certificates.name as certificate', 'certificate_on_assets.number as number', 'certificate_on_assets.concerned as concerned'])->join('certificates', 'certificate_on_assets.certificate_id', 'certificates.id')->join('assets', 'certificate_on_assets.asset_id', 'assets.id')->paginate(9);

        return $data;
    }
}
