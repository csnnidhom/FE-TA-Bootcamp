<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function proses_login(Request $request)
    {
        // $url_login = config('app.api_endpoints.login');
        $url_login = 'https://dummyjson.com/auth/login';

        $client = new Client([
            'verify' => false
        ]);

        $response = $client->request('POST', $url_login, [
            'form_params' => [
                'username' => $request->input('email'), 
                'password' => $request->input('password'),
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody()->getContents(), true);

        if ($statusCode == 200) {
            $accessToken = $responseData['accessToken'];

            session(['accessToken' => $accessToken]);

            // return redirect()->route('dashboard')->with('success', $responseData['message']);
            return $accessToken;
        } else {
            $error = $responseData['message'];
            return $error;
        }
    }  
}
