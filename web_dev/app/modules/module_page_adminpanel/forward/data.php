<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

if($_SESSION['steamid32'] == $General->arr_general['admin']){

    if(isset($_POST['update_modules']) && IN_LR == true) {
        unlink(SESSIONS . '/modules_initialization.php');
        unlink(SESSIONS . '/modules_cache.php');
        header('Location: ' . get_url(1));
        exit;
    }

    if(isset($_POST['data']) && IN_LR == true) {

        $array = $Modules->arr_module_init;

        $data =  json_decode($_POST['data'], true);

        $c = sizeof( $data );

        for ( $i2 = 0; $i2 < $c; $i2++ ) {
            $_data[] = $data[ $i2 ]['id'];
        }

        if( $_GET['module_page'] == 'sidebar' ) {
            $array['sidebar'] = $_data;
        } else {
            $array['page'][ get_section( 'module_page', 'home' ) ]['interface'] = $_data;
        }

        file_put_contents( SESSIONS . 'modules_initialization.php', '<?php return '.var_export_min( $array, true ).";" );
    }
    
    if(isset($_POST['save_servers']) && IN_LR == true) {
        $ip = $_POST['serversip'];
        $fakeip = $_POST['serversfakeip'];
        $count = sizeof($_POST['serversip']);
        for ($i = 0; $i < $count; $i++) {
            $arr_servers[$i] = ['ip' => $ip[$i],'fakeip' => $fakeip[$i]];
        }
        file_put_contents( SESSIONS . 'servers_list.php', '<?php return '.var_export_min( $arr_servers, true ).";" );
        header('Location: ' . get_url(1));
        exit;
    }

} else {
    header('Location: ' . $General->arr_general['site']);
    exit;
}