<?php

namespace App\Models\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as OriginalLogsActivity;

trait LogsActivity
{
    use OriginalLogsActivity;

    /**
     * Define the options for the Spatie activity log.
     * Logs all changes and only logs the changes that have been made.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
