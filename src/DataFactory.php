<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      时间工厂类
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library;


use Carbon\Factory;
use InvalidArgumentException;

/**
 * @see https://carbon.nesbot.com/docs/
 * @see https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Factory.php
 *
 * @method static Carbon create($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method static Carbon createFromDate($year = null, $month = null, $day = null, $tz = null)
 * @method static Carbon|false createFromFormat($format, $time, $tz = null)
 * @method static Carbon createFromTime($hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method static Carbon createFromTimeString($time, $tz = null)
 * @method static Carbon createFromTimestamp($timestamp, $tz = null)
 * @method static Carbon createFromTimestampMs($timestamp, $tz = null)
 * @method static Carbon createFromTimestampUTC($timestamp)
 * @method static Carbon createMidnightDate($year = null, $month = null, $day = null, $tz = null)
 * @method static Carbon|false createSafe($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)
 * @method static Carbon disableHumanDiffOption($humanDiffOption)
 * @method static Carbon enableHumanDiffOption($humanDiffOption)
 * @method static mixed executeWithLocale($locale, $func)
 * @method static Carbon fromSerialized($value)
 * @method static array getAvailableLocales()
 * @method static array getDays()
 * @method static int getHumanDiffOptions()
 * @method static array getIsoUnits()
 * @method static Carbon getLastErrors()
 * @method static string getLocale()
 * @method static int getMidDayAt()
 * @method static Carbon getTestNow()
 * @method static \Symfony\Component\Translation\TranslatorInterface getTranslator()
 * @method static int getWeekEndsAt()
 * @method static int getWeekStartsAt()
 * @method static array getWeekendDays()
 * @method static bool hasFormat($date, $format)
 * @method static bool hasMacro($name)
 * @method static bool hasRelativeKeywords($time)
 * @method static bool hasTestNow()
 * @method static Carbon instance($date)
 * @method static bool isImmutable()
 * @method static bool isModifiableUnit($unit)
 * @method static Carbon isMutable()
 * @method static bool isStrictModeEnabled()
 * @method static bool localeHasDiffOneDayWords($locale)
 * @method static bool localeHasDiffSyntax($locale)
 * @method static bool localeHasDiffTwoDayWords($locale)
 * @method static bool localeHasPeriodSyntax($locale)
 * @method static bool localeHasShortUnits($locale)
 * @method static void macro($name, $macro)
 * @method static Carbon|null make($var)
 * @method static Carbon maxValue()
 * @method static Carbon minValue()
 * @method static void mixin($mixin)
 * @method static Carbon now($tz = null)
 * @method static Carbon parse($time = null, $tz = null)
 * @method static string pluralUnit(string $unit)
 * @method static void resetMonthsOverflow()
 * @method static void resetToStringFormat()
 * @method static void resetYearsOverflow()
 * @method static void serializeUsing($callback)
 * @method static Carbon setHumanDiffOptions($humanDiffOptions)
 * @method static bool setLocale($locale)
 * @method static void setMidDayAt($hour)
 * @method static Carbon setTestNow($testNow = null)
 * @method static void setToStringFormat($format)
 * @method static void setTranslator(\Symfony\Component\Translation\TranslatorInterface $translator)
 * @method static Carbon setUtf8($utf8)
 * @method static void setWeekEndsAt($day)
 * @method static void setWeekStartsAt($day)
 * @method static void setWeekendDays($days)
 * @method static bool shouldOverflowMonths()
 * @method static bool shouldOverflowYears()
 * @method static string singularUnit(string $unit)
 * @method static Carbon today($tz = null)
 * @method static Carbon tomorrow($tz = null)
 * @method static void useMonthsOverflow($monthsOverflow = true)
 * @method static Carbon useStrictMode($strictModeEnabled = true)
 * @method static void useYearsOverflow($yearsOverflow = true)
 * @method static Carbon yesterday($tz = null)
 */
class DataFactory
{
    /**
     * 将用于所有创建日期的默认类
     *
     * @var string
     */
    const DEFAULT_CLASS_NAME = Carbon::class;

    /**
     * 应该创建的日期类型（类）
     *
     * @var string
     */
    protected static $dateClass;

    /**
     * 该可调用对象可用于拦截日期创建
     *
     * @var callable
     */
    protected static $callable;

    /**
     * 创建日期时应使用的Carbon工厂
     *
     * @var object
     */
    protected static $factory;

    /**
     * 在生成日期（类名，可调用或工厂）时使用给定的处理程序
     *
     * @param mixed $handler
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function use($handler)
    {
        if (is_callable($handler) && is_object($handler)) {
            return static::useCallable($handler);
        } elseif (is_string($handler)) {
            return static::useClass($handler);
        } elseif ($handler instanceof Factory) {
            return static::useFactory($handler);
        }

        throw new InvalidArgumentException('Invalid date creation handler. Please provide a class name, callable, or Carbon factory.');
    }

    /**
     * 生成日期时使用默认的日期类
     *
     * @return void
     */
    public static function useDefault()
    {
        static::$dateClass = null;
        static::$callable = null;
        static::$factory = null;
    }

    /**
     * 在每个日期创建时执行给定的可调用对象
     *
     * @param callable $callable
     * @return void
     */
    public static function useCallable(callable $callable)
    {
        static::$callable = $callable;

        static::$dateClass = null;
        static::$factory = null;
    }

    /**
     * 生成日期时使用给定的日期类型（类）
     *
     * @param string $dateClass
     * @return void
     */
    public static function useClass($dateClass)
    {
        static::$dateClass = $dateClass;

        static::$factory = null;
        static::$callable = null;
    }

    /**
     * 生成日期时使用给定的Carbon工厂
     *
     * @param object $factory
     * @return void
     */
    public static function useFactory($factory)
    {
        static::$factory = $factory;

        static::$dateClass = null;
        static::$callable = null;
    }

    /**
     * 处理动态调用以生成日期
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function __call($method, $parameters)
    {
        $defaultClassName = static::DEFAULT_CLASS_NAME;

        // 使用callable生成日期...
        if (static::$callable) {
            return call_user_func(static::$callable, $defaultClassName::$method(...$parameters));
        }

        // 使用Carbon Factory生成日期...
        if (static::$factory) {
            return static::$factory->$method(...$parameters);
        }

        $dateClass = static::$dateClass ?: $defaultClassName;

        // 检查是否可以使用公共类方法创建日期...
        if (method_exists($dateClass, $method) ||
            method_exists($dateClass, 'hasMacro') && $dateClass::hasMacro($method)) {
            return $dateClass::$method(...$parameters);
        }

        // 如果失败，请使用默认类创建日期
        $date = $defaultClassName::$method(...$parameters);

        // 如果配置的类具有“实例”方法，将尝试将日期传递到该实例中...
        if (method_exists($dateClass, 'instance')) {
            return $dateClass::instance($date);
        }

        // 否则，假设配置的类具有与DateTime兼容的构造函数...
        return new $dateClass($date->format('Y-m-d H:i:s.u'), $date->getTimezone());
    }
}