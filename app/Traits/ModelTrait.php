<?php
namespace App\Traits;

/**
 * model traits
 */
trait ModelTrait
{
    // LOGS
    public static $logOnlyDirty = true;
    public static $logAttributes = ['*'];
    public static $submitEmptyLogs = false;
}
