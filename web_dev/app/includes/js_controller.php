<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

if( $_POST["function"] == 'options' & isset( $_POST["setup"] ) ) {
    echo json_encode( ( require  '../../storage/cache/sessions/options.php' )[ $_POST["setup"] ] );
    exit;
}

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
    set_time_limit(120);

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

            // Сохраняем/редактируем новые аватары.

            $avatarfull_headers = @get_headers( $data[$i]['avatarfull'] );

            if( ! $avatarfull_headers || $avatarfull_headers[0] == 'HTTP/1.1 404 Not Found') {
                file_put_contents( $cacheFile, '../../storage/cache/img/avatars_random/' . rand(1,30) . '.jpg' );
            } else {
                file_put_contents( $cacheFile, file_get_contents( $data[$i]['avatarfull'] ) );
            }

            $avatar_headers = @get_headers( $data[$i]['avatar'] );

            if( ! $avatar_headers || $avatar_headers[0] == 'HTTP/1.1 404 Not Found') {
                file_put_contents( $cacheFile_slim, '../../storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg' );
            } else {
                file_put_contents( $cacheFile_slim, file_get_contents( $data[$i]['avatar'] ) );
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