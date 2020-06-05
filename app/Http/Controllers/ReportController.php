<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use App\User;

class ReportController extends Controller
{
    public function index()
    {	
        $data['page_title'] = 'Report Form';
    	$data['prov']		 = DB::table('provinsi')->get();
    	return view('admin/report_form',$data);
    }

    public function get_form()
    {   
        $data['page_title'] = 'Report Form';
        $data['prov']        = DB::table('provinsi')->get();
        $data['user_detail'] = DB::table('users')->where('id',Auth::user()->id)->first();
        // print_r($data['user_detail']);die;
        return view('laporan',$data);
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
    	
        $uid      = Auth::user()->id;
        $fileName = time().'.'.$input->foto_kebakaran->extension();  
        $path     = public_path().'/uploads/foto_kebakaran/'.$uid;
        $path_db  = 'uploads/foto_kebakaran/'.$uid;

        if (!file_exists($path)) {
             File::makeDirectory($path, $mode = 0777, true, true);
        }

        $upload_success = $input->foto_kebakaran->move($path, $fileName);
        
        if($upload_success){
            $message = array('status'    => 'success',
                             'message'   => 'success baca file',
                             'location'  => self::get_image_location($path.'/'.$fileName),
                             'path_foto' => $path_db.'/'.$fileName
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
                      <div class="form-group col-md-6">
                        <label>Longitude</label>
                        <input type="text" name="longitude_foto" class="form-control" id="longitude_foto" value="'.$location['longitude'].'">
                      </div>
                      <div class="form-group col-md-6">
                        <label>Latitude</label>
                        <input type="text" name="latitude_foto" class="form-control" id="latitude_foto" value="'.$location['latitude'].'">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label>Lokasi Foto</label>
                        <input type="text" name="lokasi_foto" class="form-control" id="lokasi_foto">
                        <input type="hidden" name="path_foto" class="form-control" id="path_foto" value="'.$path_foto.'">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label>Keterangan<code>*</code></label>
                        <input type="text" name="keterangan" class="form-control" id="keterangan"><code>Keterangan Foto Kebakaran</code>
                      </div>
                    </div>';
        return $html;
    }

    public function submit_form(Request $input)
    {
 
        $uid = Auth::user()->id;
        $data=array('id_user'        => $uid,
                    'jarak'          => $input->jarak,
                    'name'           => $input->name,
                    'email'          => $input->email,
                    'longitude_user' => $input->longitude_user,
                    'latitude_user'  => $input->latitude_user,
                    'no_telp'        => $input->no_telp,
                    'alamat'         => $input->alamat,
                    'longitude_foto' => $input->longitude_foto,
                    'latitude_foto'  => $input->latitude_foto,
                    'lokasi_foto'    => $input->lokasi_foto,
                    'path_foto'      => $input->path_foto,
                    'keterangan'     => $input->keterangan,
                    'provinsi'       => $input->provinsi,
                    'kabupaten'      => $input->kabupaten,
                    'kecamatan'      => $input->kecamatan,
                    'kelurahan'      => $input->kelurahan,
                    'geometry_lat'   => $input->geometry_lat,
                    'geometry_lng'   => $input->geometry_lng,
                    'alamat_lengkap' => $input->alamat_lengkap,
                    'geometry_desc'  => $input->geometry_desc,
                    'tgl_pelaporan'  => date('Y-m-d H:i:s')
        );

        $insert = DB::table('pelaporan')->insert($data);

        if($insert){
            echo json_encode("Suskes Simpan Data");
        }else{
            echo json_encode("Gagal");
        }
    }

    public function get_report_data()
    {
        $data = DB::table('pelaporan')->get();
        echo json_encode($data);
    }

    public function get_report_conf()
    {
        $conf  = DB::table('master')->where('id',2)->first();
        $nilai = $conf->nilai;

        $data = DB::table('pelaporan')
                 ->select(DB::raw('count(*) AS confident,name, geometry_lat,geometry_lng,geometry_desc'))
                 ->groupBy('geometry_lat','geometry_lng','name','geometry_desc')
                 ->havingRaw('count(*) >= ?', [$nilai])
                 ->get();

        echo json_encode($data);
    }

    public function getDistanceBetween(Request $input) 
    { 
        
        $latitude1  = $input->latitude1;
        $longitude1 = $input->longitude1;
        $latitude2  = $input->latitude2;
        $longitude2 = $input->longitude2;
        $unit       = $input->unit;

        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        switch($unit) 
        { 
            case 'Mi': break; 
            case 'Km' : $distance = $distance * 1.609344; 
        } 
        return (round($distance,2)); 
    }

    public function hist_pelaporan($id_user=null)
    {   

        $data['page_title'] = 'Riwayat Pelaporan';
        if(empty($id_user)){
            $data['detail'] = DB::table('pelaporan')->get();
        }else{
            $data['detail'] = DB::table('pelaporan')->where('id_user',$id_user)->get();
        }

        $data['max_pelaporan'] = DB::table('master')->where('id',1)->first();

        return view('hist_pelaporan',$data);

        dd($data['detail']);
    }

    public function test()
    {
        return view('test');
    }
}
