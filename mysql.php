<?php
//////////////////////////////////////////////////////////////////////
// mysql.php
//
// @usage
//
//     1. Load this file.
//
//         --------------------------------------------------
//         require_once('mysql.php');
//         use noknow\lib\db\mysql;
//         --------------------------------------------------
//
//     2. Initialize the MySQL class.
//
//         --------------------------------------------------
//         $mysql = new mysql\MySQL();
//         --------------------------------------------------
//
//     3. Now, you can use it!!
//
//         3-A. Here is an example variable.
//
//             --------------------------------------------------
//             $dbName = 'database_name';
//             $dbUser = 'db_user';
//             $dbPass = 'db_password'
//             --------------------------------------------------
//
//
//         3-1. When creating a PDO instance by a hostname.
//
//             --------------------------------------------------
//             $host = 'localhost';
//             $port = 3306;
//             $dsn = $mysql->GenDsnByHost($host, $port, $dbName);
//             $err = $mysql->Init($dsn, $dbUser, $dbPass);
//             if(!is_null($err)) {
//                 // Error handling.
//             }
//             --------------------------------------------------
//
//         3-2. When creating a PDO instance by a unix socket.
//
//             --------------------------------------------------
//             $unix = '/var/run/mysql/mysql.sock';
//             $dsn = $mysql->GenDsnByHost($unix, $dbName);
//             $err = $mysql->Init($dsn, $dbUser, $dbPass);
//             if(!is_null($err)) {
//                 // Error handling.
//             }
//             --------------------------------------------------
//
//
// MIT License
//
// Copyright (c) 2019 noknow.info
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
// INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
// PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
// OR THE USE OR OTHER DEALINGS IN THE SOFTW//ARE.
//////////////////////////////////////////////////////////////////////

namespace noknow\lib\db\mysql;

use PDO;

class MySQL {

    //////////////////////////////////////////////////////////////////////
    // Properties
    //////////////////////////////////////////////////////////////////////
    const CHARASET_UTF8 = 'utf8';
    const CHARASET_UTF8MB4 = 'utf8mb4';
    private $version;
    private $dbh;


    //////////////////////////////////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////////////////////////////////
    public function __construct() {
        $this->version = phpversion();
    }


    //////////////////////////////////////////////////////////////////////
    // Initialize database.
    //////////////////////////////////////////////////////////////////////
    public function Init(string $dsn, string $dbUser, string $dbPass, array $options = NULL): ?string {
        try {
            $this->dbh = new PDO($dsn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            return 'PDOException: ' . $e->getMessage();
        }
        return NULL;
    }


    //////////////////////////////////////////////////////////////////////
    // Get a db connection.
    //////////////////////////////////////////////////////////////////////
    public function Conn(): ?object {
        return $this->dbh;
    }


    //////////////////////////////////////////////////////////////////////
    // Generate a data source name by a host name.
    //////////////////////////////////////////////////////////////////////
    public function GenDsnByHost(string $dbHost, int $dbPort, string $dbName, string $charset = self::CHARASET_UTF8MB4): string {
        return 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $dbName . ';charset=' . $charset;
    }


    //////////////////////////////////////////////////////////////////////
    // Generate a data source name by a unix socket.
    //////////////////////////////////////////////////////////////////////
    public function GenDsnByUnix(string $dbUnix, string $dbName, string $charset = self::CHARASET_UTF8MB4): string {
        return 'mysql:=unix_socket' . $dbUnix . ';dbname=' . $dbName . ';charset=' . $charset;
    }


    //////////////////////////////////////////////////////////////////////
    // Generate a db driver options.
    //////////////////////////////////////////////////////////////////////
    public function GenOptions(): array {
        return array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );
    }

}
