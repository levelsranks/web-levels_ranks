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
use pdo;

class Db {

    /**
     * @var array
     */
    private $options            = array();

    /**
     * @var array
     */
    private $db                 = array();

    /**
     * @var array
     */
    private $dns                = array();

    /**
     * @var array
     */
    protected $pdo              = array();

    /**
     * @var array
     */
    public    $db_data          = array();

    /**
     * @var array
     */
    private   $table_count_for;

    /**
     * @var array
     */
    public    $user_count;

    /**
     * @var array
     */
    public    $db_count;

    /**
     * @var array
     */
    public    $table_count;

    /**
     * @var array
     */
    public    $mod_name;

    /**
     * Организация работы вэб-приложения с базой данных.
     */
    public function __construct() {

        # Получение настроек с модами, пользователями, базами данных и таблицами.
        ! file_exists ( SESSIONS . '/db.php' ) && header( 'Location: ' . get_url(2) . 'app/page/custom/install/index.php');

        $this->db = require SESSIONS . '/db.php';

        // PDO Условия.
        $this->options = [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY
        ];

        # Подсчёт -> Количество модов.
        $this->mod_count = sizeof( $this->db );

        # Цикл -> Количество модов.
        for ( $m = 0; $m < $this->mod_count; $m++ ) {

            /*
             * $m - Номер -> Модуль.
             */

            # Получаем название определенного мода.
            $this->mod_name[] = array_keys( $this->db )[ $m ];

            # Подсчёт -> Количество пользователей определенного мода.
            $this->user_count[ $this->mod_name[ $m ] ] = sizeof( $this->db[ $this->mod_name[ $m ] ] );

            # Цикл -> Количество пользователей.
            for ( $u = 0; $u < $this->user_count[ $this->mod_name[ $m ] ]; $u++ ) {

                /*
                 * $u - Номер Пользователя.
                 */

                # Подсчёт -> Количество баз данных определенного пользователя.
                $this->db_count[ $this->mod_name[ $m ] ][ $u ] = sizeof( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'] );

                # Цикл -> Количество баз данных.
                for ( $d = 0; $d < $this->db_count[ $this->mod_name[ $m ] ][ $u ]; $d++ ) {

                /*
                 * $d - Номер Базы данных.
                 */

                // Сигнатура DNS.
                $this->dns[ $this->mod_name[ $m ] ][ $u ][ $d ] = 'mysql:host=' . $this->db[ $this->mod_name[ $m ] ][ $u ]["HOST"] . ';port=3306;dbname=' . $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['DB'] . ';charset=utf8';

                // Создаём подключение по PDO для определенной базы данных.
                $this->pdo[ $this->mod_name[ $m ] ][ $u ][ $d ] = new PDO( $this->dns[ $this->mod_name[ $m ] ][ $u ][ $d ], $this->db[ $this->mod_name[ $m ] ][ $u ]['USER'], $this->db[ $this->mod_name[ $m ] ][ $u ]['PASS'], $this->options );

                $this->table_count_for[ $this->mod_name[ $m ] ] = sizeof( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'] );

                // Циклом перебираем все таблицы которые описаны в файле настроек баз данных.
                for ( $t = 0; $t < $this->table_count_for[ $this->mod_name[ $m ] ]; $t++ ) {

                    /*
                     * $t - Номер таблицы.
                     */

                    $rank_pack = empty( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'] ) ? false : $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'];

                    // Создаём массив с описанием таблиц.
                    $this->db_data[ $this->mod_name[ $m ] ][] = [
                        'USER_ID' => $u,
                        'USER' => $this->db[ $this->mod_name[ $m ] ][ $u ]['USER'],
                        'DB' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['DB'],
                        'DB_num' => $d,
                        'Table' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['table'],
                        'name' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['name'],
                        'mod' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['mod'],
                        'steam' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['steam'],
                        'ranks_pack' => $rank_pack
                    ];
                }

            }

            }

            $this->table_count[ $this->mod_name[ $m ] ] = sizeof( $this->db_data[ $this->mod_name[ $m ] ] );
        }
    }

    /**
     * Шаблон запроса отдающий массив с индексированными именами столбцов.
     *
     * @param string $mod           Навание мода.
     * @param int $user_id          Номер пользователя.
     * @param int $db_id            Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function query($mod, $user_id = 0, $db_id = 0, $sql ) {
        return $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query( $sql )->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив с индексированными номерами столбцов.
     *
     * @param string $mod           Навание мода.
     * @param int $user_id          Номер пользователя.
     * @param int $db_id            Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function queryNum( $mod, $user_id = 0, $db_id = 0, $sql ) {
        return $this->pdo[ $mod ][ (int) $user_id ][ $db_id ]->query( $sql )->fetch( PDO::FETCH_NUM );
    }

    /**
     * Шаблон запроса отдающий массив со всеми строками.
     *
     * @param string $mod           Навание мода.
     * @param int $user_id          Номер пользователя.
     * @param int $db_id        Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function queryAll( $mod, $user_id = 0, $db_id = 0, $sql ) {
        return $this->pdo[ $mod ][ (int) $user_id ][ $db_id ]->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
    }

    /**
     * Запрос проверяющий существование столбика в той или иной таблице.
     *
     * @param string $mod          	Навание мода.
     * @param int $user_id          Номер пользователя.
     * @param int $db_id        	Номер подключенной базы данных.
     * @param string $tablename    	Название таблицы.
     * @param string $column    	Название столбика который нужно проверить.
     *
     * @return int                 Возвращает результат проверки.
     */
    public function mysql_column_search( $mod, $user_id = 0, $db_id = 0, $tablename, $column ) {
        return in_array( $column, $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query('SHOW COLUMNS from ' . $tablename . ' ')->fetchAll( PDO::FETCH_COLUMN ) );
    }

    /**
     * Запрос проверяющий существование таблицы в той или иной базе данных.
     *
     * @param string $mod          Навание мода.
     * @param int $user_id          Номер пользователя.
     * @param int $db_id        Номер подключенной базы данных.
     * @param string $tablename    Название таблицы которую нужно проверить проверки
     *
     * @return int                 Возвращает результат проверки.
     */
    public function mysql_table_search( $mod, $user_id = 0, $db_id = 0, $tablename ) {
        return ! empty( $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query("SHOW TABLES like '$tablename'")->fetchAll( PDO::FETCH_NUM )[0] ) ? true : false;
    }

    /**
     * "Разрыв соединения с базой данных".
     */
    public function __destruct() {
        unset( $this->dns );
        unset( $this->pdo );
    }
}