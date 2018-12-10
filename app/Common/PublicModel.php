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
     * 本类实例 单例
     * @var null
     */
    private static $_instances = null;

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
     * whereIn条件
     * @var null
     */
    public static $whereIn = [];

    /**
     * 排序
     * @var null
     */
    public static $orderBy = null;

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
//    protected $dateFormat = 'U';

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
        static::$connect = static::$connect ?: self::ORMClient()->connection;
        static::$DBTable = static::$DBTable ?: self::ORMClient()->table;
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
     * 获取原生sql编译后的sql，通过模型调用
     *
     * @param string $sql
     * @return mixed
     */
    public static function getRaw($sql = '')
    {
        return DB::raw($sql);
    }

    /**
     * 获取一条数据
     * 如果id传值为0时必须带有where条件
     * 否则将会查出错误数据
     *
     * @param int $id
     * @return mixed
     */
    public static function getOne(int $id = Code::ZERO)
    {
        if ($id) {
            return self::databaseClient()->find($id);
        }
        if (empty(self::$where)) {
            return false;
        }
        return self::getSelectInstance()->first();
    }

    /**
     * 获取数据列表
     *
     * @param int $type
     * @return mixed
     */
    public static function getList(int $type = Code::ZERO)
    {
        // 子类重写 调用 返回 ORM 实例
        $instance = self::getSelectInstance();
        // 含whereIn
        if (self::$whereIn) {
            foreach (self::$whereIn as $column => $where) {
                $instance = $instance->whereIn($column, $where);
            }
        }
        // 含分组
        if (self::$groupBy) {
            $instance = $instance->groupBy(self::$groupBy);
        }
        // 含排序
        if (self::$orderBy) {
            if (is_array(self::$orderBy)) {
                $instance = $instance->orderBy(...self::$orderBy);
            } else {
                $instance = $instance->orderByRaw(self::$orderBy);// 原生写法
            }
        }
        // 含分页条件
        if (self::$limit) {
            $instance = $instance->limit(self::$limit['limit'])
                ->offset(self::$limit['offset']);
        }

        if ($type) {
            return $instance;
        }

        return $instance->get();
    }

    /**
     * 获取条数
     *
     * @return mixed
     */
    public static function getListCount()
    {
        $instance = self::databaseClient();
        // 含whereIn
        if (self::$whereIn) {
            foreach (self::$whereIn as $column => $where) {
                $instance = $instance->whereIn($column, $where);
            }
        }
        return $instance->where(self::$where)->count(self::ORMClient()->primaryKey);
    }

    /**
     * 返回数据集合与数据条数，list($data, $count)接收
     *
     * @return array
     */
    public static function getDataAndCount()
    {
        return [
            self::getList(),
            self::getListCount(),
        ];
    }

    /**
     * 修改数据，可批量修改
     *
     * @param int $whereIn 必须确认为whereIn的时候才可以执行whereIn条件
     * @return mixed
     */
    public static function editToData(int $whereIn = Code::ZERO)
    {
        self::$field = null;
        $instance    = self::getSelectInstance();
        if (self::$whereIn && $whereIn === Code::ONE) {
            foreach (self::$whereIn as $column => $where) {
                $instance = $instance->whereIn($column, $where);
            }
        }
        return $instance->update(self::$data);
    }

    /**
     * 增加一条数据
     *
     * @return mixed
     */
    public static function addToData()
    {
        return self::databaseClient()->create(self::$data);
    }

    /**
     * 批量增加数据
     *
     * @param array $data
     * @return mixed
     */
    public static function insertToData(array $data = [])
    {
        if (empty($data)) {
            return self::databaseClient()->insert(self::$data);
        }
        return self::databaseClient()->insert($data);
    }

    /**
     * DB 执行事务 默认 blog 库
     * 修改 数据库链接 需在调用的模型中定义 $connect
     *
     * @param array ...$args
     * @return bool
     * @throws \Exception
     */
    public static function transactionForDatabase(...$args)
    {
        $DB = DB::connection(static::$connect);
        $DB->beginTransaction();
        try {
            foreach ($args as $arg) {
                $execute = false;
                if (empty($arg['data']['updated_at'])) {
                    $arg['data']['updated_at'] = time();
                }
                switch ($arg['type']) {
                    case 'update' : // 更新
                        $execute = $DB->table($arg['table'])
                            ->where($arg['where'])
                            ->update($arg['data']);
                        break;
                    case 'insert' : // 插入
                        if (empty($arg['data']['created_at'])) {
                            $arg['data']['created_at'] = time();
                        }
                        $execute = $DB->table($arg['table'])
                            ->insert($arg['data']);
                        break;
                    case 'delete' : // 删除
                        $execute = $DB->table($arg['table'])
                            ->where($arg['where'])
                            ->delete();
                        break;
                    case 'increment' : // 有字段自增更新
                        $execute = $DB->table($arg['table'])
                            ->where($arg['where'])
                            ->increment($arg['increment']['column'], $arg['increment']['value'], $arg['data']);
                        break;
                    case 'decrement' : // 有字段自减更新
                        $execute = $DB->table($arg['table'])
                            ->where($arg['where'])
                            ->decrement($arg['decrement']['column'], $arg['decrement']['value'], $arg['data']);
                        $result  = $DB->table($arg['table'])->select($arg['decrement']['column'])->where($arg['where'])->first();
                        if ($result->{$arg['decrement']['column']} < 0.00) {
                            $execute = false;
                        }
                        unset($result);
                        break;
                }
                if (!$execute) {
                    $DB->rollBack();
                    return false;
                    break;
                }
            }
            $DB->commit();
            return true;
        } catch (\Exception $e) {
            $DB->rollBack();
            return false;
        }
    }

    /**
     * 删除数据
     *
     * @param int|array $id
     * @return mixed
     * @throws \Exception
     */
    public static function delToData(int $id = Code::ZERO)
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
        $instance = self::databaseClient()->where(self::$where);
        // 含whereIn
        if (self::$whereIn) {
            foreach (self::$whereIn as $column => $where) {
                $instance = $instance->whereIn($column, $where);
            }
        }
        if (self::$limit) {
            return $instance->limit(self::$limit['limit'])
                ->offset(self::$limit['offset'])->sum($field);
        }
        return $instance->sum($field);
    }

    /**
     * 某一个字段自增
     *
     * @param $field
     * @param $num
     * @return mixed
     */
    public static function incrementFiled($field, int $num = Code::ONE)
    {
        return self::databaseClient()->where(self::$where)->increment($field, $num);
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
                    self::$$item = '';
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
        self::$whereIn = [];
        self::$groupBy = null;
        self::$orderBy = null;
        self::$connect = '';
        self::$DBTable = '';

        return true;
    }

    /**
     * 对象转数组
     *
     * @param $object
     * @return mixed
     */
    public static function objectToArray($object)
    {
        //先编码成json字符串，再解码成数组
        return json_decode(json_encode($object), true);
    }

    /**
     * 获取此类单例
     *
     * @return PublicModel|null
     */
    public static function getInstance()
    {
        if (!empty(self::$_instances)) {
            return self::$_instances;
        }

        return self::$_instances = new static();
    }

}
