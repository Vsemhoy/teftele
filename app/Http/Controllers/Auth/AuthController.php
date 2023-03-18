<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\UserVerify;
use Hash;
use Illuminate\Support\Str;
use Mail;
use App\Http\Components\com_users\UsersDB;
use App\Http\Controllers\BaseHelpers\Input;
use Redirect;

class AuthController extends Controller
{
    const GUEST = 0;
    const REGISTR = 1;          // View statistics
    const MODERATOR = 2;      // Answer comments, answer by questions, write, but not publish NEWS, cannot edit !himself materials
    const ENGINEER = 3;       // ^ Also can create and edit STUFF
    const ADMINISTRATOR = 4;  // ^ Also can create and Manage Users, can manage and create News 
    const SUPERUSER = 5;      // Can make all
    public static $roles = [
        self::GUEST => "GUEST",
        self::REGISTR => "REGISTERED",
        self::MODERATOR => "MODERATOR",
        self::ENGINEER => "ENGINEER",
        self::ADMINISTRATOR => "ADMIN",
        self::SUPERUSER => "SUPERUSER"
    ];

    public static $roleNames = [
        self::GUEST => "Гость",
        self::REGISTR => "Зарегистрированный",
        self::MODERATOR => "Модератор",
        self::ENGINEER => "Инженер",
        self::ADMINISTRATOR => "Админ",
        self::SUPERUSER => "СуперПользователь"
    ];
/**
* Write code on Method
*
* @return response()
*/
    public function index()
    {
        return view('public.auth.login');
    }  
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function registration()
    {
        return view('public.auth.registration');
    }


    public function forget()
    {
    return view('public.auth.forget');
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function postLogin(Request $request)
    {
        $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
        ]);
        // a crutch, that loads email if user entered true login
        // then login by email
        $username = $request->only('email')['email'];
        $credentials = $request->only('email', 'password');
        if (!str_contains( $username, '@')){
            $credentials = ['login' => $username, 'password' => $credentials['password']];
        }
        if (Auth::attempt($credentials)) {
            //UsersDB::IncreaseUserLogins(Auth::id());
            return back()->withSuccess(['msg' => 'You okay!']);
            //     return redirect()->intended('apps/splmod/downloads/')
            // ->withSuccess('You have Successfully loggedin');
        } else {

            if (!$request->session()->has('user_login_attempts')){
                $request->session()->put('user_login_attempts', 0);
            } else {
                $n = $request->session()->get('user_login_attempts') + 1;
                $request->session()->put('user_login_attempts', $n);
            }
            return back()->withErrors(['msg' => 'You okay!']);
        }
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function postRegistration(Request $request)
    {  
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $createUser = $this->create($data);
        $token = Str::random(64);
        UserVerify::create([
        'user_id' => $createUser->id, 
        'token' => $token
        ]);
        Mail::send('email.emailVerificationEmail', ['token' => $token], function($message) use($request){
        $message->to($request->email);
        $message->subject('Email Verification Mail');
        });
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function dashboard()
    {
        if(Auth::check()){
        return view('dashboard');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function create(array $data)
    {
        return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
        ]);
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function logout() {
        $user = Auth::user();
        Session::flush();
        Auth::logout();
        return back()->withSuccess(['msg' => 'You logout okay!']);
    //return Redirect('index');
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyUser) ){
        $user = $verifyUser->user;
        if(!$user->is_email_verified) {
        $verifyUser->user->is_email_verified = 1;
        $verifyUser->user->save();
        $message = "Your e-mail is verified. You can now login.";
        } else {
        $message = "Your e-mail is already verified. You can now login.";
        }
        }
        return redirect()->route('login')->with('message', $message);
    }




    public function CheckLoginDuplicates(Request $request, $value)
    {
        $value = Input::filterMe("URL", $value, 40);
        $response = (object) array();
        $response->message = "true";
        if (strlen($value) < 5) {
            return true;
        }
        /// Prevent numerous calls
        if (!$request->session()->has('checkCount')){
            $request->session()->put('checkCount', 0);
        } else {
            $n = $request->session()->get('checkCount') + 1;
            $request->session()->put('checkCount', $n);
        }
            if ($request->session()->get('checkCount') == 100){
                die(true);
            }
        $response->count = $request->session()->get('checkCount');
        $response->message = UsersDb::CheckLoginDuplicates($value);
        return json_encode($response);
    }


    public function CheckEmailDuplicates(Request $request, $value)
    {
        $value = Input::filterMe("EMAIL", $value, 40);
        $response = (object) array();
        $response->message = "true";
        if (strlen($value) < 5) {
            return true;
        }
        /// Prevent numerous calls
        if (!$request->session()->has('checkCount')){
            $request->session()->put('checkCount', 0);
        } else {
            $n = $request->session()->get('checkCount') + 1;
            $request->session()->put('checkCount', $n);
        }
            if ($request->session()->get('checkCount') == 100){
                die(true);
            }
        $response->count = $request->session()->get('checkCount');
        $response->message = UsersDb::CheckMailDuplicates($value);
        return json_encode($response);
    }

}