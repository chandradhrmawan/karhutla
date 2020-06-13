<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use App\User;


class MasterController extends Controller
{
    public function index()
    {
    	$data['page_title'] = 'Master Data';
    	$data['detail'] 	= DB::table('master')->get();
        $data['detail2']     = DB::table('presentase')->get();
    	return view('admin/master_data',$data);
    }

    public function get_master_data($id)
    {
    	$data = DB::table('master')->where('id',$id)->get();
    	return $data;
    }

    public function get_master_presentase($id)
    {
        $data = DB::table('presentase')->where('id',$id)->get();
        return $data;
    }

    public function update_master_data($id,$nilai)
    {
    	DB::table('master')
          ->where('id', $id)
          ->update(['nilai' => $nilai]);
        return true;
    }

    public function update_master_presentase($id,$nilai)
    {
        DB::table('presentase')
          ->where('id', $id)
          ->update(['nilai' => $nilai]);
        return true;
    }

    public function master_user()
    {
    	$data['page_title'] = 'Master Data User';
    	$data['detail'] 	= DB::table('users')->get();
    	return view('admin/master_data_users',$data);
    }

    public function get_master_data_user($id)
    {
    	$data = DB::table('users')->where('id',$id)->get();
    	return $data;
    }

    public function update_master_data_user($id,$status)
    {
    	DB::table('users')
          ->where('id', $id)
          ->update(['status' => $status]);
        return true;
    }

    public function sumbit_batal($id_pelaporan,$alasan_batal)
    {
    	DB::table('pelaporan')
          ->where('id_pelaporan', $id_pelaporan)
          ->update(['alasan_batal' => $alasan_batal,
          			'status' => 7
      				]);
        return true;
    }
}
