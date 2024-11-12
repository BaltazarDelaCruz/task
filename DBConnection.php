<?php
date_default_timezone_set('Asia/Manila');

if (!is_dir(__DIR__ . '/db')) {
    mkdir(__DIR__ . '/db');
}

if (!defined('db_file')) {
    define('db_file', __DIR__ . '/db/DBConnection.db');
}

function my_udf_md5($string) {
    return md5($string);
}

class DBConnection extends SQLite3 {
    protected $db;

    function __construct() {
        $this->open(db_file);
        $this->createFunction('md5', 'my_udf_md5');
        $this->exec("PRAGMA foreign_keys = ON;");

        $this->exec("CREATE TABLE IF NOT EXISTS user (
            user_id INTEGER PRIMARY KEY AUTOINCREMENT,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Create the 'task_list' table if it doesn't exist
        $this->exec("CREATE TABLE IF NOT EXISTS `task_list` (
            `task_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `title` VARCHAR(100) NOT NULL,
            `description` VARCHAR(100) NOT NULL,
            `status` VARCHAR(100) NOT NULL,
            `due_date` DATE NOT NULL,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(`task_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE
        )");

        // Create the 'user_list' table if it doesn't exist
        $this->exec("CREATE TABLE IF NOT EXISTS `user_list` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `firstname` VARCHAR(100) NOT NULL,
            `lastname` VARCHAR(100) NOT NULL,
            `username` VARCHAR(100) NOT NULL,
            `password` VARCHAR(100) NOT NULL,
            `status` TEXT NOT NULL DEFAULT '1',
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    function isMobileDevice() {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }

    function __destruct() {
        $this->close();
    }
}

$conn = new DBConnection();
?>
