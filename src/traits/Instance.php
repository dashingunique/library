<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      实例类
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\traits;


trait Instance
{
    /**
     * 单例模式申明
     * instances
     * @var array
     */
    private static $instances;

    /**
     *获取相对应的单例
     * get instance
     * @param mixed $param
     * @return static
     */
    public static function instance(...$param)
    {
        $className = get_called_class();

        if (empty(self::$instances[$className])) {
            self::$instances[$className] = new static($param);
        }

        return self::$instances[$className];
    }
}