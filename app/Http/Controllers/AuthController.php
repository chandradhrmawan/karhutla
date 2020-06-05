<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class AuthController extends Controller
{
	public function getLogin()
    {
        return view('login');
    }

    public function dashboard()
    {
        $data['page_title']     = 'Dashboard';
        $data['colabolator']    = DB::table('pelaporan')->get();
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

    public function postLogin(Request $input)
    {
    	$data = array(
            'username' => $input->username,
            'password' => $input->password
        );

        if(!auth()->attempt($data)){
            return redirect('/login')->with(['error' => 'Password Salah']);
        }

         return redirect()->route('home');
    }

    public function getRegister()
    {
    	return view('register');
    }

    public function postRegister(Request $input)
    {

    	$this->validate($input, [
    		'name' 		            => 'required|min:4',
            'username'              => 'required|min:4',
    		'email'		            => 'required|email|unique:users',
            'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'long'                  => 'required',
            'lat'                   => 'required',
            'lokasi_foto'           => 'required',
            'no_telp'               => 'required'
    	]);

        $loc = array('long' => $input->long,
                     'lat' => $input->lat,
        );

        $data=array('name'          => $input->name,
                    'username'      => $input->username,
                    'email'         => $input->email,
                    'password'      => bcrypt($input->password),
                    'created_loc'   => json_encode($loc),
                    'location'      => $input->lokasi_foto,
                    'no_telp'       => $input->no_telp
        );

        User::create($data);

    	return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
