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
        $data['page_title'] = 'Dashboard';
        $data['colabolator'] = DB::table('pelaporan')->get();
        $year = 2020;
        $sql = "SELECT ";
        for ($i=1; $i <=12; $i++) { 
            $sql .= "(SELECT count(*) from pelaporan where YEAR(tgl_pelaporan) = '".$year."' AND MONTH(tgl_pelaporan) = '".$i."' ) AS '".$i."',";
        }
        $sql = substr($sql, 0, -1);
        $sql .= "FROM DUAL";
        
        $data['bar_char'] = DB::select($sql);

         // print_r($data['bar_char']);die;

        foreach ($data['bar_char'] as $key => $value) {
            foreach ($value as $keyx => $valuex) {
            // print_r($valuex);
            $data['bar_chart'][] = $valuex;
            }
        }

        $data['result_bar'] = json_encode($data['bar_chart']);
// die;
        /*echo "<pre>";
        print_r();
        die();*/
       
        
        return view('admin/dashboard',$data);
        // return view('home');
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
    		'name' 		=> 'required|min:4',
            'username'  => 'required|min:4',
    		'email'		=> 'required|email|unique:users',
            'password'  => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'long'      => 'required',
            'lat'       => 'required',
    	]);

        $loc = array('long' => $input->long,
                     'lat' => $input->lat,
        );

        $data=array('name'          => $input->name,
                    'username'      => $input->username,
                    'email'         => $input->email,
                    'password'      => bcrypt($input->password),
                    'created_loc'   => json_encode($loc)
        );

        User::create($data);

        // DB::table('users')->insert($data);

    	return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
