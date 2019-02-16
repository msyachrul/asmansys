<?php

namespace App\Http\Controllers;

use App\CertificateOnAsset;
use App\Certificate;
use App\Asset;
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
        $certificates = Certificate::select(['id', 'name'])->orderBy('name', 'ASC')->get();
        $assets = Asset::select(['id', 'name'])->orderBy('name', 'ASC')->get();

        $listCertificate = CertificateOnAsset::select(['certificate_on_assets.asset_id as id', 'assets.name as asset', 'certificates.name as certificate', 'certificate_on_assets.number as number', 'certificate_on_assets.concerned as concerned'])->join('certificates', 'certificate_on_assets.certificate_id', 'certificates.id')->join('assets', 'certificate_on_assets.asset_id', 'assets.id');

        if (request('certificate')) {
            $listCertificate = $listCertificate->where('certificate_on_assets.certificate_id', request('certificate'));
        }

        if (request('asset')) {
            $listCertificate = $listCertificate->where('certificate_on_assets.asset_id', request('asset'));
        }

        $listCertificate = $listCertificate->orderBy('assets.name', 'ASC')->paginate(9);

        return view('certificate.index',compact('certificates', 'assets', 'listCertificate'));
    }
}
