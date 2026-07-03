<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $user = $request->user();

        $intended = $request->session()->pull('url.intended', null);

        if ($user && isset($user->role)) {
            switch ($user->role) {
                case 'admin':
                    $destination = route('admin.dashboard');
                    break;
                case 'dosen':
                    $destination = route('dosen.dashboard');
                    break;
                case 'mahasiswa':
                default:
                    $destination = route('mahasiswa.dashboard');
                    break;
            }

            return redirect()->intended($intended ?? $destination);
        }

        return redirect()->intended($intended ?? config('fortify.home'));
    }
}
