<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Получение информации о каком-либо значении по ключу массива в options.php
if( $_POST["function"] == 'options' && isset( $_POST["setup"] ) ):

    $options =  require  '../../storage/cache/sessions/options.php';

    if( $_POST["setup"] == 'web_key' ):
        // Возобновление сессии
        session_start();

        if( isset( $_SESSION['user_admin'] ) ):
            echo json_encode( ( require  '../../storage/cache/sessions/options.php' )[ $_POST["setup"] ] );
            exit;
        else:
            exit;
        endif;
    else:
        echo json_encode( ( require  '../../storage/cache/sessions/options.php' )[ $_POST["setup"] ] );
        exit;
    endif;
endif;

// Присвоение какого-либо значения по ключу массива в options.php
if( $_POST["function"] == 'set' & isset( $_POST["option"] ) ) {
    // Возобновление сессии
    session_start();

    if( isset( $_SESSION['user_admin'] ) ):
        // Подключение основных функций.
        require '../../app/includes/functions.php';

        // Получение текущих настроек.
        $options = require '../../storage/cache/sessions/options.php';

        if ( empty( $_POST["data"] ) || is_numeric( $_POST["data"] ) ):

            // Изменение конкретной опции.
            $options[ $_POST["option"] ] = (int) $options[ $_POST["option"] ] == 0 ? 1 : 0;
        else:
            $options[ $_POST["option"] ] = $_POST["data"];
        endif;

        // Проверка на доп изменения.
        if( ! empty( $_POST["change"] ) ):

            // Если в строке есть 'css' выполнить чистку кэша по CSS
            if ( stristr( $_POST["change"], 'css') !== false ):

                // Проверка папки на пустоту
                $is_empty = sizeof( glob('../../storage/assets/css/generation/*') ) ? true : false;

                // Если папка не пустая, провести очистку
                if( $is_empty == true ):
                    $temp_files = glob( '../../storage/assets/css/generation/*' );
                    foreach( $temp_files as $temp_file ) {
                        if( is_file( $temp_file ) )
                            unlink( $temp_file );
                    }
                endif;
            endif;

            // Если в строке есть 'js' выполнить чистку кэша по CSS
            if ( stristr( $_POST["change"], 'js') !== false ):

                // Проверка папки на пустоту
                $is_empty = sizeof( glob('../../storage/assets/js/generation/*') ) ? true : false;

                // Если папка не пустая, провести очистку
                if( $is_empty == true ):
                    $temp_files = glob( '../../storage/assets/js/generation/*' );
                    foreach( $temp_files as $temp_file ) {
                        if( is_file( $temp_file ) )
                            unlink( $temp_file );
                    }
                endif;
            endif;
        endif;

        // Сохранение файла.
        file_put_contents( '../../storage/cache/sessions/options.php', '<?php return ' . var_export_min( $options ) . ';' );
        exit;
    else:
        exit;
    endif;
}

// Присвоение какого-либо значения по ключу массива в options.php
if( $_POST["function"] == 'delete' && ( isset( $_POST["server"] ) || isset( $_POST["table"] ) ) ):
    // Возобновление сессии
    session_start();

    if( isset( $_SESSION['user_admin'] ) ):
        // Подключение основных функций.
        require '../../app/includes/functions.php';

        if( isset( $_POST["server"] ) ):

        $server_id = (int) $_POST["server"] - 1;

        $servers = require '../../storage/cache/sessions/servers_list.php';

        unset( $servers[ $server_id ] );

        // Сохранение файла.
        file_put_contents( '../../storage/cache/sessions/servers_list.php', '<?php return ' . var_export_min( array_values ( $servers ) ) . ';' );
        exit;

        elseif( isset( $_POST["table"] ) ):
            $db = require '../../storage/cache/sessions/db.php';

            $del = explode( ";", $_POST["table"] );

            if ( sizeof( $del ) > 1 ):
                if ( sizeof( $db[ $del[0] ] ) == 1 && sizeof( $db[ $del[0] ][ $del[1] ]['DB'] ) == 1 && sizeof( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] ) == 1 ):
                    unset( $db[ $del[0] ] );
                elseif( sizeof( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] ) > 1 ):
                    unset( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'][ $del[3] ] );
                    rsort( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] );
                elseif( sizeof( $db[ $del[0] ][ $del[1] ]['DB'] ) > 1):
                    unset( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ] );
                    rsort( $db[ $del[0] ][ $del[1] ]['DB'] );
                elseif( sizeof( $db[ $del[0] ] ) > 1):
                    unset( $db[ $del[0] ][ $del[1] ] );
                    rsort( $db[ $del[0] ] );
                endif;
            else:
                unset( $db[ $del[0] ] );
            endif;

            // Сохранение файла.
            file_put_contents( '../../storage/cache/sessions/db.php', '<?php return ' . var_export_min( $db ) . ';' );
            exit;
        endif;
    else:
        exit;
    endif;
endif;

// Получение и сохранине состояния боковой панели.
if( $_POST["function"] == 'sidebar' ) {
    // Возобновление сессии
    session_start();

    // Сохраняем состояние боковой панели в сессию.
    $_SESSION['sidebar_open'] = $_POST["setup"];
    exit;
}

// Получение и сохранине состояния тёмного режима
if( $_POST["function"] == 'dark_mode' & isset( $_POST["setup"] ) ) {
    // Возобновление сессии
    session_start();

    // Сохраняем состояние боковой панели в сессию.
    $_SESSION['dark_mode'] = $_POST["setup"];
    exit;
}

// Получение данных о текущем состоянии определенной сессии сесии
if( $_POST["function"] == 'sessions' & isset( $_POST["data"] ) ) {
    // Возобновление сессии
    session_start();

    echo (int) $_SESSION[ $_POST["data"] ] ;
    exit;
}

// Работа со скачиванием аватаров посредством Steam API.
if( $_POST["function"] == 'avatars' ) {
    // Нахожение в пространстве LR.
    define('IN_LR', true);

    // Ограничение работы стрипта.
    set_time_limit(160);

    // Получение Steam WEB ключа, для доступа к Steam API.
    $web_key = ( require '../../storage/cache/sessions/options.php' )['web_key'];

    // Итоговый результат является массивом.
    $return = [];

    if ( isset( $_POST['data'] ) ) {
        // Присваивание к переменной полученный массив со списком Steam ID игроков.
        $avatars = $_POST['data'];

        // Генерация запроса к Steam API.
        $result = curl_init( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $web_key . '&steamids=' . implode( ",", $avatars ) );

        curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);

        $url = curl_exec($result);

        curl_close( $result );

        // Полученные данные из запроса декодируем.
        $data = json_decode( $url, true )['response']['players'];

        // Подсчёт количества элементов массива.
        $data_count = sizeof( $data );

        // Создание цикла исходя из количества эелементов.
        for ( $i = 0; $i < $data_count; $i++ ) {
            // Заполняем итоговый массив.
            $return[] = [
                "id" => $data[$i]['steamid'],
                "url" => $data[$i]['steamid']
            ];

            // Создаём пути под сохранение аватаров.
            $cacheFile = "../../storage/cache/img/avatars/" . $data[$i]['steamid'] . ".jpg";
            $cacheFile_slim = "../../storage/cache/img/avatars/slim/" . $data[$i]['steamid'] . ".jpg";

            // Номер случайной аватарки

            $rand = rand(1,30);

            // Сохраняем/редактируем новые аватары.

            $avatarfull = curl_init( $data[ $i ]['avatarfull'] );
            curl_setopt( $avatarfull, CURLOPT_HEADER, 0);
            curl_setopt( $avatarfull, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $avatarfull, CURLOPT_BINARYTRANSFER,1);
            $out_avatarfull = curl_exec( $avatarfull );
            curl_close( $avatarfull );

            if( ! empty( $out_avatarfull ) ) {
                file_put_contents( $cacheFile, $out_avatarfull );
            } else {
                file_put_contents( $cacheFile, file_get_contents( '../../storage/cache/img/avatars_random/' . $rand . '.jpg' ) );
            }

            $avatar = curl_init( $data[ $i ]['avatar'] );
            curl_setopt( $avatar, CURLOPT_HEADER, 0);
            curl_setopt( $avatar, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $avatar, CURLOPT_BINARYTRANSFER,1);
            $out_avatar = curl_exec( $avatar );
            curl_close( $avatar );

            if( ! empty( $out_avatar ) ) {
                file_put_contents( $cacheFile_slim, $out_avatar );
            } else {
                file_put_contents( $cacheFile_slim, file_get_contents( '../../storage/cache/img/avatars_random/' . $rand . '_xs.jpg' ) );
            }
        }

        // Вывод итоговых данных.
        echo json_encode( $return );
        exit;
    }
}

/**
 * А меня любят одичавшие собаки
 * Меня знают консультанты Apple store
 * Я абстрактный человек с дорожных знаков
 * Схематичный пешеход со светофора
 */