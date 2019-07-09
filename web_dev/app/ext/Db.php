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

        // Получение настроек с модами, пользователями, базами данных и таблицами.
        ! file_exists ( SESSIONS . '/db.php' ) && header( 'Location: ' . get_url(2) . 'app/page/custom/install/index.php');

        $this->db = require SESSIONS . '/db.php';

        // PDO Условия.
        $this->options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        // Подсчёт количества модов.
        $this->mod_count = sizeof( $this->db );

        // Циклом подключаемся ко всем возможным базам данны.
        for ( $i = 0; $i < $this->mod_count; $i++ ) {

            // Получаем название мода.
            $this->mod_name[] = array_keys( $this->db )[ $i ];

            // Подсчёт количества баз данных подключенных из под одного пользователя.
            $this->db_count[ $this->mod_name[ $i ] ] = sizeof( $this->db[ $this->mod_name[ $i ] ][0]['DB'] );

            // Циклом подключаемся ко всем возможным базам данны.
            for ( $i2 = 0; $i2 < $this->db_count[ $this->mod_name[ $i ] ]; $i2++ ) {

                // Описываем сигнатуру DNS для PDO.
                $this->dns[ $this->mod_name[ $i ] ][ $i2 ] = 'mysql:host=' . $this->db[ $this->mod_name[ $i ] ][0]["HOST"] . ';port=3306;dbname=' . $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['DB'] . ';charset=utf8';

                // Создаём подключение по PDO для определенной базы данных.
                $this->pdo[ $this->mod_name[ $i ] ][ $i2 ] = new PDO( $this->dns[ $this->mod_name[ $i ] ][ $i2 ], $this->db[ $this->mod_name[ $i ] ][0]['USER'], $this->db[ $this->mod_name[ $i ] ][0]['PASS'], $this->options );

                $this->table_count_for[ $this->mod_name[ $i ] ] = sizeof( $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['Prefix'] );

                // Циклом перебираем все таблицы которые описаны в файле настроек баз данных.
                for ( $i3 = 0; $i3 < $this->table_count_for[ $this->mod_name[ $i ] ]; $i3++ ) {
                    // Создаём массив с описанием таблиц.
                    $this->db_data[ $this->mod_name[ $i ] ][] = [
                        'DB' => $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['DB'],
                        'DB_num' => $i2,
                        'Table' => $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['Prefix'][ $i3 ]['table'],
                        'name' => $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['Prefix'][ $i3 ]['name'],
                        'mod' => $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['Prefix'][ $i3 ]['mod'],
                        'steam' => $this->db[ $this->mod_name[ $i ] ][0]['DB'][ $i2 ]['Prefix'][ $i3 ]['steam'],
                    ];

                }

            }

            $this->table_count[ $this->mod_name[ $i ] ] = sizeof( $this->db_data[ $this->mod_name[ $i ] ] );
        }
    }

    /**
     * Шаблон запроса отдающий массив с индексированными именами столбцов.
     *
     * @param string $mod           Навание мода.
     * @param string $db_num        Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function query($mod, $db_num = '0', $sql ) {
        return $this->pdo[ $mod ][ $db_num ]->query( $sql )->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив с индексированными номерами столбцов.
     *
     * @param string $mod           Навание мода.
     * @param string $db_num        Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function queryNum( $mod, $db_num = '0', $sql ) {
        return $this->pdo[ $mod ][ $db_num ]->query( $sql )->fetch( PDO::FETCH_NUM );
    }

    /**
     * Шаблон запроса отдающий массив со всеми строками.
     *
     * @param string $mod           Навание мода.
     * @param string $db_num        Номер подключенной базы данных.
     * @param string $sql           SQL запрос.
     *
     * @return array|false          Возвращает результат SQL запроса.
     */
    public function queryAll( $mod, $db_num = '0', $sql ) {
        return $this->pdo[ $mod ][ $db_num ]->query( $sql )->fetchAll( PDO::FETCH_ASSOC );
    }

    /**
     * Запрос проверяющий существование таблицы в той или иной базе данных.
     *
     * @param string $mod          Навание мода.
     * @param string $dbnum        Номер подключенной базы данных.
     * @param string $tablename    Название таблицы которую нужно проверить проверки
     *
     * @return int                 Возвращает результат проверки.
     */
    public function mysql_table_search( $mod, $dbnum = '0', $tablename ) {
        return ( $this->pdo[ $mod ][ $dbnum ]->query("SHOW TABLES FROM `" . $this->db_data['LevelsRanks'][ $dbnum ]['DB'] . "` like '$tablename'")->fetchAll( PDO::FETCH_NUM )[0] ) ? true : false;
    }

    /**
     * "Разрыв соединения с базой данных".
     */
    public function __destruct() {
        // Циклом перебираем доступные моды.
        for ( $mi = 0; $mi < $this->mod_count; $mi++ ) {
            // Чистим переменные связанные с подлючением к базам данных.
            for ( $i = 0; $i < $this->db_count[ $this->mod_name[ $mi ] ]; $i++ ) {
                unset( $this->dns[ $this->mod_name[ $mi ] ][ $i ] );
                unset( $this->pdo[ $this->mod_name[ $mi ] ][ $i ] );
            }
        }
    }
}