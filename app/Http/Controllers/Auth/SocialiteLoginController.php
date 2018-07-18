<?php

namespace App\Http\Controllers\Auth;

use App\Common\PublicController;
use App\Providers\Base\OAuthManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends PublicController
{
    use AuthenticatesUsers;

    /**
     * 第三方登录用户信息的展示
     *
     * @param $service
     * @return mixed
     */
    public function redirectToProvider($service)
    {
        if (auth()->check()) {
            return redirect(request()->header('Referer'));
        }
        session(['redirect' => request()->header('Referer')]);

        return Socialite::driver($service)->redirect();
    }

    /**
     * 处理第三方登录的回调
     *
     * @param $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($service)
    {
        $user    = Socialite::driver($service)->user();
        $manager = new OAuthManager($service);
        $manager->auth($user);

        return redirect(session('redirect', route('home')));
    }
}
