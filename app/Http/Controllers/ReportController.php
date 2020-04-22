<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {	
    	 $data['page_title'] = 'Report Form';
    	 return view('admin/report_form',$data);
    }
}
