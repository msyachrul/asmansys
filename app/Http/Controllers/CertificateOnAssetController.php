<?php

namespace App\Http\Controllers;

use App\CertificateOnAsset;
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

        $data = CertificateOnAsset::join('certificates','certificates.id','certificate_on_assets.certificate_id')->select('certificate_on_assets.id as id','certificates.name as name','certificate_on_assets.number','certificate_on_assets.asset_id','certificate_on_assets.concerned');

        if (request('id')) {
            $data = $data->where('certificates.id',request('id'));
        }

        $data = $data->orderBy('certificate_on_assets.asset_id','ASC')->get();

        return view('certificate.index',compact('data','certificates','selectedCertificate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
