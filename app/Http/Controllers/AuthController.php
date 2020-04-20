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
            'password_confirmation' => 'min:6'
    	]);

        $data=array('name'       => $input->name,
                    'username'   => $input->username,
                    'email'      => $input->email,
                    'password'   => bcrypt($input->password),
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
