<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Charts\Chartjs;
use Faker\Factory as Faker;

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

        // CertificateChart
        $certificateData = \App\Certificate::join('certificate_on_assets','certificate_on_assets.certificate_id','certificates.id')->select('certificates.name as name',DB::raw('COUNT(certificate_on_assets.id) as `qty`'))->groupBy('certificates.id')->get();

        $certificateChartLabels = [];
        $certificateChartQty = [];
        $certificateChartColor = [];

        if ($certificateData) {
            foreach ($certificateData as $key => $value) {
                $certificateChartLabels[$key] = $value->name;
                $certificateChartQty[$key] = $value->qty;
                $certificateChartColor[$key] = Faker::create()->hexcolor;
            }
        }

        $certificateChart = new Chartjs;
        $certificateChart->labels($certificateChartLabels)->dataset('certificateChart','pie', $certificateChartQty)->backgroundColor($certificateChartColor);
        $certificateChart->options([
            'legend' => [
                'position' => 'bottom',
            ],
        ]);

        // CategoryChart
        $categoryData = \App\Category::join('assets','assets.category_id','categories.id')->select('categories.name as name',DB::raw('COUNT(assets.id) as `qty`'))->groupBy('categories.id')->get();

        $categoryChartLabels = [];
        $categoryChartQty = [];
        $categoryChartColor = [];

        if ($categoryData) {
            foreach ($categoryData as $key => $value) {
                $categoryChartLabels[$key] = $value->name;
                $categoryChartQty[$key] = $value->qty;
                $categoryChartColor[$key] = Faker::create()->hexcolor;
            }
        }

        $categoryChart = new Chartjs;
        $categoryChart->labels($categoryChartLabels)->dataset('categoryChart','pie',$categoryChartQty)->backgroundColor($categoryChartColor);
        $categoryChart->options([
            'legend' => [
                'position' => 'bottom',
            ],
        ]);

        // RegionChart
        $regionData = \App\Region::join('assets','assets.region_id','regions.id')->select('regions.name as name',DB::raw('COUNT(assets.id) as `qty`'))->groupBy('regions.id')->get();

        $regionChartLabels = [];
        $regionChartQty = [];
        $regionChartColor = [];

        if ($regionData) {
            foreach ($regionData as $key => $value) {
                $regionChartLabels[$key] = $value->name;
                $regionChartQty[$key] = $value->qty;
                $regionChartColor[$key] = Faker::create()->hexcolor;
            }
        }

        $regionChart = new Chartjs;
        $regionChart->labels($regionChartLabels)->dataset('regionChart','pie',$regionChartQty)->backgroundColor($regionChartColor);
        $regionChart->options([
            'legend' => [
                'position' => 'bottom',
            ],
        ]);

        return view('admin.dashboard',compact('data','certificateChart','categoryChart','regionChart'));
    }
}
