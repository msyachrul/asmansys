<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
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
        $data = Certificate::all();
        return view('admin.certificate.index',compact('data'));
    }

     public function userIndex()
    {
        $data = Certificate::all();
        return view('certificate.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certificate.create');
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
            'name' => 'required|unique:certificates,name',
            'shortname' => 'required|unique:certificates,shortname',
        ]);

        $data = new Certificate;
            $data->name = $request->name;
            $data->shortname = $request->shortname;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('certificate.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        $value = Certificate::join('users','certificates.last_updated_by','users.id')->select('certificates.id','certificates.name','certificates.shortname','users.name as user')->where('certificates.id',$certificate->id)->first();

        return view('admin.certificate.show',compact('value'));
    }

    public function userShow(Certificate $certificate)
    {
        $value = Certificate::join('users','certificates.last_updated_by','users.id')->select('certificates.id','certificates.name','certificates.shortname','users.name as user')->where('certificates.id',$certificate->id)->first();

        return view('certificate.show',compact('value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        $this->validate($request, [
            'name' => 'required|unique:certificates,name',
            'shortname' => 'required|unique:certificates,shortname',
        ]);

        $data = Certificate::find($certificate->id);
            $data->name = $request->name;
            $data->shortname = $request->shortname;
            $data->last_updated_by = \Auth::user()->id;
        $data->save();

        return redirect()->route('certificate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        Certificate::destroy($certificate->id);

        return redirect()->route('certificate.index');
    }
}
