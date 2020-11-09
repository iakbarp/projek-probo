<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 10/1/2018
 * Time: 8:38 PM
 */

namespace App\Support;

use App\User;
use Illuminate\Support\Facades\Auth;

class GlobalAuth
{
    /**
     * login process
     *
     * @param array $credentials
     * @return boolean
     */
    public function login($credentials)
    {
        if ($this->isUser($credentials['email'])) {
            $guard = 'web';

        } else {
            return false;
        }

        if (Auth::guard($guard)->attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * logout process
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard($this->getAttemptedGuard())->logout();
    }

    /**
     * Check whether one of the guard is login
     *
     * @return boolean
     */
    public function check()
    {
        $guard = $this->getAttemptedGuard();
        return !is_null($guard);
    }

    /**
     * get user who's logged in from one of the guard
     *
     * @return \App\User
     */
    public function user()
    {
        return Auth::guard('web')->user();
    }

    /**
     * get guard who's logged in as a string
     *
     * @return string|null
     */
    public function getAttemptedGuard()
    {
        if (Auth::guard('web')->check()) {
            return 'web';
        }
        return null;
    }

    /**
     * Check whether the intended email was found in the user table
     *
     * @param string $email
     * @return boolean
     */
    private function isUser($email)
    {
        return !is_null(User::where('email', $email)->first());
    }
}
