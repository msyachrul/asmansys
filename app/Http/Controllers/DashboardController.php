<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\DB;
use App\Charts\MyChart;

class DashboardController extends Controller
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
        $data = (object) [
            'assets' => \App\Asset::all()->count(),
            'certificates' => \App\CertificateOnAsset::all()->count(),
            'categories' => \App\Category::all()->count(),
            'regions' => \App\Region::all()->count(),
        ];

        $categoryChart = new Lavacharts;
        $value = \App\Asset::join('categories','categories.id','assets.category_id')
                    ->select('categories.name as 0',DB::raw('COUNT(assets.id) as `1`'))->groupBy('categories.id')->get()->toArray();
        $chart = $categoryChart->DataTable();
            $chart->addStringColumn('Category')
                     ->addNumberColumn('Quantity')
                     ->addRows($value);
        $categoryChart->PieChart('Category',$chart,[
            'height' => 500,
            'fontSize' => 14,
            'legend' => [
                'position' => 'bottom',
            ]
        ]);

        $resCert = \App\Certificate::join('certificate_on_assets','certificate_on_assets.certificate_id','certificates.id')->select(DB::raw('COUNT(certificate_on_assets.id) as `qty`'))->groupBy('certificates.id')->get()->toArray();
        
        $certificates = [];

        foreach ($resCert as $key => $value) {
            $certificates[$key] = $value['qty'];
        }

        $charts = new MyChart;
        $charts->dataset('MyChart','pie', $certificates)->backgroundColor(['magenta','blue','cyan','yellow','grey']);

        return view('admin.dashboard',compact('data','categoryChart','charts'));
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
