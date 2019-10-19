<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;
use mysqli;

class Mysqli_slim {

    /**
     * @var array
     */
    protected $mysqli = [];

    /**
     * @var bool
     */
    public    $connect_stable = false;

    public function __construct( $mysqli = [] ) {

        $this->mysqli = $mysqli;

        $this->connection();
    }

    protected function connection() {
        $this->connect = new mysqli( $this->mysqli[0], $this->mysqli[1], $this->mysqli[2], $this->mysqli[3], $this->mysqli[4] );
        $this->connect_stable =  empty( $this->connect->connect_errno ) ? true : false;
    }

    protected function query( $sql ) {
        $result = empty( $this->connect ) ? false : $this->connect->query( $sql );
        return empty( $result ) ? false : $result->fetch_assoc();
    }
}