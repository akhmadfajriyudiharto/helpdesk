<?php

namespace App\Support;

use SetEnv;

/**
 * Class Setting
 * @package App\Support
 */
class Setting
{
    public static function get($key, $default = null)
    {
        if ($setting = \App\Models\Setting::find($key)) {
            return $setting->value;
        }
        return $default;
    }

    public static function setEnv($key, $value = null): void
    {
        SetEnv::setKey($key, $value);
        SetEnv::save();
    }
}
