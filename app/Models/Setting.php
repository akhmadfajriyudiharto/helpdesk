<?php

namespace App\Models;

use Base;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Setting
 *
 * @property mixed $key
 * @property string|null $value
 * @property int $is_env
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereIsEnv($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereValue($value)
 * @mixin Eloquent
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_env',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        /*
         * Register a created model event with the dispatcher.
         *
         * @param \Closure|string $callback
         * @return void
         */
        self::creating(static function ($model) {
            if ($model->is_env) {
                \App\Support\Setting::setEnv(strtoupper($model->key), $model->value);
            }
        });

        /*
         * Register an updated model event with the dispatcher.
         *
         * @param \Closure|string $callback
         * @return void
         */
        self::updating(static function ($model) {
            if ($model->is_env) {
                \App\Support\Setting::setEnv(strtoupper($model->key), $model->value);
            }
        });
    }

    public function decodeValue()
    {
        switch ($this->key) {
            case 'app_https':
            case 'recaptcha_enabled':
            case 'app_user_registration':
                return (bool) $this->value;
            case 'app_icon':
                return [
                    'file' => null,
                    'text' => $this->value,
                    'preview' => Base::icon(),
                ];
            case 'app_background':
                return [
                    'file' => null,
                    'text' => $this->value,
                    'preview' => Base::background(),
                ];
            default:
                return $this->value;
        }
    }

    public static function getDecoded($key)
    {
        $value = self::find($key);
        if (!empty($value->key)) {
            return $value->decodeValue();
        }
        return null;
    }
}
