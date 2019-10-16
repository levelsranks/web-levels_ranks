<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Подключение SourceQuery.
require '../ext/SourceQuery/bootstrap.php';

// Подключение основных функций.
require '../../../includes/functions.php';

// Импорт класса - SourceQuery.
use xPaw\SourceQuery\SourceQuery;

// Если входящий поток существует, начинаем работу.
! isset( $_POST['data'] ) && die();

// Итоговый вывод является массивом.
$return = [];

// Итоговый кэш является массивом.
$cache = [];

// Присваиваем список серверов.
$servers = $_POST['data'][0];

// Считаем количество серверов.
$servers_count = sizeof( $servers );

// Перебираем список серверов и собираем данные в подмассивы.
for ( $i_ser = 0; $i_ser < $servers_count; $i_ser++ ):
    // Список основых IP | PORT.
    $server[] = explode( ":", $servers[$i_ser]['ip'] );

    // Список Fake IP:PORT.
    $server_fakeip[] = $servers[$i_ser]['fakeip'];
endfor;

// Создние экземпляра класса - SourceQuery.
$Query = new SourceQuery();

// Перебор серверов и получение актуальной информации.
for ( $i_server = 0; $i_server < $servers_count; $i_server++ ):
    // Освное действие
    try {
        // Попытка подключения, протокол - Source.
        $Query->Connect( $server[ $i_server ][0], $server[ $i_server ][1], 3, SourceQuery :: SOURCE );

        // Присваиваем полученную информацию о сервере.
        $info[ $i_server ] = $Query->GetInfo();

        // Присваиваем полученную информацию об игроках.
        $return[ $i_server ]['players'] = $Query->GetPlayers();

        // Вывод - IP Сервера
        $return[ $i_server ]['ip'] = empty( $server_fakeip[ $i_server ] ) ? $server[ $i_server ][0] . ':' . $server[ $i_server ][1] : $server_fakeip[ $i_server ];

        // Вывод - Название сервера
        $return[ $i_server ]['HostName'] = substr_unicode( $info[ $i_server ]['HostName'], 0, 43 ) . '..';

        // Проверка на существование изображения карты.
        if( file_exists( '../../../../storage/cache/img/maps/' . $info[ $i_server ]['AppID'] . '/' . array_reverse( explode( "/", $info[ $i_server ]['Map'] ) )[0] . '.jpg') ):
            // Вывод - Название карты.
            $return[ $i_server ]['Map'] = array_reverse(explode("/", $info[ $i_server ]['Map']))[0];

            // Вывод - Изображение карты карты.
            $return[ $i_server ]['Map_image'] = array_reverse(explode("/", $info[ $i_server ]['Map']))[0];

            // Добавление в кэш ссылки на изображения текущей карты.
            $cache[ $i_server ] = $info[ $i_server ]['AppID'] . '/' . array_reverse(explode("/", $info[ $i_server ]['Map']))[0];
        else:
            // Вывод - Название карты.
            $return[ $i_server ]['Map'] = array_reverse(explode("/", $info[ $i_server ]['Map']))[0];

            // Вывод - При отсутсвии изображении, заглушка.
            $return[ $i_server ]['Map_image'] = '-';

            // Добавление в кэш заглушки.
            $cache[ $i_server ] = '730/-';
        endif;

        // Вывод - Количество игроков.
        $return[ $i_server ]['Players'] = $info[ $i_server ]['Players'];

        // Вывод - Максимальное количество игроков.
        $return[ $i_server ]['MaxPlayers'] = $info[ $i_server ]['MaxPlayers'];

        // Вывод - Название мода.
        $return[ $i_server ]['Mod'] = $info[ $i_server ]['AppID'];

        // Исключение
    } catch ( Exception $e ) {
        // Вывод - IP Сервера
        $return[ $i_server ]['ip'] = empty( $server_fakeip[ $i_server ] ) ? $server[ $i_server ][0] . ':' . $server[ $i_server ][1] : $server_fakeip[ $i_server ];

        // Название выключенного сервера
        $return[ $i_server ]['HostName'] = 'Сервер отключен';

        // Карта выключенного сервера
        $return[ $i_server ]['Map'] = '-';

        // Название выключенного сервера
        $return[ $i_server ]['Map_image'] = '-';

        // Количество игроков выключенного сервера
        $return[ $i_server ]['Players'] = 0;
        $return[ $i_server ]['MaxPlayers'] = 0;

        // Мод выключенного сервера
        $return[ $i_server ]['Mod'] = '730';
        $cache[ $i_server ] = '730/-';

        // Конец действия
    } finally {
        $Query->Disconnect();
    }
endfor;

// Проверка директории под кэш
! file_exists( '../temp' ) && mkdir( '../temp', 0777, true );

// Кэширование изображений с серверов для предзагрузки блоков
( ! file_exists( '../temp/cache.php' ) || $cache != require '../temp/cache.php' ) && file_put_contents('../temp/cache.php', '<?php return ' . var_export( $cache, true) . ";" );

// Вывод
echo json_encode( $return, JSON_UNESCAPED_UNICODE );
exit;