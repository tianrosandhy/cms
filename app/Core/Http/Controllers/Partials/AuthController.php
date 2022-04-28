<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Base\Presenters\BaseViewPresenter;
use App\Core\Http\Process\LoginProcess;
use App\Core\Http\Process\PasswordResetProcess;
use App\Core\Jobs\ResetPasswordJob;
use App\Core\Models\User;
use DB;

trait AuthController
{
    public function login()
    {
        $p = (new BaseViewPresenter)
            ->setTitle('Login')
            ->setView('core::pages.auth.login');
        return $p->render();
    }

    public function storeLogin()
    {
        return (new LoginProcess)
            ->setSuccessRedirectTarget(admin_url('/'))
            ->setErrorRedirectTarget(route('admin.login'))
            ->setSuccessMessage('You have logged in successfully')
            ->handle();
    }

    public function logout()
    {
        admin_guard()->logout();
        return redirect(admin_url('/'));
    }

    public function forgotPassword()
    {
        if (!$this->request->email) {
            return back()->with('error', 'Please type your email to send the password reset link');
        }
        $user = User::where('email', $this->request->email)->first();
        if (empty($user)) {
            return back()->with('error', 'Sorry, we cannot find your email address in our system.');
        }

        ResetPasswordJob::dispatch($user);
        return back()->with('success', 'Password reset link has been sent to your email. Please check your email and reset your password');
    }

    public function passwordReset($token)
    {
        $user = $this->getUserByToken($token);
        $title = 'Password Reset';
        return view('core::pages.auth.password-reset', compact(
            'title',
            'user'
        ));
    }

    public function passwordResetPost($token)
    {
        $user = $this->getUserByToken($token);
        return (new PasswordResetProcess($user))
            ->setSuccessMessage('Your password has been updated successfully. You can login with your new password now')
            ->setSuccessRedirectTarget(route('admin.login'))
            ->handle();

    }

    protected function getUserByToken($token, $abort = true)
    {
        $grab = DB::table('password_resets')->where('token', $token)->first();
        if (isset($grab->email)) {
            return User::where('email', $grab->email)->first();
        }
        if ($abort) {
            abort(404);
        }
        return false;
    }

}
