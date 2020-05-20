<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;

class AdminController extends Controller
{
    public function index(){
    	$data['pegawai'] 	= 'Chandra1';
    	$data['content'] 	= 'Chandra2';
    	$data['hasil'] 		= 'Chandra3';
    	$data['colabolator'] = DB::table('pelaporan')->get();

    	return view('admin/dashboard',$data);
    }
}
