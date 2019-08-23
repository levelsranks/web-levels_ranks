<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

require(__DIR__ . '/bootstrap.php');

use xPaw\SourceQuery\SourceQuery;

if (isset($_POST['data'])) {
    $return = [];
    $servers = $_POST['data'][0];
    $servers_count = sizeof( $servers );
    for ($i_ser = 0; $i_ser < $servers_count; $i_ser++) {
        $server[] = explode(":", $servers[$i_ser]['ip']);
        $server_fakeip[] = explode(":", $servers[$i_ser]['fakeip']);
    }
    $Query = new SourceQuery();
    for ($i_server = 0; $i_server < $servers_count; $i_server++) {
        try {
            $Query->Connect($server[$i_server][0], $server[$i_server][1], 3, SourceQuery :: SOURCE);
            $info[$i_server] = $Query->GetInfo();
            if ( $servers[$i_ser]['fakeip'] !== '') {
                $return[$i_server]['ip'] = $server_fakeip[$i_server][0];
                $return[$i_server]['port'] = $server_fakeip[$i_server][1];
            } else {
                $return[$i_server]['ip'] = $server[$i_server][0];
                $return[$i_server]['port'] = $server[$i_server][1];
            }
            $return[$i_server]['HostName'] = $info[$i_server]['HostName'];
            $return[$i_server]['Map'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];
            if( file_exists( '../../../../../storage/cache/img/maps/' . $info[$i_server]['ModDir'] . '/' . array_reverse(explode("/", $info[$i_server]['Map']))[0] . '.jpg') ) {
                $return[$i_server]['Map'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];
                $return[$i_server]['Map_image'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];
                $cache[$i_server] = $info[$i_server]['ModDir'] . '/' . array_reverse(explode("/", $info[$i_server]['Map']))[0];
            } else {
                $return[$i_server]['Map'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];
                $return[$i_server]['Map_image'] = '-';
                $cache[$i_server] = 'csgo/-';
            }
            $return[$i_server]['Players'] = $info[$i_server]['Players'];
            $return[$i_server]['MaxPlayers'] = $info[$i_server]['MaxPlayers'];
            $return[$i_server]['Mod'] = $info[$i_server]['ModDir'];
        } catch (Exception $e) {
            if ($servers[$i_ser]['fakeip'] !== '') {
                $return[$i_server]['ip'] = $server_fakeip[$i_server][0];
                $return[$i_server]['port'] = $server_fakeip[$i_server][1];
            } else {
                $return[$i_server]['ip'] = $server[$i_server][0];
                $return[$i_server]['port'] = $server[$i_server][1];
            }
            $return[$i_server]['HostName'] = 'Сервер отключен';
            $return[$i_server]['Map'] = '-';
            $return[$i_server]['Map_image'] = '-';
            $return[$i_server]['Players'] = 0;
            $return[$i_server]['MaxPlayers'] = 0;
            $return[$i_server]['Mod'] = 'csgo';
            $cache[$i_server] = 'csgo/-';
        } finally {
            $Query->Disconnect();
        }
    }

    if( !file_exists( '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring/cache.php' ) ) {
        if( ! file_exists( '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring' ) ) mkdir( '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring', 0777, true );
        file_put_contents('../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring/cache.php', '<?php return ' . var_export($cache, true) . ";");
    } else {
        if ($cache != require '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring/cache.php') {
            if( ! file_exists( '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring' ) ) mkdir( '../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring', 0777, true );
            file_put_contents('../../../../../storage/cache/sessions/modules/module_block_main_servers_monitoring/cache.php', '<?php return ' . var_export($cache, true) . ";");
        }
    }

    echo json_encode($return);
    exit;
}