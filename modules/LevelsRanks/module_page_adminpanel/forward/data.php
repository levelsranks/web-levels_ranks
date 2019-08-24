<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

! empty( $_SESSION['steamid32'] ) && $_SESSION['steamid32'] == $General->arr_general['admin'] && $Modules->set_sidebar_select('module_page_adminpanel', ["href" =>"?page=adminpanel", "open_new_tab" =>"0", "icon_group" =>"zmdi", "icon_category" =>"", "icon" =>"coffee", "name" =>"Панель администратора", "sidebar_directory" =>""]);

if( ! empty( $_SESSION['steamid32'] ) && ! empty( $_GET['page'] ) && $_GET['page'] == 'adminpanel' && $_SESSION['steamid32'] == $General->arr_general['admin'] ):

    if( isset( $_POST['clear_cache_modules'] ) && IN_LR == true ) {
        for ( $i = 0; $i < $Modules->array_modules_count; $i++ ) {
            $module = array_keys( $Modules->array_modules )[ $i ];
            if ( file_exists( SESSIONS . 'modules/' . $module . '/cache.php' ) ) {
                unlink(SESSIONS . 'modules/' . $module . '/cache.php');
            }
        }
        unlink( SESSIONS . '/modules_cache.php' );
        unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $General->arr_general['actual_css_ver'] . '.css');
        unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $General->arr_general['actual_js_ver'] . '.js');
        header("Refresh:0");
        exit();
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
        unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $General->arr_general['actual_css_ver'] . '.css');
        unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $General->arr_general['actual_js_ver'] . '.js');
        header("Refresh:0");
        exit();
    }

if( isset( $_POST['clear_translator_cache'] ) && IN_LR == true ) {
    unlink( SESSIONS . '/translator_cache.php' );
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
            'admin' => $_POST['admin'],
            'only_steam_64' => $_POST['only_steam_64'] == 'on' ? 1 : 0,
            'SB_admins_import' => $_POST['SB_admins_import']  == 'on' ? 1 : 0
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
       unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $General->arr_general['actual_css_ver'] . '.css');
       unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $General->arr_general['actual_js_ver'] . '.js');
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
endif;