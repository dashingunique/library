<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      数组拓展
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library;

use ArrayAccess;
use InvalidArgumentException;

class Arr
{
    /**
     * 判断给定的值是否是数组
     *
     * @param mixed $value
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * 如果不存在，则使用“点”符号将元素添加到数组中。
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     * @return array
     */
    public static function add($array, $key, $value)
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * 将一个数组的数组折叠为一个数组。
     *
     * @param array $array
     * @return array
     */
    public static function collapse($array)
    {
        $results = [];

        foreach ($array as $values) {
            if ($values instanceof Collection) {
                $values = $values->all();
            } elseif (!is_array($values)) {
                continue;
            }

            $results = array_merge($results, $values);
        }

        return $results;
    }

    /**
     * 交叉连接给定的数组，返回所有可能的排列。
     *
     * @param array ...$arrays
     * @return array
     */
    public static function crossJoin(...$arrays)
    {
        $results = [[]];

        foreach ($arrays as $index => $array) {
            $append = [];

            foreach ($results as $product) {
                foreach ($array as $item) {
                    $product[$index] = $item;

                    $append[] = $product;
                }
            }

            $results = $append;
        }

        return $results;
    }

    /**
     * 将一个数组分为两个数组：一个带有键，另一个带有值
     *
     * @param array $array
     * @return array
     */
    public static function divide($array)
    {
        return [array_keys($array), array_values($array)];
    }

    /**
     * 用点展平多维关联数组
     *
     * @param array  $array
     * @param string $prepend
     * @return array
     */
    public static function dot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    /**
     * 获取除指定键数组之外的所有给定数组
     *
     * @param array        $array
     * @param array|string $keys
     * @return array
     */
    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    /**
     * 确定给定键在提供的数组中是否存在
     *
     * @param \ArrayAccess|array $array
     * @param string|int         $key
     * @return bool
     */
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * 返回数组中的第一个元素
     *
     * @param array         $array
     * @param callable|null $callback
     * @param mixed         $default
     * @return mixed
     */
    public static function first($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) {
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return value($default);
    }

    /**
     * 返回数组中的最后一个元素
     *
     * @param array         $array
     * @param callable|null $callback
     * @param mixed         $default
     * @return mixed
     */
    public static function last($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * 将多维数组展平为单个级别
     *
     * @param array $array
     * @param int   $depth
     * @return array
     */
    public static function flatten($array, $depth = INF)
    {
        $result = [];

        foreach ($array as $item) {
            $item = $item instanceof Collection ? $item->all() : $item;

            if (!is_array($item)) {
                $result[] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge($result, static::flatten($item, $depth - 1));
            }
        }

        return $result;
    }

    /**
     * 从给定数组中删除一个或多个数组项。
     *
     * @param array        $array
     * @param array|string $keys
     * @return void
     */
    public static function forget(&$array, $keys)
    {
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // clean up before each pass
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * 从数组中获取一项。
     *
     * @param \ArrayAccess|array $array
     * @param string             $key
     * @param mixed              $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (!static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }

        return $array;
    }

    /**
     * 检查数组中是否存在一个或多个key。
     *
     * @param \ArrayAccess|array $array
     * @param string|array       $keys
     * @return bool
     */
    public static function has($array, $keys)
    {
        $keys = (array) $keys;

        if (!$array || $keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if (static::exists($array, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 确定数组是否为关联数组
     *
     * 如果数组没有以零开头的连续数字键，则该数组为“关联”数组
     *
     * @param array $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * 从给定数组中获取项的子集
     *
     * @param array        $array
     * @param array|string $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * 从数组中抽出一个值数组
     *
     * @param array             $array
     * @param string|array      $value
     * @param string|array|null $key
     * @return array
     */
    public static function pluck($array, $value, $key = null)
    {
        $results = [];

        [$value, $key] = static::explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);

            // 如果键为“ null”，则将值附加到数组并保留
            // 循环数组。否则，将使用键的值来键控数组
            // 从开发者那里收到的。然后，将返回最终的数组形式。
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = data_get($item, $key);

                if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                    $itemKey = (string) $itemKey;
                }

                $results[$itemKey] = $itemValue;
            }
        }

        return $results;
    }

    /**
     * 展开传递给“ pluck”的“值”和“键”参数。
     *
     * @param string|array      $value
     * @param string|array|null $key
     * @return array
     */
    protected static function explodePluckParameters($value, $key)
    {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    }

    /**
     * 向数组的开头插入数据
     *
     * @param array $array
     * @param mixed $value
     * @param mixed $key
     * @return array
     */
    public static function prepend($array, $value, $key = null)
    {
        if (is_null($key)) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }

        return $array;
    }

    /**
     * 从数组中获取一个值，并将其删除
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
    }

    /**
     * 从数组中获取一个或指定数量的随机值
     *
     * @param array    $array
     * @param int|null $number
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function random($array, $number = null)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            throw new InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }

    /**
     * 将数组项设置为给定值
     *
     * 如果没有为该方法提供任何键，则将替换整个数组
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     * @return array
     */
    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // 如果键不存在，将创建一个空数组
            // 来保存下一个值，够创建数组来保存最终值
            // 值在正确的深度。然后，将继续深入研究数组。
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * 随机获取给定的数组并返回结果
     *
     * @param array    $array
     * @param int|null $seed
     * @return array
     */
    public static function shuffle($array, $seed = null)
    {
        if (is_null($seed)) {
            shuffle($array);
        } else {
            srand($seed);

            usort($array, function () {
                return rand(-1, 1);
            });
        }

        return $array;
    }

    /**
     * 使用给定的回调对数组进行排序。
     *
     * @param array                $array
     * @param callable|string|null $callback
     * @return array
     */
    public static function sort($array, $callback = null)
    {
        return Collection::make($array)->sort($callback)->all();
    }

    /**
     * 通过键和值对数组进行递归排序
     *
     * @param array $array
     * @return array
     */
    public static function sortRecursive($array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = static::sortRecursive($value);
            }
        }

        if (static::isAssoc($array)) {
            ksort($array);
        } else {
            sort($array);
        }

        return $array;
    }

    /**
     * 将数组转换为查询字符串
     *
     * @param array $array
     * @return string
     */
    public static function query($array)
    {
        return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * 使用给定的回调过滤数组
     *
     * @param array    $array
     * @param callable $callback
     * @return array
     */
    public static function where($array, callable $callback)
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * 如果给定值不是数组且不为null，则将其包装为一个数组
     *
     * @param mixed $value
     * @return array
     */
    public static function wrap($value)
    {
        if (is_null($value)) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }

    /**
     * 数组分组
     * @param array $array
     * @param $key
     * @return array
     */
    public function arrayGroup(array $array, $key)   :array
    {
        $results = [];
        foreach ($array as $val) {
            if (isset($val[$key])) {
                $results[$val[$key]][] = $val;
            }
        }
        return $results;
    }
}