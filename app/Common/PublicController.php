<?php

namespace App\Common;

use App\Common\Models\About;
use App\Common\Models\Link;
use App\Common\Extensions\Code;
use App\Common\Extensions\Common;
use App\Common\Extensions\RequestRule;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    use Common, RequestRule;

    /**
     * 本类实例 单例
     * @var null
     */
    private static $_instances = null;

    /**
     * 返回数据
     * @var array
     */
    protected static $response = [
        'code' => Code::SUCCESS,
        'msg'  => "",
        'data' => [],
    ];

    /**
     * 如果有分页，需加上此方法接收分页参数
     *
     * @return array
     */
    protected static function limitParam()
    {
        return self::getInstance()->validate(...[
            request(),
            self::getInstance()->pageLimitRule
        ]);
    }

    /**
     * 系统验证规则 参数获取
     *
     * @param string $name
     * @return array
     */
    protected static function getValidateParam(string $name)
    {
        if (empty($name)) {
            exit(self::getInstance()->responseJson(trans("validation.paramError")));
        }

        if (empty(self::getInstance()->{$name . 'Rule'})) {
            return request()->all();
        }

        return self::getInstance()->validate(...[
            request(),
            self::getInstance()->{$name . 'Rule'}
        ]);
    }

    /**
     * 统一数据返回
     *
     * @param $args
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson(...$args)
    {
        foreach ($args as $arg) {
            if (is_int($arg)) {
                self::$response['code'] = $arg;
            } elseif (is_string($arg)) {
                self::$response['msg'] = $arg;
            } else {
                self::$response['data'] = $arg;
            }
        }

        if (empty(self::$response['msg'])) {
            self::$response['msg'] = $this->translateInfo(self::$response['code']);
        }

        return response()->json(self::$response);
    }

    /**
     * 统一视图返回
     *
     * @param string|null $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function responseView(string $view = null, array $data = [])
    {
        $config = [];

        /*
         * 友情链接
         */
        Link::_destroy();
        Link::$where     = ['state' => Code::ENABLED_STATUS];
        $config['links'] = Link::getList();
        /*
         * 关于我
         */
        $config['about'] = About::getOne();
        About::_destroy();
        if ($config['about']->weChatQR) {
            $config['about']->weChatQR = self::uploadImageUrl($config['about']->weChatQR);
        }

        return view($view, $data, $config);
    }

    /**
     * 获取此类单例
     *
     * @return PublicController|null
     */
    protected static function getInstance()
    {
        if (!empty(self::$_instances)) {
            return self::$_instances;
        }

        return self::$_instances = new self();
    }
}