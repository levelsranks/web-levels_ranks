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
 * @since 0.2
 *
 * @param string $file      Путь до файла который необходимо прочитать и вывести.
 *
 * @return string|false     Выводит содержимое файла.
 */
function file_get_contents_fix( $file ) {
    return file_get_contents( $file, false, stream_context_create( array( "ssl" => array("verify_peer" => false, "verify_peer_name" => false ) ) ) );
}

/**
 * Фикс функции header для криво настроенного сервера, релоады происходят за счёт JS.
 *
 * @since 0.2
 *
 * @param  string $url      Переадрисация по URL.
 */
function header_fix( $url ) {
    if ( ! headers_sent() )
    {
        echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '" /></noscript>';
    }
    else
    {
        header("Location: ".$url);
    }
}

/**
 * Перезапуск страницы.
 *
 * @since 0.2
 */
function refresh() {
    header_fix( get_url(1) );
    exit;
}

/**
 * Проверка ну переменной на пустоту с последующей заменой при отсутсвии значения.
 *
 * @since 0.2
 *
 * @param  int|string|array  $i      Премеренная.
 * @param  int|string|array  $d      Значение если переменная не пустая..
 * @param  int|string|array  $a      Значение если переменая пустая.
 *
 * @return int|string|array          Итог.
 */
function empty_check_out( $i, $d = 0, $a = 0 ) {
    $x = empty( $d ) ? $i : $d;
    return empty( $i ) ? $a : $x;
}

/**
 * Сокращение вывода var_export до одной строки.
 *
 * @since 0.2
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
        if ($return) return $code;
        else echo $code;
    } else {
        return var_export($var, $return);
    }
} 
/**
 * Вывод var_export в более оптимальном виде.
 *
 * @since 0.2
 *
 * @param   array    $var     Массив данных
 * @param   boolean  $return  Вид вывода.
 *
 * @return  string            Вывод содержимого.
 */
function var_export_opt( $var, $return = true ) {
        return var_export( $var, $return );
}

/**
 * Получает и задает название подраздела из URL по умолчанию.
 *
 * @since 0.2
 *
 * @param  string $section       Название подраздела.
 * @param  string $default       Значние по умолчанию.
 *
 * @return string|false          Выводит итоговое значение раздела.
 */
function get_section( $section, $default ) {
    return isset( $_GET[ $section ] ) ? action_text_clear( $_GET[ $section ] ) : $default;
}

/**
 * Получить размер массива.
 *
 * @since 0.2
 *
 * @param  array $arr          Массив.
 *
 * @return int                 Выводит итоговое количесво элементов массива.
 */
function get_arr_size( $arr ) {
    return is_array( $arr ) ? sizeof( $arr ) : 0;
}

/**
 * Получить URL страницы.
 *
 * @since 0.2
 *
 * @param  int $type          Тип URL.
 *
 * @return string             URL страницы.
 */

function get_url( $type ) {
    $url_clear = action_text_clear( $_SERVER["REQUEST_URI"] );
    switch ( $type ) {
        case 1:
            return '//' . $_SERVER["SERVER_NAME"] . $url_clear;
            break;
        case 2:
            return '//' .$_SERVER['HTTP_HOST'] . explode( '?', $url_clear, 2 )[0];
            break;
    }
}

/**
 * Меняет определенное значение подраздела на новое.
 *
 * @since 0.2
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
 * @since 0.2
 *
 * @param int       $code          Код ошибки.
 * @param string    $description   Описание ошибки.
 * @param bool      $die           Прекращение работы скрипта.
 *
 * @return string|false            Выводит новый URL с измененным значением подраздела.
 */
function get_iframe( $code, $description, $die = true ) {
    echo '<iframe style="margin:0;border:0;width:100%;height:97%" src="?code=' . $code . '&description=' . $description . '"></iframe>';
    $die == true && die();
}

/**
 * Сокращения входного текста до определенного количества символов.
 *
 * @since 0.2
 *
 * @param string        $text   Текст.
 * @param int           $max    Максимальное количество символов.
 *
 * @return string               Сокращенный текст.
 */
function action_text_trim( $text, $max = 18 )
{
    for($i = 0, $symbols = 0, $iLen = strlen($text); $i < $iLen; $i += GetCharBytes($text[$i]), $symbols++)
    {
        if($symbols > $max)
        {
            return substr( $text, 0, $i ) . '...';
        }
    }

    return $text;
}

/**
 * Получает количество байт в символе в соответствии кодировки UTF-8.
 *
 * @since 0.2
 *
 * @param string            $symbol   Входной символ.
 *
 * @return int           Количество байт.
 */
function GetCharBytes($symbol)
{
    $charnum = ord($symbol);

    if($charnum & (1 << 7))
    {
        if($charnum & (1 << 5))
        {
            if($charnum & (1 << 4))
            {
                return 4;
            }

            return 3;
        }

        return 2;
    }

    return 1;
}

function action_text_clear($text)
{
    return stripslashes( htmlspecialchars( strip_tags( trim( stripslashes( $text ) ) ), ENT_QUOTES,'ISO-8859-1', true ) );
}

/**
 * Очистка текста от символов.
 *
 * @since 0.2
 *
 * @param   string  $text  Текст.
 *
 * @return  string         Очищенный текст.
 */
function action_text_clear_characters( $text ) {
    return preg_replace('/[^А-Яа-яA-Za-z0-9]/', '', $text);
}

/**
 * Процент от числа ( Округление ).
 *
 * @since 0.2
 *
 * @param int        $int      Число.
 * @param int        $all      Всего.
 *
 * @return int                  Итог.
 */
function action_int_percent_of_all( $int = 0, $all = 0 ) {
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
 * @since 0.2
 *
 * @param string        $text   Текст.
 *
 * @return string               Текст после последнего слэша
 */
function action_text_clear_before_slash( $text ) {
    return array_reverse( explode( "/", $text ) )[0];
}

/**
 * Проверка на дубликат файла.
 *
 * @since 0.2
 *
 * @param  string        $file     Ссылка на первый файл.
 * @param  string        $file_2   Ссылка на второй файл.
 *
 * @return bool                    Итог проверки.
 */
function check_duplicate_files( $file, $file_2 ) {
        return ( file_exists( $file ) && file_exists( $file_2 ) && filesize( $file ) === filesize( $file_2 ) ) ? true : false;
}

/**
 * Конвертация Steam ID 32 -> 64.
 *
 * @since 0.2
 *
 * @param string       $id    Steam ID игрока.
 *
 * @return int             Выводит итог конвертации.
 */
function con_steam32to64( $id ) {
    if( $id[0] == 'S'){
        $arr = explode(":", $id);
        if ( ! empty( $arr[2] ) ):
            return bcadd( bcmul( (int) $arr[2], 2 ), bcadd( (int) $arr[1], '76561197960265728' ), 0 );
        endif;
    } else {
        return is_numeric ( $id ) ? $id : false;
    }
}

/**
 * Конвертация Steam ID 32 -> 3 (int).
 *
 * @since 0.2
 *
 * @param string   $steamid32  Steam ID 32 игрока.
 *
 * @return int                 Выводит итог конвертации.
 */
function con_steam32to3_int( $steamid32 ) {
    if ( preg_match('/^STEAM_/', $steamid32 ) ) {
        $split = explode( ':', $steamid32 );
        return $split[2] << 1 | $split[1];
    }

    return $steamid32;
}

/**
 * Конвертация Steam ID 64 -> 3 (int).
 *
 * @since 0.2
 *
 * @param string  $steamid64  Steam ID 32 игрока.
 *
 * @return int                Выводит итог конвертации.
 */
function con_steam64to3_int( $steamid64 ) {
    if ( preg_match( '/^765/', $steamid64 ) && strlen( $steamid64 ) > 15 ) {
        return bcsub( $steamid64, '76561197960265728' );
    } else {
        return $steamid64;
    }
}

/**
 * Конвертация Steam ID 3 -> 64 (int).
 *
 * @since 0.2
 *
 * @param string       $steamid3  Steam ID 3 игрока.
 *
 * @return int                    Выводит итог конвертации.
 */
function con_steam3to64_int( $steamid3 ) {
    if( is_numeric( $steamid3 ) ):
        $a = $steamid3 % 2;
        $b = intval($steamid3 / 2);
        $c = con_steam32to64 ( 'STEAM_1:' . $a . ':' . $b );
        return $c;
    else:
        return '';
    endif;
}

/**
 * Конвертация Steam ID 3 -> 32 (int).
 *
 * @since 0.2
 *
 * @param string       $steamid3  Steam ID 3 игрока.
 *
 * @return int                    Выводит итог конвертации.
 */
function con_steam3to32_int( $steamid3, $else = 0 ) {
    if( is_numeric ( $steamid3 ) ):
        $a = $steamid3 % 2;
        $b = intval($steamid3 / 2);
        return 'STEAM_1:' . $a . ':' . $b;
    elseif( $else === 1 ):
        return $steamid3[0] == 'S' ? con_steam32to64( $steamid3 ) : $steamid3;
    else:
        return $steamid3;
    endif;
}

/**
 * Конвертация Steam ID 64 -> 32.
 *
 * @since 0.2
 *
 * @param  string  $steamid64  Steam ID игрока.
 *
 * @return string              Выводит итог конвертации.
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
    }
    if ( is_numeric ( $steamid64 ) && empty( $steam32 ) ) {
        $z = bcdiv(bcsub($steamid64, '76561197960265728'), '2');
        $y = bcmod($steamid64, '2');
        return 'STEAM_1:' . $y . ':' . floor($z);
    } elseif ( ! empty( $steam32 ) ) {
        return $steam32;
    } elseif ( ! is_numeric( $steamid64 ) ) {
        return false;
    } else {
        return false;
    }
}

/**
 * Замена значений перевода
 *
 * @since 0.2
 *
 * @param string       $phares    Текст перевода
 * @param array        $values    Значения перевода
 *
 * @return string                 Выводит итог замены.
 */
function LangValReplace( $phares, $values=[] ) {
    $replace = $phares;
    for($i=0; $i<sizeof($values);$i++){
        foreach($values as $key => $val){
            $replace = str_replace('%' . $key . '%', $val, $replace);
        }
    }
    return $replace;
}

/**
 * Оставляет в массиве состоящим из нумервынных ключей определенные внутренние ключи.
 *
 * @since 0.2
 *
 * @param array       $array   Массив.
 * @param array        $keys   Ключи.
 *
 * @return array               Итог.
 */
function action_array_keep_keys( $array, $keys ) {
    $result = [];

    $keys = array_flip( $keys );

    for( $i = 0, $c = sizeof( $array ); $i < $c; $i++ ) {
        $result[] = array_intersect_key( $array[ $i ], $keys );
    }
    return $result;
}

/**
 * Замена функции mb_substr, при отсутсвии библиотеки "mbstring".
 *
 * @since 0.2
 *
 * @param string    $str    Входная строка.
 * @param int       $s      Количество символов с начала.
 * @param int       $l      Количество символов с конца.
 *
 * @return string           Вывод.
 */
function substr_unicode( $str, $s, $l = null ) {
    return join( "", array_slice( preg_split( "//u", $str, -1, PREG_SPLIT_NO_EMPTY ), $s, $l ) );
}

/**
 * Выборка всех файлов и папок и запись в массив
 *
 * @since 0.2
 *
 * @param string    $str    Директория.
 *
 * @return array            Вывод.
 */
function dirToArray($dir) {
  
    $result = array();
 
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }
    return $result;
}