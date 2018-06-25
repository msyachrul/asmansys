<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Certificate;

class MyChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $res = Certificate::all();

        $certificates = [];

        foreach ($res as $key => $value) {
        	$certificates[] = $value->name;
        }

        $this->labels($certificates);
    }
}
