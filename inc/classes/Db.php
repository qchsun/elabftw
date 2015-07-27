<?php
/**
 * \Elabftw\Elabftw\Db
 *
 * @author Nicolas CARPi <nicolas.carpi@curie.fr>
 * @copyright 2012 Nicolas CARPi
 * @see http://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */
namespace Elabftw\Elabftw;

use \PDO;
use \Exception;

/**
 * Connect to the database
 */
class Db
{
    /** our connection */
    protected static $connection;

    /**
     * Connect to the MySQL database
     *
     * @return object $connection The PDO object
     */
    public function connect()
    {
        if (!isset(self::$connection)) {
            $pdo_options = array();
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $pdo_options[PDO::ATTR_PERSISTENT] = true;
            self::$connection = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $pdo_options);
        }

        if (self::$connection === false) {
            throw new Exception('Cannot connect to database!');
        }

        return self::$connection;
    }
}
