<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
    	$data['pegawai'] = 'Chandra1';
    	$data['content'] = 'Chandra2';
    	$data['hasil'] = 'Chandra3';

    	return view('admin/dashboard',$data);
    }
}
