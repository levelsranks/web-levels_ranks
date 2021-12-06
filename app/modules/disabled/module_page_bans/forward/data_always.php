<?php // Работа со статусом игрока.
if ( ! empty( $Modules->route ) && $Modules->route === 'profiles' ):
    for ( $d = 0; $d < $General->server_list_count; $d++ ):
        if ( ! empty( $General->server_list[ $d ]['server_stats'] ) && $General->server_list[ $d ]['server_stats'] == sprintf('%s;%d;%d;%s', $Player->found[ $Player->server_group ]['DB_mod'], $Player->found[ $Player->server_group ]['USER_ID'], $Player->found[ $Player->server_group ]['DB'], $Player->found[ $Player->server_group ]['Table'] ) ):
            $stats = explode( ";", $General->server_list[ $d ]['server_sb'] );
            $ban_check = $Db->query( 'SourceBans', (int) $stats[1], (int) $stats[2], "SELECT created, authid, ends, `length`, RemovedOn, RemoveType FROM " . $stats[3] . "bans WHERE authid LIKE '%" . $Player->get_steam_32_short() . "%' order by created desc limit 1" );
            ! empty( $ban_check ) && $Player->get_profile_status()['priority'] < 3 && ( ( empty( $ban_check['length'] ) || $ban_check['ends'] >= time() ) && empty( $ban_check['RemovedOn'] ) && empty( $ban_check['RemoveType'] ) ) && $Player->set_profile_status( $Translate->get_translate_phrase( '_Banned' ), '#ba0000', 3 );
            break;
        endif;
    endfor;
endif;