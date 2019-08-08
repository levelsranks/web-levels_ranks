<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

/**
 * Фикс функции file_get_contents для криво настроенного SSL сертификата под Nginx.
 *
 * @param string $file      Путь до файла который необходимо прочитать и вывести.
 *
 * @return string|false     Выводит содержимое файла.
 */
function file_get_contents_fix( $file ) {
    return file_get_contents( $file, false, stream_context_create( array( "ssl" => array("verify_peer" => false, "verify_peer_name" => false ) ) ) );
}

/**
 * Сокращение вывода var_export до одной строки.
 *
 * @param array $var        Массив данных
 * @param boolean $return   Вид вывода.
 *
 * @return string           Вывод содержимого.
 */
function var_export_min($var, $return = true) {
    if ( is_array( $var ) ) {
        $toImplode = array();
        foreach ( $var as $key => $value ) {
            $toImplode[] = var_export( $key, true ).'=>'.var_export_min( $value, true );
        }
        $code = 'array('.implode(',', $toImplode).')';
        if ($return) return str_replace( [ ')', 'array (', 'array(' ], [ ']', '[', '[' ],  $code );
        else echo $code;
    } else {
        return var_export($var, $return);
    }
}

/**
 * Вывода var_export в более оптимальном виде.
 *
 * @param array $var        Массив данных
 * @param boolean $return   Вид вывода.
 *
 * @return string           Вывод содержимого.
 */
function var_export_opt($var, $return = true) {
        return str_replace( [ ')', 'array (', 'array(' ], [ ']', '[', '[' ], var_export( $var, $return ) );
}

/**
 * Получает и задает название подраздела из URL по умолчанию.
 *
 * @param string $section       Название подраздела.
 * @param string $default       Значние по умолчанию.
 *
 * @return string|false         Выводит итоговое значение раздела.
 */
function get_section( $section, $default ) {
    return ! empty( $_GET[ $section ] ) ? $_GET[ $section ] : $default;
}

/**
 * Получает и задает название подраздела из URL по умолчанию.
 *
 * @param array $arr            Название подраздела.
 *
 * @return int                  Выводит итоговое количесво элементов массива
 */
function get_arr_size( $arr ) {
    return isset ( $arr ) ? sizeof( $arr ) : 0;
}

function get_url( $type ) {
    if ( $type == 1) {
        $URL = 'http';
        if ( $_SERVER["HTTPS"] == "on" ) {
            $URL .= "s";
        }
        $URL .= '://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $URL;
    } elseif ( $type == 2 ) {
        $URL = 'http';
        if ( $_SERVER["HTTPS"] == "on" ) {
            $URL .= "s";
        }
        $URL .= '://';
        $URL_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $URL .= $_SERVER['HTTP_HOST'] . $URL_parts[0];
        return $URL;
    }
}

/**
 * Меняет определенное значение подраздела на новое.
 *
 * @param string $url           URL для изменения.
 * @param string $command       Название подраздела.
 * @param string $change        Новое значение подраздела.
 *
 * @return string|false         Выводит новый URL с измененным значением подраздела.
 */
function set_url_section( $url, $command, $change ) {
    // Получаем массив всех подразделов.
    $query = $_GET;

    // Присваеваем подразделу новое значение.
    $query[$command] = $change;

    // Генерируем новую ссылку.
    $finally = urldecode( http_build_query( $query ) );
    return $url . '?' . $finally;
}

/**
 * Открывает iframe блок, по умолчанию для страниц ошибок.
 *
 * @param int       $code          Код ошибки.
 * @param string    $description   Описание ошибки.
 * @param bool      $die           Прекращение работы скрипта.
 *
 * @return string|false            Выводит новый URL с измененным значением подраздела.
 */
function get_iframe( $code, $description, $die = true ) {
    echo '<iframe style="margin:0;border:0;width:100%;height:97%" src="' . PAGE_CUSTOM . '/error/index.php?code=' . $code . '&description=' . $description . '"></iframe>';
    $die == true && die();
}

/**
 * Сокращения входного текста до определенного количества символов.
 *
 * @param string        $text   Текст.
 * @param int           $max    Максимальное количество символов.
 *
 * @return string               Сокращенный текст.
 */
function action_text_trim( $text, $max = 18 ) {
    return strlen( $text ) > $max ? substr( $text, 0, $max ) . '..' : $text;
}

/**
 * Очистка текста.
 *
 * @param string        $text   Текст.
 *
 * @return string               Очищенный текст.
 */
function action_text_clear( $text ) {
    return stripslashes( trim( strip_tags( htmlspecialchars( $text, ENT_COMPAT,'ISO-8859-1', true ) ) ) );
}

/**
 * Процент от числа ( Округление ).
 *
 * @param int        $int      Число.
 * @param int        $all      Всего.
 *
 * @return int                  Итог.
 */
function action_int_percent_of_all( $int, $all ) {
    if( $int == 0 || $all == 0 ) {
        $res = 0;
    } else {
        $res = floor( 100 * $int / $all );
    }
    return is_nan ( $res ) ? 0 : $res;
}

/**
 * Очистка текста до последнего слэша
 *
 * @param string        $text   Текст.
 *
 * @return string               Текст после последнего слэша
 */
function action_text_clear_before_slash( $text ) {
    return array_reverse( explode( "/", $text ) )[0];
}

/**
 * Конвертация Steam ID 32 -> 64.
 *
 * @param string       $id    Steam ID игрока.
 *
 * @return string                    Выводит итог конвертации.
 */
function con_steam32to64( $id ) {
    $accountarray =	explode(":", $id);
    if ( version_compare( PHP_VERSION, "7.3", "=" ) ) {
        return $accountarray[2] * 2 + $accountarray[1] + '76561197960265728';
    } else {
        $idnum			=	$accountarray[1];
        $accountnum		=	$accountarray[2];
        $constant		=	'76561197960265728';
        $number			=	bcadd(bcmul($accountnum, 2), bcadd($idnum, $constant));
        return $number;
    }
}

/**
 * Конвертация Steam ID 64 -> 32.
 *
 * @param string       $steamid64    Steam ID игрока.
 *
 * @return string                    Выводит итог конвертации.
 */
function con_steam64to32( $steamid64 ) {
    if ( preg_match( '/^(7656119)([0-9]{10})$/', $steamid64, $match ) ) {
        $const1 = 7960265728;
        $steam32 = '';
        if ( $const1 <= $match[2] ) {
            $a = ( $match[2] - $const1 ) % 2;
            $b = ( $match[2] - $const1 - $a ) / 2;
            $steam32 = 'STEAM_1:' . $a . ':' . $b;
        }
        return $steam32;
    }
    return false;
}