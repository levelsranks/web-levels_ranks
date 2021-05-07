<?php // Работа со статусом игрока.
if ( ! empty( $Modules->route ) && $Modules->route === 'profiles' ):
    for ( $d = 0; $d < $General->server_list_count; $d++ ):
        if ( ! empty( $General->server_list[ $d ]['server_stats'] ) && $General->server_list[ $d ]['server_stats'] == sprintf('%s;%d;%d;%s', $Player->found[ $Player->server_group ]['DB_mod'], $Player->found[ $Player->server_group ]['USER_ID'], $Player->found[ $Player->server_group ]['DB'], $Player->found[ $Player->server_group ]['Table'] ) ):
            $stats = explode( ";", $General->server_list[ $d ]['server_sb'] );
            $admin_check = $Db->query( 'SourceBans', (int) $stats[1], (int) $stats[2], "SELECT `authid`, `srv_group` FROM " . $stats[3] . "admins WHERE authid LIKE '%" . $Player->get_steam_32_short() . "%' LIMIT 1" );
            ! empty( $admin_check ) && $Player->get_profile_status()['priority'] < 10 && $Player->set_profile_status( $admin_check['srv_group'], '#ff6d0a', 10 );
            break;
        endif;
    endfor;
endif;