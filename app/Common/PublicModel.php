<?php

namespace App\Common;

use App\Common\Extensions\Code;
use App\Common\Extensions\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PublicModel extends Model
{
    use Common;

    /**
     * 查询字段
     * @var null
     */
    public static $field = null;

    /**
     * where 条件
     * @var array
     */
    public static $where = [];

    /**
     * 添加修改的 data 数据
     * @var array
     */
    public static $data = [];

    /**
     * 分页条件
     * @var array
     */
    public static $limit = [];

    /**
     * 分组
     * @var null
     */
    public static $groupBy = null;

    /**
     * 实时设置分库链接，用于同一模型使用多库
     * @var string
     */
    public static $connect = 'blog';

    /**
     * 使用 DB 的时候 需要设置表名
     * @var string
     */
    public static $DBTable = '';

    /**
     * 将时间转换为时间戳格式
     * @var string
     */
    /*
     * protected $dateFormat = "U";
     */

    /**
     * 用于子类使用何种数据库操作类 ORM DB 两种
     * 默认使用 ORM 需要更换时在子类中调用此方法设置
     * 子类中一旦更换，则整个类中只能使用同一种操作类
     *
     * @return string
     */
    public static function baseClientSelect()
    {
        return 'ORM';
    }

    /**
     * DB 实例
     *
     * @return mixed
     */
    public static function DBClient()
    {
        return DB::connection(static::$connect)->table(static::$DBTable);
    }

    /**
     * 获取 ORM 实例
     *
     * @return static
     */
    public static function ORMClient()
    {
        return new static();
    }

    /**
     * 获取数据库操作类实例
     *
     * @return PublicModel|mixed
     */
    private static function databaseClient()
    {
        if (strtoupper(static::baseClientSelect()) === 'DB') {
            return self::DBClient();
        }

        return self::ORMClient();
    }

    /**
     * 获取查询实例
     * 根据类属性判断是否需要查询字段和 where 条件
     *
     * @return mixed
     */
    private static function getSelectInstance()
    {
        if (self::$field) {
            $field       = self::$field;
            self::$field = null;
            if (is_array($field)) {
                return self::databaseClient()->select(...$field)->where(self::$where);
            }
            return self::databaseClient()->select($field)->where(self::$where);
        }

        return self::databaseClient()->where(self::$where);
    }

    /**
     * 获取一条数据
     *
     * @param int $id
     * @return mixed
     */
    public static function getOne(int $id = Code::EMPTY)
    {
        if ($id) {
            return self::databaseClient()->find($id);
        }
        return self::getSelectInstance()->first();
    }

    /**
     * 获取数据列表
     *
     * @param int $type
     * @return mixed
     */
    public static function getList(int $type = Code::EMPTY)
    {
        // 子类重写 调用 返回 ORM 实例
        if ($type) {
            // 含分页条件
            if (self::$limit) {
                return self::getSelectInstance()->limit(self::$limit['limit'])
                    ->offset(self::$limit['offset']);
            }

            return self::getSelectInstance();
        }

        if (self::$limit) {
            return self::getSelectInstance()->limit(self::$limit['limit'])
                ->offset(self::$limit['offset'])
                ->get();
        }

        return self::getSelectInstance()->get();
    }

    /**
     * 获取条数
     *
     * @return mixed
     */
    public static function getListCount()
    {
        return self::databaseClient()->where(self::$where)->count((new static())->primaryKey);
    }

    /**
     * 修改数据，可批量修改
     *
     * @return mixed
     */
    public static function editToData()
    {
        return self::databaseClient()->where(self::$where)->update(self::$data);
    }

    /**
     * 增加数据
     *
     * @return mixed
     */
    public static function addToData()
    {
        return self::databaseClient()->create(self::$data);
    }

    /**
     * DB 执行事务 只支持 bets 库
     *
     * @param array ...$args
     * @return bool
     */
    public static function transactionForDatabase(...$args)
    {
        DB::beginTransaction();
        try {
            foreach ($args as $arg) {
                $execute = false;
                if (empty($arg['data']['updated_at'])) {
                    $arg['data']['updated_at'] = time();
                }
                switch ($arg['type']) {
                    case 'update' : // 更新
                        $execute = DB::table($arg['table'])
                            ->where($arg['where'])
                            ->update($arg['data']);
                        break;
                    case 'insert' : // 插入
                        if (empty($arg['data']['created_at'])) {
                            $arg['data']['created_at'] = time();
                        }
                        $execute = DB::table($arg['table'])
                            ->insert($arg['data']);
                        break;
                    case 'delete' : // 删除
                        $execute = DB::table($arg['table'])
                            ->where($arg['where'])
                            ->delete();
                        break;
                    case 'increment' : // 有字段自增更新
                        $execute = DB::table($arg['table'])
                            ->where($arg['where'])
                            ->increment($arg['increment']['column'], $arg['increment']['value'], $arg['data']);
                        break;
                    case 'decrement' : // 有字段自减更新
                        $execute = DB::table($arg['table'])
                            ->where($arg['where'])
                            ->decrement($arg['decrement']['column'], $arg['decrement']['value'], $arg['data']);
                        break;
                }
                if (!$execute) {
                    DB::rollBack();
                    return false;
                    break;
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 删除数据
     *
     * @param int $id
     * @return mixed
     */
    public static function delToData(int $id = Code::EMPTY)
    {
        if ($id) {
            return self::databaseClient()->destroy($id);
        }
        return self::databaseClient()->where(self::$where)->delete();
    }

    /**
     * 获取一个字段的和
     *
     * @param $field
     * @return mixed
     */
    public static function getFieldSum($field)
    {
        return self::databaseClient()->where(self::$where)->sum($field);
    }

    /**
     * 销毁变量
     *
     * @return bool
     */
    public static function _destroy()
    {
        if (!empty($property = func_get_args())) {
            foreach ($property as $item) {
                if ($item === 'connect' || $item === 'DBTable') {
                    self::$$item = "";
                } else {
                    self::$$item = [];
                }
            }

            return true;
        }
        self::$field   = null;
        self::$where   = [];
        self::$limit   = [];
        self::$data    = [];
        self::$connect = "";
        self::$DBTable = "";

        return true;
    }

}