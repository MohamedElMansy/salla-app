<?php

namespace App\Services\Setting;

use App\Enums\SettingKeysEnum;
use App\Models\Setting;

class SettingService
{
    public function findByKey(SettingKeysEnum $settingKeysEnum)
    {
        return Setting::where('key', '=', $settingKeysEnum->value)->first();
    }

    public function createSetting(string $name,SettingKeysEnum $key,$value,$extra)
    {
        return Setting::updateOrCreate(
            [
                'key' => $key->value
            ],
            [
                'name'   => $name
                ,'value' => $value
                ,'extra' => $extra
            ]
        );
    }
}
