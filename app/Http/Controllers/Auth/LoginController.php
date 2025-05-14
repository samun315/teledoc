<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $loginRequest): RedirectResponse
    {
        try {

            $user = User::query()->where('email', $loginRequest->input('email'))
                // ->where('active', ActiveStatus::YES)
                ->first(['id',  'full_name', 'email', 'role_id', 'phone', 'password','profile_img']);

            if (!empty($user)) {

                $checkHashPassword = Hash::check($loginRequest->input('password'), $user->password);

                if ($checkHashPassword) {

                    $authenticateUserInfo = [
                        "id" => $user->id,
                        "full_name" => $user->full_name,
                        "email" => $user->email,
                        "role_id" => $user->role_id,
                        "phone" => $user->phone,
                        "profile_img" => $user->profile_img,
                    ];

                    // Bind the authenticated user to Laravel's authentication system
                    auth()->login($user);
            
                    session()->put('logged_session_data', $authenticateUserInfo);
                    return redirect(route('dashboard'));
                } else {
                    return back()->with('error', 'Wrong password');
                }
            }

            return back()->with('error', 'Please give the valid information');
        } catch (Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        return redirect(url('/'))->with('success', 'logout successful ..!');
    }
}
