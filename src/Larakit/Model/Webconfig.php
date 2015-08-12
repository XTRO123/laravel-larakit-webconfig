<?php
namespace Larakit\Model;

use Larakit\Base\Model;

class Webconfig extends Model {
    protected $table = 'webconfigs';

    protected $fillable = [
        'code',
        'value_date',
        'value_text',
        'value_digit',
    ];
}