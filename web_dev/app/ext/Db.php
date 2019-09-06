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
     * @var int
     */
    public    $table_statistics_count = 0;

    /**
     * @var array
     */
    public    $support_statistics = ['LevelsRanks', 'FPS'];

    /**
     * @var array
     */
    public    $statistics_with_table_servers = ['FPS', 'HLstatsX'];

    /**
     * @var array
     */
    public    $statistics_table = [];

    /**
     * Организация работы вэб-приложения с базой данных.
     */
    public function __construct() {

        # Получение настроек с модами, пользователями, базами данных и таблицами.
        ! file_exists ( SESSIONS . '/db.php' ) && header( 'Location: ' . get_url(2) . 'app/page/custom/install/index.php');

        $this->db = $this->get_db_options();

        // PDO Условия.
        $this->options = [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];

        $this->table_count['LevelsRanks'] = 0;
        $this->table_count['FPS'] = 0;

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

                // Проверка на поле PORT
                $this->db[ $this->mod_name[ $m ] ][ $u ]["PORT"] = empty( $this->db[ $this->mod_name[ $m ] ][ $u ]["PORT"] ) ? 3306 : $this->db[ $this->mod_name[ $m ] ][ $u ]["PORT"];

                // Сигнатура DNS.
                $this->dns[ $this->mod_name[ $m ] ][ $u ][ $d ] = 'mysql:host=' . $this->db[ $this->mod_name[ $m ] ][ $u ]["HOST"] . ';port=' . $this->db[ $this->mod_name[ $m ] ][ $u ]["PORT"] . ';dbname=' . $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['DB'] . ';charset=utf8';

                // Создаём подключение по PDO для определенной базы данных.
                $this->pdo[ $this->mod_name[ $m ] ][ $u ][ $d ] = new PDO( $this->dns[ $this->mod_name[ $m ] ][ $u ][ $d ], $this->db[ $this->mod_name[ $m ] ][ $u ]['USER'], $this->db[ $this->mod_name[ $m ] ][ $u ]['PASS'], $this->options );

                $this->table_count_for[ $this->mod_name[ $m ] ] = sizeof( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'] );

                // Циклом перебираем все таблицы которые описаны в файле настроек баз данных.
                for ( $t = 0; $t < $this->table_count_for[ $this->mod_name[ $m ] ]; $t++ ) {

                    /*
                     * $t - Номер таблицы.
                     */

                    $rank_pack = empty( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'] ) ? false : $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'];

                    if( in_array( $this->mod_name[ $m ], $this->statistics_with_table_servers ) ):
                        switch ( $this->mod_name[ $m ] ) {
                            case 'FPS':
                                $this->fps_servers_data = $this->queryAll('FPS',0, 0, 'SELECT id, server_name, server_ip, settings_rank_id FROM fps_servers' );
                                for ( $_m = 0, $m_s = sizeof( $this->fps_servers_data ); $_m < $m_s; $_m++ ):
                                    $this->db_data['FPS'][] = [
                                        'DB_mod' => 'FPS',
                                        'USER_ID' => $u,
                                        'USER' => $this->db[ $this->mod_name[ $m ] ][ $u ]['USER'],
                                        'DB' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['DB'],
                                        'DB_num' => $d,
                                        'Table' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['table'],
                                        'name' => $this->fps_servers_data[ $_m ]['server_name'],
                                        'mod' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['mod'],
                                        'steam' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['steam'],
                                        'ranks_id' => $this->fps_servers_data[ $_m ]['settings_rank_id'],
                                        'ranks_pack' => $rank_pack
                                    ];
                                    $this->statistics_table[] = [ 'name' => $this->fps_servers_data[ $_m ]['server_name'], 'ranks_pack' => $rank_pack];
                                endfor;
                                break;
                            case 'HLstatsX':
                                break;
                        }
                    else:
                        // Создаём массив с описанием таблиц.
                        $this->db_data[ $this->mod_name[ $m ] ][] = [
                            'DB_mod' => $this->mod_name[ $m ],
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
                        in_array( $this->mod_name[ $m ], $this->support_statistics ) && $this->statistics_table[] = [ 'name' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['name'], 'ranks_pack' => $rank_pack];
                    endif;
                }

            }

            }

            $this->table_count[ $this->mod_name[ $m ] ] = sizeof( $this->db_data[ $this->mod_name[ $m ] ] );
        }

        $this->table_statistics_count = $this->table_count['LevelsRanks'] + $this->table_count['FPS'];
    }

    /**
     * Получение настроек базы данных.
     *
     * @return array                 Массив с настройками.
     */
    private function get_db_options() {
        $db = file_exists( SESSIONS . '/db.php' ) ? require SESSIONS . '/db.php' : header( 'Location: ' . get_url(2) . '/app/page/custom/install/index.php' );
        return empty( $db ) ? header( 'Location: ' . get_url(2) . '/app/page/custom/install/index.php' ) : $db;
    }

    /**
     * Подготовительный подзапрос.
     *
     * @param  string    $mod           Навание мода.
     * @param  int       $user_id       Номер пользователя.
     * @param  int       $db_id         Номер подключенной базы данных.
     * @param  string    $sql           SQL запрос.
     * @param  array     $params        Параметры.
     *
     * @return array                    Итог подготовленного подзапроса
     */
    public function inquiry( $mod, $user_id, $db_id, $sql, $params ) {

        $stmt = $this->pdo[ $mod ][ $user_id ][ $db_id ]->prepare( $sql );

        if ( ! empty( $params ) ) {
            foreach ( $params as $key => $val ) {
                if ( is_int( $val ) ) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue( ':'.$key, $val, $type );
            }
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * Шаблон запроса отдающий массив с индексированными именами столбцов.
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function query( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );
        return $result->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив с индексированными номерами столбцов.
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function queryNum( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );
        return $result->fetch( PDO::FETCH_NUM );
    }

    /**
     * Шаблон запроса отдающий массив со всеми строками.
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function queryAll( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );
        return $result->fetchAll( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив стобца.
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function queryColumn( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );
        return $result->fetchColumn();
    }

    /**
     * Шаблон запроса отдающий данные одного стобца.
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function queryOneColumn( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );
        return $result->fetch( PDO::FETCH_COLUMN );
    }

    /**
     * Запрос проверяющий существование столбика в той или иной таблице.
     *
     * @param  string  $mod          Навание мода.
     * @param  int     $user_id      Номер пользователя.
     * @param  int     $db_id        Номер подключенной базы данных.
     * @param  string  $tablename    Название таблицы.
     * @param  string  $column    	 Название столбика который нужно проверить.
     *
     * @return int                   Возвращает результат проверки.
     */
    public function mysql_column_search( $mod, $user_id = 0, $db_id = 0, $tablename, $column ) {
        return in_array( $column, $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query('SHOW COLUMNS from ' . $tablename . ' ')->fetchAll( PDO::FETCH_COLUMN ) );
    }

    /**
     * Запрос проверяющий существование таблицы в той или иной базе данных.
     *
     * @param  string  $mod          Навание мода.
     * @param  int     $user_id      Номер пользователя.
     * @param  int     $db_id        Номер подключенной базы данных.
     * @param  string  $tablename    Название таблицы которую нужно проверить проверки
     *
     * @return int                   Возвращает результат проверки.
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