<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;

class ReportController extends Controller
{
    public function index()
    {	
        $data['page_title'] = 'Report Form';
    	$data['prov']		 = DB::table('provinsi')->get();
    	return view('admin/report_form',$data);
    }

    public function get_kabupaten($id_prov)
    {	
    	$data = DB::table('kabupaten')->where('id_prov', $id_prov)->get();
    	$html = "";
    	foreach ($data as $key => $value) {
    		$html .= '<option value='.$value->id_kab.'> '.$value->nama.' </option>';
    	}

    	echo $html;
    }

    public function get_kecamatan($id_kab)
    {
    	$data = DB::table('kecamatan')->where('id_kab', $id_kab)->get();
    	$html = "";
    	foreach ($data as $key => $value) {
    		$html .= '<option value='.$value->id_kec.'> '.$value->nama.' </option>';
    	}

    	echo $html;
    }

    public function get_kelurahan($id_kec)
    {
    	$data = DB::table('kelurahan')->where('id_kec', $id_kec)->get();
    	$html = "";
    	foreach ($data as $key => $value) {
    		$html .= '<option value='.$value->id_kec.'> '.$value->nama.' </option>';
    	}

    	echo $html;
    }

    public function read_image(Request $input)
    {
    	
        $uid = Auth::user()->id;
        $fileName = time().'.'.$input->foto_kebakaran->extension();  
        $path = public_path().'/uploads/foto_kebakaran/'.$uid;

        if (!file_exists($path)) {
             File::makeDirectory($path, $mode = 0777, true, true);
        }

        $upload_success = $input->foto_kebakaran->move($path, $fileName);
        
        if($upload_success){
            $message = array('status'    => 'success',
                             'message'   => 'success baca file',
                             'location'  => self::get_image_location($path.'/'.$fileName),
                             'path_foto' => $path.'/'.$fileName
                            );
        }else{
            $message = array('status' => 'fail',
                             'message' => 'gagal membaca file',
                             'location' => 'lokasi tidak terdaftar',
                             'path_foto' => 'foto tidak terdeteksi'
                            );
        }

        if($message['status'] == 'success'){
            $html = self::generate_deskripsi_foto($message['location'],$message['path_foto']);
        }else{
            $html = dd($message['message']);
        }

        echo $html;
   
    }

    public function get_image_location($image = '')
    {
        // $exif = exif_read_data($image, 0, true);
        $exif = exif_read_data($image, NULL, true);
        if($exif && isset($exif['GPS'])){

            if(!isset($exif['GPS']['GPSLatitudeRef'])){
                return array('latitude'=>0, 'longitude'=>0);
            }

            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude    = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude   = $exif['GPS']['GPSLongitude'];
            
            $lat_degrees = count($GPSLatitude) > 0 ? self::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? self::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? self::gps2Num($GPSLatitude[2]) : 0;
            
            $lon_degrees = count($GPSLongitude) > 0 ? self::gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? self::gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? self::gps2Num($GPSLongitude[2]) : 0;
            
            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
            
            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return array('latitude'=>0, 'longitude'=>0);
        }
    }

    public function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
            return 0;
        if(count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    public function generate_deskripsi_foto($location,$path_foto)
    {
        $html = '<div class="form-row">
                      <div class="form-group col-md-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude_foto" class="form-control" id="longitude_foto" value="'.$location['longitude'].'">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude_foto" class="form-control" id="latitude_foto" value="'.$location['latitude'].'">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Lokasi Foto</label>
                        <input type="text" name="lokasi_foto" class="form-control" id="lokasi_foto">
                        <input type="hidden" name="path_foto" class="form-control" id="path_foto" value="'.$path_foto.'">
                      </div>
                </div>';
        return $html;
    }

    public function submit_form(Request $input)
    {
        dd($input);
    }
}
