<?php
namespace Larakit;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class Webconfig {
    protected static $values   = null;
    protected static $group    = null;
    public static    $defaults = [];
    protected static $groups   = [];
    const TYPE_TEXT     = 'text';
    const TYPE_INT      = 'int';
    const TYPE_FLOAT    = 'float';
    const TYPE_BOOL     = 'bool';
    const TYPE_DATE     = 'date';
    const TYPE_DATETIME = 'datetime';
    const TYPE_TIME     = 'time';
    const TYPE_ARRAY    = 'array';

    protected static function toType($type, $value) {
        switch ($type) {
            case self::TYPE_INT:
                $value = (int)$value;
                break;
            case self::TYPE_FLOAT:
                $value = (float)$value;
                break;
            case self::TYPE_BOOL:
                $value = (bool)$value;
                break;
            case self::TYPE_DATE:
                $value = Carbon::parse($value)
                               ->format('Y-m-d');
                break;
            case self::TYPE_DATETIME:
                $value = Carbon::parse($value)
                               ->format('Y-m-d H:i:s');
                break;
            case self::TYPE_TIME:
                $value = Carbon::parse($value)
                               ->format('H:i:s');
                break;
            case self::TYPE_ARRAY:
                $value = (array)$value;
                break;
            default:
                $value = $value;
                break;
        }

        return $value;
    }

    static function getValues() {
        self::init();
        return self::$values;
    }

    /**
     * Регистрация дефолтного значения, производится в модулях
     * Затем список зарегистрированных значений выводится для исправления
     *
     * @param $code
     * @param $type
     * @param $value
     */
    static function makeItem($code, $group) {
        return new WebconfigItem($code, $group);
    }

    protected static function _default($code, $key) {
        $key = \Str::snake(mb_substr($key, 10));
        return isset(self::$defaults[$code][$key])?self::$defaults[$code][$key]: null;
    }

    static function getDefaultType($code) {
        return self::_default($code, __FUNCTION__);
    }

    static function getDefaultValue($code) {
        return self::_default($code, __FUNCTION__);
    }


    static function set($code, $value) {
        $type  = self::getDefaultType($code);
        $value = self::toType($type, $value);
        switch ($type) {
            case self::TYPE_INT:
            case self::TYPE_FLOAT:
            case self::TYPE_BOOL:
                $field = 'value_digit';
                break;
            case self::TYPE_DATE:
            case self::TYPE_DATETIME:
            case self::TYPE_TIME:
                $field = 'value_date';
                break;
            default:
                $field = 'value_text';
                break;
        }
        if (self::TYPE_ARRAY == $type) {
            $value = serialize($value);
        }
        if (self::TYPE_TIME == $type) {
            $value = '0000-00-00 ' . $value;
        }
        $model           = \Larakit\Model\Webconfig::firstOrCreate(
            [
                'code' => $code
            ]
        );
        $model->{$field} = $value;
        $model->save();
    }

    /**
     * Получение значения
     *
     * @param      $code
     * @param null $default
     *
     * @return mixed
     */
    static function get($code) {
        self::init();
        $default = self::getDefaultValue($code);
        return isset(self::$values[$code]) ? self::$values[$code] : $default;
    }

    /**
     * Инициализация
     */
    static protected function init() {
        if (!is_null(self::$values)) {
            return;
        }
        $data         = \Larakit\Model\Webconfig::all();
        self::$values = [];
        foreach (self::$defaults as $code => $v) {
            self::$values[$code] = self::getDefaultValue($code);
        }
        foreach ($data as $row) {
            switch (self::getDefaultType($row->code)) {
                case self::TYPE_INT:
                    $value = (int)$row->value_digit;
                    break;
                case self::TYPE_FLOAT:
                    $value = (float)$row->value_digit;
                    break;
                case self::TYPE_BOOL:
                    $value = (bool)$row->value_digit;
                    break;
                case self::TYPE_DATE:
                    $value = Carbon::parse($row->value_date)
                                   ->format('Y-m-d');
                    break;
                case self::TYPE_DATETIME:
                    $value = Carbon::parse($row->value_date)
                                   ->format('Y-m-d H:i:s');
                    break;
                case self::TYPE_TIME:
                    $value = Carbon::parse($row->value_date)
                                   ->format('H:i:s');
                    break;
                case self::TYPE_ARRAY:
                    $value = $row->value_text ? unserialize($row->value_text) : [];
                    break;
                default:
                    $value = $row->value_text;
                    break;
            }
            self::$values[$row->code] = $value;
        }
    }

}
