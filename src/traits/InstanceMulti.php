<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\traits;


trait InstanceMulti
{
    /**
     * instances
     * @var array
     */
    private static $traitsInstances;

    /**
     * get instance
     * @param  mixed $param
     * @return self
     */
    public static function instance(...$param)
    {
        $className = md5(get_called_class() . serialize(...$param));

        if (empty(self::$traitsInstances[$className])) {
            self::$traitsInstances[$className] = new static(...$param);
        }

        return self::$traitsInstances[$className];
    }
}