<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

( empty( $_SESSION['steamid32'] ) || empty( $_GET['page'] ) || $_GET['page'] != 'adminpanel' || $_SESSION['steamid32'] != $General->arr_general['admin'] ) && die();

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['clear_cache_modules'] ) && IN_LR == true ) {
    for ( $i = 0; $i < $Modules->array_modules_count; $i++ ) {
        $module = array_keys( $Modules->array_modules )[ $i ];
        if ( file_exists( SESSIONS . 'modules/' . $module . '/cache.php' ) ) {
            unlink(SESSIONS . 'modules/' . $module . '/cache.php');
        }
    }
    unlink( SESSIONS . '/modules_cache.php' );
    unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $Modules->actual_library['actual_css_ver'] . '.css');
    unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver'] . '.js');
    header_fix( get_url(1) );
}

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['clear_modules_initialization'] ) && IN_LR == true ) {
    for ( $i = 0; $i < $Modules->array_modules_count; $i++ ) {
        $module = array_keys( $Modules->array_modules )[ $i ];
        if ( file_exists( SESSIONS . 'modules/' . $module . '/cache.php' ) ) {
            unlink(SESSIONS . 'modules/' . $module . '/cache.php');
        }
    }
    unlink( SESSIONS . '/modules_cache.php' );
    unlink( SESSIONS . '/modules_initialization.php' );
    unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $Modules->actual_library['actual_css_ver'] . '.css');
    unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver'] . '.js');
    header_fix( get_url(1) );
}

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['clear_translator_cache'] ) && IN_LR == true ) {
    unlink( SESSIONS . '/translator_cache.php' );
    header_fix( get_url(1) );
    exit;
}

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['option_one_save'] ) && IN_LR == true ) {
    $arr = require SESSIONS . 'options.php';
    $option = [
        'full_name' => $_POST['full_name'],
        'short_name' => $_POST['short_name'],
        'info' => $_POST['info'],
        'language' => $_POST['language'],
        'web_key' => $_POST['web_key'],
        'admin' => $_POST['admin'],
        'avatars' => (int) $_POST['avatars'],
        'avatars_cache_time' => (int) $_POST['avatars_cache_time']
    ];
    file_put_contents( SESSIONS . 'options.php', '<?php return '.var_export_min( array_replace($arr, $option), true ).";" );
    header_fix( get_url(1) );
}

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset($_POST['data']) && IN_LR == true) {

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

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['save_server'] ) && IN_LR == true ) {
    $server = [];

    $server[0]['name'] = $_POST['server_name'];
    $server[0]['ip'] = $_POST['server_ip_port'];
    $server[0]['fakeip'] = $_POST['server_ip_port_fake'];
    $server[0]['rcon'] = $_POST['server_rcon'];
    $server[0]['server_stats'] = $_POST['server_stats'];
    $server[0]['server_vip'] = $_POST['server_vip'];
    $server[0]['server_vip_id'] = empty( $_POST['server_vip_id'] ) ? 0 : $_POST['server_vip_id'];
    $server[0]['server_sb'] = $_POST['server_sb'];
    $server[0]['server_shop'] = $_POST['server_shop'];
    $server[0]['server_warnsystem'] = $_POST['server_warnsystem'];

    empty( $General->server_list ) || ! is_array( $General->server_list ) ? $arr_servers[0] = $server[0] : $arr_servers = array_merge( $General->server_list, $server );

    file_put_contents( SESSIONS . 'servers_list.php', '<?php return '.var_export_min( $arr_servers, true ).";" );
    header_fix( get_url(1) );
}

if( $_SESSION['steamid32'] == $General->arr_general['admin'] && isset( $_POST['module_save'] ) && IN_LR == true ) {
    $Module_data = $Modules->array_modules[ $_GET['options'] ];

    // А где цикл то, что за беспредел? :D
    $Module_data['page'] = $_POST['module_page'];
    $Module_data['setting']['status'] = $_POST['module_offon'] == 'on' ? 1 : 0;
    $Module_data['setting']['type'] = (int) $_POST['module_type'];
    $Module_data['setting']['translation'] = $_POST['module_translation'] == 'on' ? 1 : 0;
    $Module_data['setting']['interface'] = $_POST['module_interface'] == 'on' ? 1 : 0;
    $Module_data['setting']['data'] = $_POST['module_data'] == 'on' ? 1 : 0;
    $Module_data['setting']['data_always'] = $_POST['module_data_always'] == 'on' ? 1 : 0;
    $Module_data['setting']['css'] = $_POST['module_css'] == 'on' ? 1 : 0;
    $Module_data['setting']['js'] = $_POST['module_js'] == 'on' ? 1 : 0;
    $Module_data['setting']['cache_enable'] = $_POST['module_cache_enable'] == 'on' ? 1 : 0;
    $Module_data['setting']['cache_time'] = (int) $_POST['module_cache_time'];

    file_put_contents( MODULES . $_GET['options'] . '/description.json', json_encode( $Module_data, JSON_UNESCAPED_UNICODE ) );

    $modules_init = require SESSIONS . '/modules_initialization.php';

    if( ! empty( $Module_data['sidebar'] ) && ! in_array( $_GET['options'], $modules_init['sidebar'] ) ) {
        $modules_init['sidebar'] =+ $_GET['options'];
    }

    file_put_contents( SESSIONS . '/modules_initialization.php', '<?php return '.var_export_min( $modules_init, true ).";" );

    unlink( SESSIONS . '/modules_cache.php' );
    unlink(ASSETS_CSS . '/generation/style_generated.min.ver.' . $Modules->actual_library['actual_css_ver'] . '.css');
    unlink(ASSETS_JS . '/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver'] . '.js');
    header_fix( get_url(1) );
}

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Admin_panel') );