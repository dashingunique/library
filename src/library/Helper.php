<?php

use dashing\library\Collection;

if (!function_exists('uniqueCollection')) {
    /**
     * 从给定的值创建一个集合
     * @param  null  $value
     * @return Collection
     */
    function uniqueCollection($value = null) {
        return new Collection($value);
    }
}
