<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      解析数据
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */

namespace dashingUnique\library\contract;


interface RenderAble
{
    /**
     * 解析数据
     * @return mixed
     */
    public function render();
}