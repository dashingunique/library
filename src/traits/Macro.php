<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      方法、类的宏定义
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\traits;

use BadMethodCallException;
use Closure;
use ReflectionClass;
use ReflectionMethod;

trait Macro
{
    /**
     * 注册的宏定义
     *
     * @var array
     */
    protected static $macros = [];

    /**
     * 注册宏定义
     *
     * @param string $name
     * @param object|callable $macro
     * @return void
     */
    public static function macro($name, $macro)
    {
        static::$macros[$name] = $macro;
    }

    /**
     * 将另一个对象混合到类中
     *
     * @param object $mixin
     * @param bool $replace
     * @return void
     *
     * @throws \ReflectionException
     */
    public static function mixin($mixin, $replace = true)
    {
        $methods = (new ReflectionClass($mixin))->getMethods(
            ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            if ($replace || !static::hasMacro($method->name)) {
                $method->setAccessible(true);
                static::macro($method->name, $method->invoke($mixin));
            }
        }
    }

    /**
     * 验证宏方法是否定义
     *
     * @param string $name
     * @return bool
     */
    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }

    /**
     * 静态调用宏方法时启用
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array(Closure::bind($macro, null, static::class), $parameters);
        }

        return $macro(...$parameters);
    }

    /**
     * 动态处理类的调用
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $parameters);
        }

        return $macro(...$parameters);
    }
}