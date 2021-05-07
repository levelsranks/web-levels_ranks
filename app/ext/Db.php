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
     * @since 0.2
     * @var array
     */
    private  $options = [];

    /**
     * @since 0.2
     * @var array
     */
    private  $db = [];

    /**
     * @since 0.2
     * @var array
     */
    private  $dns = [];

    /**
     * @since 0.2
     * @var array
     */
    protected $pdo = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $db_data = [];

    /**
     * @since 0.2
     * @var array
     */
    private   $table_count_for = [];

    /**
     * @since 0.2
     * @var int
     */
    public    $mod_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    public    $user_count = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $db_count = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $table_count = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $mod_name = [];

    /**
     * @since 0.2
     * @var int
     */
    public    $table_statistics_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    public    $support_statistics = ['LevelsRanks', 'FPS', 'RankMeKento'];

    /**
     * @since 0.2
     * @var array
     */
    public    $statistics_with_table_servers = ['FPS', 'HLstatsX'];

    /**
     * @since 0.2
     * @var array
     */
    public    $statistics_table = [];

    /**
     * Организация работы вэб-приложения с базой данных.
     *
     * @since 0.2
     */
    public function __construct() {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        $this->db = $this->get_db_options();

        // PDO Условия.
        $this->options = [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];

        $this->table_count['LevelsRanks'] = 0;
        $this->table_count['FPS'] = 0;
        $this->table_count['RankMeKento'] = 0;

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

                $this->table_count_for[ $this->mod_name[ $m ] ] = sizeof( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'] );

                // Циклом перебираем все таблицы которые описаны в файле настроек баз данных.
                for ( $t = 0; $t < $this->table_count_for[ $this->mod_name[ $m ] ]; $t++ ) {

                    /*
                     * $t - Номер таблицы.
                     */

                    $rank_pack = empty( $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'] ) ? 'default' : $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['ranks_pack'];

                    if( in_array( $this->mod_name[ $m ], $this->statistics_with_table_servers ) ):
                        switch ( $this->mod_name[ $m ] ) {
                            case 'FPS':
                                $this->fps_servers_data = $this->queryAll('FPS',0, 0, 'SELECT `id`, `server_name`, `server_ip`, `settings_rank_id` FROM `fps_servers`' );
                                for ( $_m = 0, $m_s = sizeof( $this->fps_servers_data ); $_m < $m_s; $_m++ ):
                                    $this->db_data['FPS'][] = [
                                        'DB_mod' => 'FPS',
                                        'USER_ID' => $u,
                                        'USER' => $this->db[ $this->mod_name[ $m ] ][ $u ]['USER'],
                                        'DB' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['DB'],
                                        'DB_num' => $d,
                                        'Table' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['table'] ?? '',
                                        'table_id' => $t,
                                        'name' => $this->fps_servers_data[ $_m ]['server_name'] ?? 'Unnamed',
                                        'mod' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['mod'] ?? 730,
                                        'steam' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['steam'] ?? 1,
                                        'ranks_id' => $this->fps_servers_data[ $_m ]['settings_rank_id'],
                                        'ranks_pack' => $rank_pack ?? 'default'
                                    ];
                                    $this->statistics_table[] = [ 'DB_mod' => 'FPS', 'name' => $this->fps_servers_data[ $_m ]['server_name'], 'ranks_pack' => $rank_pack ];
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
                            'Table' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['table'] ?? '',
                            'table_id' => $t,
                            'name' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['name'] ?? 'Unnamed',
                            'mod' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['mod'] ?? 730,
                            'steam' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['steam'] ?? 1,
                            'ranks_pack' => $rank_pack ?? 'default'
                        ];
                        in_array( $this->mod_name[ $m ], $this->support_statistics ) && $this->statistics_table[] = [ 'DB_mod' => $this->mod_name[ $m ], 'name' => $this->db[ $this->mod_name[ $m ] ][ $u ]['DB'][ $d ]['Prefix'][ $t ]['name'], 'ranks_pack' => $rank_pack];
                    endif;
                }

            }

            }

            $this->table_count[ $this->mod_name[ $m ] ] = sizeof( $this->db_data[ $this->mod_name[ $m ] ] );
        }

        $this->table_statistics_count = $this->table_count['LevelsRanks'] + $this->table_count['FPS'] + $this->table_count['RankMeKento'];
    }

    /**
     * Получение настроек базы данных.
     *
     * @since 0.2
     *
     * @return array                 Массив с настройками.
     */
    private function get_db_options() {
        $db = file_exists( SESSIONS . '/db.php' ) ? require SESSIONS . '/db.php' : null;
        return empty( $db ) ?  exit(require 'app/page/custom/install/index.php') : $db;
    }

    /**
     * Добавление или удаление мода в db.php
     * 
     * @since 0.2.2
     * 
     * $delete - ["DB_MOD" => "Номер базы, может их несколько", "USER_ID" => "Номер базы, обычно 0"] || ["delete" => "all"] - Чтобы снести всю базу
     * 
     * @return bool
     */
    public function change_db( $mod, $host, $user, $pass, $db_name, $table, $delete = 0, $params = null )
    {
        $db = $this->get_db_options();
        if( !$db )
            return false;

        if( is_array( $delete ) )
        {
            if( !isset( $delete["delete"] ) && $delete["delete"] != "all" )
            {
                // Рядовые проверки, вдруг надо удалить конкретную базу
                if( !empty( $delete["DB_MOD"] ) && empty( $delete["USER_ID"] ) )
                    unset( $db[ $mod ][ $delete["DB_MOD"] ] );

                // Удаление определенной таблицы
                if( !empty( $delete["DB_MOD"] ) && !empty( $delete["USER_ID"] ) )
                    unset( $db[ $mod ][ $delete["DB_MOD"] ][ $delete["USER_ID"] ] );
            }
            else
            {
                unset( $db[ $mod ] );
            }
        }
        else
        {
            $params = ( !empty( $params ) ) ? ["table" => $table] + $params : ["table" => $table];
            $query = ['HOST' => $host, 'USER' => $user, 'PASS' => $pass, 'DB' =>[0 =>['DB' => $db_name, 'Prefix' =>[0 =>$params]]]];
            $db[ $mod ][] = $query;
        }

        if( file_put_contents( SESSIONS . 'db.php', '<?php return '.var_export_opt( $db, true ).";" ) )
            return true;

        return false;
    }

    /**
     * Подключение к определенному моду базы данных.
     *
     * @since 0.2
     *
     * @param  string    $mod           Навание мода.
     * @param  int       $user_id       Номер пользователя.
     * @param  int       $db_id         Номер подключенной базы данных.
     *
     * @return bool              существование мода
     */
    private function get_new_connect($mod, $user_id, $db_id)
    {
        $_Key = array_search($mod, $this->mod_name);

        if($_Key !== false)
        {
            // Создаём подключение по PDO для определенной базы данных.
            $this->pdo[ $this->mod_name[ $_Key ] ][ $user_id ][ $db_id ] = new PDO( $this->dns[ $this->mod_name[ $_Key ] ][ $user_id ][ $db_id ], $this->db[ $this->mod_name[ $_Key ] ][ $user_id ]['USER'], $this->db[ $this->mod_name[ $_Key ] ][ $user_id ]['PASS'], $this->options );
            return true;
        }
        return false;
    }

    /**
     * Подготовительный подзапрос.
     *
     * @since 0.2
     *
     * @param  string    $mod           Навание мода.
     * @param  int       $user_id       Номер пользователя.
     * @param  int       $db_id         Номер подключенной базы данных.
     * @param  string    $sql           SQL запрос.
     * @param  array     $params        Параметры.
     *
     * @return array                    Итог подготовленного подзапроса
     */
    public function inquiry( $mod, $user_id, $db_id, $sql, $params ) 
    {
        //Проверка на существования БД, и подключение если его нет
        if(!isset($this->pdo[ $mod ][ $user_id ][ $db_id ]))
            $this->get_new_connect($mod, $user_id, $db_id);

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
     * @since 0.2
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
        if($result)
            return $result->fetch( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив с индексированными номерами столбцов.
     *
     * @since 0.2
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

        if($result)
            return $result->fetch( PDO::FETCH_NUM );
    }

    /**
     * Шаблон запроса отдающий массив со всеми строками.
     *
     * @since 0.2
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

        if($result)
            return $result->fetchAll( PDO::FETCH_ASSOC );
    }

    /**
     * Шаблон запроса отдающий массив со всеми строками, парсирование ключа.
     *
     * @since 0.2
     *
     * @param  string  $mod           Навание мода.
     * @param  int     $user_id       Номер пользователя.
     * @param  int     $db_id         Номер подключенной базы данных.
     * @param  string  $sql           SQL запрос.
     * @param  array   $params        Параметры.
     *
     * @return array                  Возвращает результат SQL запроса.
     */
    public function query_all_key_pair( $mod, $user_id = 0, $db_id = 0, $sql, $params = [] ) {
        $result = $this->inquiry( $mod, $user_id, $db_id, $sql, $params );

        if($result)
            return $result->fetchAll( PDO::FETCH_KEY_PAIR );
    }

    /**
     * Шаблон запроса отдающий массив стобца.
     *
     * @since 0.2
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

        if($result)
            return $result->fetchColumn();
    }

    /**
     * Шаблон запроса отдающий данные одного стобца.
     *
     * @since 0.2
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

        if($result)
            return $result->fetch( PDO::FETCH_COLUMN );
    }

    /**
     * Запрос проверяющий существование столбика в той или иной таблице.
     *
     * @since 0.2
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
        //Проверка на существования БД, и подключение если его нет
        if(!isset($this->pdo[ $mod ][ $user_id ][ $db_id ]))
            $this->get_new_connect($mod, $user_id, $db_id);

        return in_array( $column, $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query('SHOW COLUMNS from ' . $tablename . ' ')->fetchAll( PDO::FETCH_COLUMN ) );
    }

    /**
     * Запрос проверяющий существование таблицы в той или иной базе данных.
     *
     * @since 0.2
     *
     * @param  string  $mod          Навание мода.
     * @param  int     $user_id      Номер пользователя.
     * @param  int     $db_id        Номер подключенной базы данных.
     * @param  string  $tablename    Название таблицы которую нужно проверить проверки
     *
     * @return int                   Возвращает результат проверки.
     */
    public function mysql_table_search( $mod, $user_id = 0, $db_id = 0, $tablename ) {
        //Проверка на существования БД, и подключение если его нет
        if(!isset($this->pdo[ $mod ][ $user_id ][ $db_id ]))
            $this->get_new_connect($mod, $user_id, $db_id);

        return ! empty( $this->pdo[ $mod ][ (int) $user_id ][ (int) $db_id ]->query("SHOW TABLES like '$tablename'")->fetchAll( PDO::FETCH_NUM )[0] ) ? true : false;
    }

    /**
     * Возвращает ID последней вставленной строки.
     *
     * @since 0.2
     *
     * @param  string  $mod          Навание мода.
     * @param  int     $user_id      Номер пользователя.
     * @param  int     $db_id        Номер подключенной базы данных.
     *
     * @return int                   ID.
     */

    public function lastInsertId( $mod, $user_id = 0, $db_id = 0 ) 
    {
        //Проверка на существования БД, и подключение если его нет
        if(!isset($this->pdo[ $mod ][ $user_id ][ $db_id ]))
            $this->get_new_connect($mod, $user_id, $db_id);

            return $this->pdo[ $mod ][ $user_id ][ $db_id ]->lastInsertId();
    }

    /**
     * "Разрыв соединения с базой данных".
     *
     * @since 0.2
     */
    public function __destruct() {
        unset( $this->dns );
        unset( $this->pdo );
    }
}