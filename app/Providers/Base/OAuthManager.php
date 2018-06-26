<?php

namespace App\Providers\Base;

use App\Common\Extensions\Code;
use App\User;
use Illuminate\Support\Facades\Auth;

class OAuthManager
{
    protected $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function auth($user)
    {

        $method = 'authWith' . ucfirst($this->driver);
        if (!method_exists($this, $method)) {
            return false;
        }
        return $this->$method($user);

    }

    private function getUniqueId($column, $value)
    {
        return User::where($column, $value)->first();
    }

    private function getUniqueName($name)
    {
        if (User::query()->where('username', $name)->first()) {
            return $name . '_' . str_random(5);
        }
        return $name;
    }

    private function authLogin($currentUser)
    {
        if ($currentUser->state !== Code::ENABLED_STATUS) {
            return true;
        }
        Auth::login($currentUser);
        return $currentUser;
    }

    protected function authWithQq($user)
    {
        // 如果已经存在 -> 登录
        $currentUser = $this->getUniqueId('qqOpenid', $user->id);
        if ($currentUser) {
            return $this->authLogin($currentUser);
        }
        // 创建用户
        // 判断有重复昵称则拼接随机字符串
        $username = $this->getUniqueName($user->nickname);

        $currentUser = User::create([
            'qqOpenid'          => $user->id,
            'username'          => $username,
            'nickname'          => $user->nickname,
            'email'             => $user->email,
            'state'             => Code::ENABLED_STATUS,
            'avatar'            => $user->avatar,
            'password'          => '',
            'confirmationToken' => str_random(40),
        ]);

        return $this->authLogin($currentUser);
    }

    // 存储github用户信息
    protected function authWithGithub($user)
    {
        // 如果已经存在 -> 登录
        $currentUser = $this->getUniqueId('githubId', $user->id);
        if ($currentUser) {
            return $this->authLogin($currentUser);
        }

        $username = $this->getUniqueName($user->nickname);

        // 创建用户
        $currentUser = User::create([
            'username'   => $username,
            'nickname'   => $user->nickname,
            'email'      => $user->email,
            'avatar'     => $user->avatar,
            'githubId'   => $user->id,
            'githubName' => $user->name,
            'githubUrl'  => $user->user['url'],
            'state'      => Code::ENABLED_STATUS,
            'password'   => ''

        ]);

        return $this->authLogin($currentUser);
    }

    // 存储weibo用户信息
    protected function authWithWeibo($user)
    {
        // 如果已经存在 -> 登录
        $currentUser = $this->getUniqueId('wbOpenId', $user->id);
        if ($currentUser) {
            return $this->authLogin($currentUser);
        }

        $username = $this->getUniqueName($user->nickname);
        // 创建用户
        $currentUser = User::create([
            'username' => $username,
            'nickname' => $user->nickname,
            'email'    => $user->email,
            'avatar'   => $user->avatar,
            'wbOpenId' => $user->id,
            'state'    => Code::ENABLED_STATUS,
            'password' => ''

        ]);

        return $this->authLogin($currentUser);
    }
}