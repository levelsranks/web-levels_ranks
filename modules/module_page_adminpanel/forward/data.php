<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site'] ); exit; }

    if( isset( $_POST['clear_cache_modules'] ) && IN_LR == true ) {
        for ( $i = 0; $i < $Modules->array_modules_count; $i++ ) {
            $module = array_keys( $Modules->array_modules )[ $i ];
            if ( file_exists( SESSIONS . 'modules/' . $module . '/cache.php' ) ) {
                unlink(SESSIONS . 'modules/' . $module . '/cache.php');
            }
        }
        unlink( SESSIONS . '/modules_cache.php' );
        header( 'Location: ' . get_url(1) );
        exit;
    }

    if( isset( $_POST['clear_modules_initialization'] ) && IN_LR == true ) {
        for ( $i = 0; $i < $Modules->array_modules_count; $i++ ) {
            $module = array_keys( $Modules->array_modules )[ $i ];
            if ( file_exists( SESSIONS . 'modules/' . $module . '/cache.php' ) ) {
                unlink(SESSIONS . 'modules/' . $module . '/cache.php');
            }
        }
        unlink( SESSIONS . '/modules_cache.php' );
        unlink( SESSIONS . '/modules_initialization.php' );
        header( 'Location: ' . get_url(1) );
        exit;
    }

    if( isset( $_POST['option_one_save'] ) && IN_LR == true ) {
        $arr = require SESSIONS . 'options.php';
        $option = [
            'full_name' => $_POST['full_name'],
            'short_name' => $_POST['short_name'],
            'info' => $_POST['info'],
            'language' => $_POST['language'],
            'steam_auth' => $_POST['steam_auth'],
            'web_key' => $_POST['web_key'],
            'admin' => $_POST['admin']
        ];
        file_put_contents( SESSIONS . 'options.php', '<?php return '.var_export_min( array_replace($arr, $option), true ).";" );
        header( 'Location: ' . get_url(1) );
        exit;
    }

    if( isset( $_POST['option_two_save'] ) && IN_LR == true ) {
      $arr = require SESSIONS . 'options.php';
      $option = [
          'dark_mode' => $_POST['dark_mode'],
          'animations' => $_POST['animations'],
          'avatars' => $_POST['avatars'],
          'sidebar_open' => $_POST['sidebar_open'],
          'form_border' => $_POST['form_border']
       ];
       file_put_contents( SESSIONS . 'options.php', '<?php return '.var_export_min( array_replace($arr, $option), true ).";" );
       header( 'Location: ' . get_url(1) );
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
        $db = $_POST['serversdb'];
        $count = sizeof($_POST['serversip']);
        for ($i = 0; $i < $count; $i++) {
            $arr_servers[$i] = ['ip' => $ip[$i],'fakeip' => $fakeip[$i],'db' => $db[$i]];
        }
        file_put_contents( SESSIONS . 'servers_list.php', '<?php return '.var_export_min( $arr_servers, true ).";" );
        header('Location: ' . get_url(1));
        exit;
    }