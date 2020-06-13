<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use App\Helpers\GlobalHelers;

class AdminController extends Controller
{
   public function dashboard()
    {
        $data['page_title']     = 'Dashboard';
        $data['colabolator']    = GlobalHelers::get_data_pelaporan(0);
        // dd($data);
        $data['year']           = [date('Y')-1,date('Y')+0,date('Y')+1];
        $data['result_bar']     = json_encode(self::get_data_chart(date('Y')));
        
        return view('admin/dashboard',$data);
    }

    public function get_data_chart($year)
    {
        $sql = "SELECT ";
        for ($i=1; $i <=12; $i++) { 
            $sql .= "(SELECT count(*) from pelaporan where YEAR(tgl_pelaporan) = '".$year."' AND MONTH(tgl_pelaporan) = '".$i."' ) AS '".$i."',";
        }
        $sql = substr($sql, 0, -1);
        $sql .= "FROM DUAL";
        
        $data['bar_char'] = DB::select($sql);

        foreach ($data['bar_char'] as $key => $value) {
            foreach ($value as $keyx => $valuex) {
            $data['bar_chart'][] = $valuex;
            }
        }

        return $data['bar_chart'];
    }

    public function generate_map($conf)
    {       
        $data['conf'] = $conf;
        return view('admin/map',$data);
    }
}
