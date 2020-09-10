<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      构建器
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\traits;

use Closure;

trait Builder
{
    /**
     * 创建器
     * @var Closure
     */
    protected $builder;

    /**
     * 是否创建
     * @var bool
     */
    protected $built = false;

    /**
     * 使用构造器构造对象
     * @param mixed ...$param
     * @return static
     */
    public static function make(...$param)
    {
        return new static(...$param);
    }

    /**
     * 创建所需信息
     */
    public function build(): void
    {
        if ($this->built) {
            return;
        }
        $this->callBuilder();
    }

    /**
     * 调用创建者信息
     */
    public function callBuilder()
    {
        if ($this->builder && ! $this->built) {
            call_user_func($this->builder, $this);
        }
        $this->built = true;
    }
}