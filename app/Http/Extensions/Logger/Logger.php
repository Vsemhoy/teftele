<?php
namespace App\Http\Extensions\Logger;

use App\Http\Applications\Admin\ApplicationsAdminDb as AppDB;
use App\Http\Controllers\Base\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Logger
{
    /// SECTIONS:
    const SECTION_APPS = 0;
    const SECTION_APP_ARTICLES = 1;
    const SECTION_APP_BROCHURES = 3;
    const SECTION_APP_MANUALS = 2;
    const SECTION_APP_VERSIONS = 5;
    const SECTION_APP_FILES = 6;
    const SECTION_APP_MEDIA = 7;
    const SECTION_APP_APPCALLBACKS = 8;
    const SECTION_APP_UPDATEMESSAGES = 9;
    const SECTION_STF_BROSPEAKERS = 10;
    const SECTION_STF_PATTERNS = 11;



    const SECTION_ADMINS = 10;
    const SECTION_USERS = 11;


    /// ACTIONS:
    const ACTION_CREATE = 1;
    const ACTION_UPDATE = 2;
    const ACTION_DISABLE = 3;
    const ACTION_ENABLE = 4;
    const ACTION_DELETE = 5;
    const ACTION_READ = 6;
    const ACTION_USER_REGISTER = 7;
    const ACTION_USER_ACTIVATE = 8;
    const ACTION_USER_SELFACTIVATE = 9;
    const ACTION_USER_LOGIN = 10;
    const ACTION_USER_UPDATE = 11;
    const ACTION_USER_LOGOUT = 12;
    const ACTION_BAN_USER = 13;
    const ACTION_ADMIN_REGISTER = 14;
    const ACTION_ADMIN_ACTIVATE = 15;
    const ACTION_ADMIN_SELFACTIVATE = 16;
    const ACTION_ADMIN_LOGIN = 17;
    const ACTION_ADMIN_UPDATE = 18;
    const ACTION_ADMIN_LOGOUT = 19;
    const ACTION_REMOVE_IMAGE = 20;
    const ACTION_UPLOAD_IMAGE = 21;
    const ACTION_SET_COVER = 22;

    private const DB_EXTENSION = ".sqlite";
    // SAVE ADMIN ACTIONS Within the admin side
    private const ADMINDB = "admin_logs";
    // SAVE USER ACTIONS Within the public side
    private const USERDB = "user_logs";
    // SAVE USER ACTIONS Within the public side
    private const APIDB = "api_logs";

    private const LOGPATH = "storage/components/com_logger/";

    public $year;
    public $adminLogsDir;
    public $userLogsDir;
    public $apiLogsDir;

    public function __construct()
    {
        $this->year = $this->GetCurrentYear();
        $this->adminLogsDir = $this->GetAdminLogFolderPath();
        $this->userLogsDir = $this->GetUserLogFolderPath();
        $this->apiLogsDir = $this->GetApiLogFolderPath();
    }

    public function GetCurrentYear()
    {
        $year = date("Y", time());
        return $year;
    }

    public function GetAdminLogFolderPath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . self::LOGPATH . self::ADMINDB . DIRECTORY_SEPARATOR;
    }
    public function GetUserLogFolderPath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . self::LOGPATH . self::USERDB . DIRECTORY_SEPARATOR;
    }
    public function GetApiLogFolderPath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . self::LOGPATH . self::APIDB . DIRECTORY_SEPARATOR;
    }

    public function GetAdminDatabaseList()
    {
        return scandir($this->adminLogsDir);
    }
    public function GetUserDatabaseList()
    {
        return scandir($this->adminLogsDir);
    }
    public function GetApiDatabaseList()
    {
        return scandir($this->adminLogsDir);
    }


    public function WriteAdminLog($object)
    {
        return true;
    }

    public static function writeUserLog($object)
    {
        return true;
    }
}