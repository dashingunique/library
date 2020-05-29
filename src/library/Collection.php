<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 数据集管理类
 * +----------------------------------------------------------------------
 */

namespace dashing\library;

use think\helper\Arr;
use stdClass;

class Collection extends \think\Collection
{
    /**
     * 获取一个或从数组随机值指定的数量
     * @param  int|null  $number
     * @return $this|array|mixed
     */
    public function random(int $number = 0)
    {
        if (empty($number)) {
            return Arr::random($this->items);
        }
        return new static(Arr::random($this->items, $number));
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function useAsCallable($value)
    {
        return ! is_string($value) && is_callable($value);
    }

    /**
     * Determine if an item exists in the collection.
     *
     * @param  mixed  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return bool
     */
    public function contains($key, $operator = null, $value = null)
    {
        if (func_num_args() === 1) {
            if ($this->useAsCallable($key)) {
                $placeholder = new stdClass;

                return $this->first($key, $placeholder) !== $placeholder;
            }

            return in_array($key, $this->items);
        }

        return $this->contains($this->where(...func_get_args()));
    }
}