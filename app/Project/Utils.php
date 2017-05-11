<?php

namespace App\Project;

class Utils {

    public static function isRegistered() {
        return Auth::check() && Auth::user()->is_registered;
    }

    public static function isConfirmed() {
        return Auth::check() && Auth::user()->is_confirmed;
    }

    /**
     * Are we the cloud version of project or in dev enviornment?
     *
     * @return bool
     */
    public static function isProject() {
        return self::isProjectCloud() || self::isProjectDev();
    }

    /**
     * Are we the cloud version of Project?
     *
     * @return bool
     */
    public static function isProjectCloud() {
        return isset($_ENV['PROJECT_CLOUD']) && $_ENV['PROJECT_CLOUD'] == 'true';
    }

    /**
     * Are we in a dev enviornment?
     *
     * @return bool
     */
    public static function isProjectDev() {
        return isset($_ENV['PROJECT_DEV']) && $_ENV['PROJECT_DEV'] == 'true';
    }

    public static function isDownForMaintenance() {
        return file_exists(storage_path() . '/framework/down');
    }

}
