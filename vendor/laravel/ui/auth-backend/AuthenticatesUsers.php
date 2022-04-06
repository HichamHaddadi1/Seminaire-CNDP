<?php

namespace Illuminate\Foundation\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $uri_segments = explode('/', url()->previous());

        // dd($uri_segments[3] , '/' , $uri_segments[4]) ; //
        if(count($uri_segments) > 5 && 'meeting-room/join' == $uri_segments[3] .'/' . $uri_segments[4]) 
        {
            // dd('showLoginForm');
            Redirect::setIntendedUrl(url()->previous());
        }
        // dd(url()->previous());
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (auth()->user()->role == 1) {

            $uri_segments = explode('/', redirect()->intended('/')->getTargetUrl());
            // dd($uri_segments);
        // dd($uri_segments[3] , '/' , $uri_segments[4]) ; //
        if(count($uri_segments) > 5 && 'meeting-room/join' == $uri_segments[3] .'/' . $uri_segments[4]) 
        {
            // dd($uri_segments);
            // dd(collect($uri_segments)->implode('/'));
            return redirect(collect($uri_segments)->implode('/'));
        }
            
        
            return redirect()->route('admin.streams');
        }
        elseif (auth()->user()->role == 2)
        {
            $uri_segments = explode('/', redirect()->intended('/')->getTargetUrl());
            // dd($uri_segments);
        // dd($uri_segments[3] , '/' , $uri_segments[4]) ; //
        if(count($uri_segments) > 5 && 'meeting-room/join' == $uri_segments[3] .'/' . $uri_segments[4]) 
        {
            // dd($uri_segments);
            // dd(collect($uri_segments)->implode('/'));
            return redirect(collect($uri_segments)->implode('/'));
        }

            
            return redirect()->route('streamers.rooms');
        }
        elseif(auth()->user()->role ==3)
        {
            $uri_segments = explode('/', redirect()->intended('/')->getTargetUrl());
            // dd($uri_segments);
        // dd($uri_segments[3] , '/' , $uri_segments[4]) ; //
        if(count($uri_segments) > 5 && 'meeting-room/join' == $uri_segments[3] .'/' . $uri_segments[4]) 
        {
            // dd($uri_segments);
            // dd(collect($uri_segments)->implode('/'));
            return redirect(collect($uri_segments)->implode('/'));
        }
            return redirect()->route('userEvents');
        }
        elseif(auth()->user()->role == 4)
        {
            $uri_segments = explode('/', redirect()->intended('/')->getTargetUrl());
            // dd($uri_segments);
        // dd($uri_segments[3] , '/' , $uri_segments[4]) ; //
        if(count($uri_segments) > 5 && 'meeting-room/join' == $uri_segments[3] .'/' . $uri_segments[4]) 
        {
            // dd($uri_segments);
            // dd(collect($uri_segments)->implode('/'));
            return redirect(collect($uri_segments)->implode('/'));
        }
            return redirect()->route('validator.statistics');
        }
        // return '/home';
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
