<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use App\PasswordResets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    
    protected $redirectTo = '/';
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function updatePass(Request $request, $token = null)
    {
        $user = User::where('email', $request -> email) -> first();

        if( $user ) {

            $recov = PasswordResets::where('email', $user->email) -> first();
            if ( $recov && $request -> token == $recov -> token && $request -> password == $request -> repassword) {
                $user -> password = bcrypt($request -> password);
                $user -> save();

                $recov -> delete();
                
                return redirect('/') -> withSuccess('Пароль успешно обновлен');
            } else return redirect() -> back() -> withErrors(['Ошибка отправки, попытайтесь снова']);

        } else return redirect() -> back() -> withErrors(['Не удалось найти пользователя']);
        
    }

    public function sendEmailConfirm(Request $request, $token = null)
    {
        $user = User::where('email', $request -> email) -> first();

        if( $user ) {

        	if ( $token == null ) {

	            $token = str_random(16);
	            Mail::send('auth.emails.password', ['token' => $token, 'user' => $user], function ($m) use ($user) {
	                $m->from('admin@rostovka.net', 'Rostovka.Net');
	                $m->to($user->email, $user->name)->subject('Password Recovery');
	            });

	            $recov = PasswordResets::where('email', $user->email) -> first();
	            if ( !$recov ) $recov = new PasswordResets();
	            $recov -> token = $token;
	            $recov -> email = $user->email;
	            $recov -> expires_at = Carbon::now() -> addDays(1);
	            $recov -> save();

	            return redirect() -> back() -> withSuccess('Письмо с инструкцией отправлено на вашу почту');
	        } else {

	        	$recov = PasswordResets::where('email', $user->email) -> first();
	        	
	        	if ( $recov && $token == $recov -> token ) {

	        		return view('user.login_register.reset') -> with(['token' => $recov -> token, 'email' => $user->email]);

	        	}

	        	return redirect() -> back() -> withErrors(['Ошибка отправки, попытайтесь снова']);
	        }	
        } else return redirect() -> back() -> withErrors(['Не удалось найти пользователя']);

        return redirect() -> back() -> withErrors(['Ошибка отправки, попытайтесь снова']);
    }
}