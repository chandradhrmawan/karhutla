<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GlobalHelers {

    public static function get_jml_conf($data,$tpye) {

    	if($tpye == 'geometry'){
    		$lat = "geometry_lat";
    		$long = "geometry_lng";
    	}else{
    		$lat = "latitude_foto";
    		$long = "longitude_foto";
    	}

    	$data = DB::table('pelaporan')
				->where($lat,$data['kebakaran_lat'])
				->where($long,$data['kebakaran_lng'])
				->count();

		return $data;
    }

    public static function get_data_pelaporan($persen=0)
    {	
    	
        $conf  = DB::table('presentase')->where('persen',$persen)->first();
        $nilai = $conf->nilai;

        $data_head = DB::table('pelaporan')
                 ->select(DB::raw('count(*) AS confident, geometry_lat,geometry_lng,geometry_desc'))
                 ->groupBy('geometry_lat','geometry_lng','geometry_desc')
                 ->havingRaw('count(*) >= ?', [$nilai])
                 ->get();

        foreach ($data_head as $key => $value) {
            $detail = DB::table('pelaporan')
                         ->where('geometry_lat',$value->geometry_lat)
                         ->where('geometry_lng',$value->geometry_lng)
                         ->get();

            foreach ($detail as $key => $value) {
                $results[] = $value;
            }
        }
        // dd($results);
        // $results = (!empty($results)) ? rsort($results) : [];
        return ($results);
    }
}