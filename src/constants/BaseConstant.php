<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      基础静态属性类
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\constants;


class BaseConstant
{
    const STATE_OK = 1;                 //状态：1启用
    const STATE_BAN = 2;                //状态：2禁用

    const AUDITED_WAIT = 1;             //审核状态：1待审核
    const AUDITED_APPROVED = 2;         //审核状态：2审核通过
    const AUDITED_FAILED = 3;           //审核状态：3审核不通过
}