<?php
    /**
     * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
     *
     * @link https://steamcommunity.com/profiles/76561198038416053
     * @link https://github.com/M0st1ce
     *
     * @license GNU General Public License Version 3
     */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_top', '_Top_donations')?></h5>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="tb-avatar"></th><?php } ?>
                    <th class="text-left"><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                    <th class="text-center"><?php echo $Translate->get_translate_module_phrase('module_page_lk_top', '_Amount')?></th>
                </tr>
                </thead>
                <tbody><?php for ( $sz_i = 0, $sz = sizeof( $res ); $sz_i < $sz; $sz_i++ ):
                    $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['auth'] ) : $res[$sz_i]['auth'] )?>
                    <tr class="pointer"
                        <?php if ( $Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['auth'] ) : $res[$sz_i]['auth']?>&search=1';"<?php } ?>>
                        <th class="text-center"><?php echo $sz_i + 1?></th>
                        <?php if( ! empty( $General->arr_general['avatars'] ) ):?><th class="text-right tb-avatar"><img class="rounded-circle" id="<?php $General->arr_general['avatars'] === 1 && print con_steam32to64( $res[ $sz_i ]['auth'] )?>"<?php echo $sz_i < '20' ? 'src' : 'data-src'?>="<?php echo $General->getAvatar( con_steam32to64( $res[ $sz_i ]['auth'] ), 2 )?>"></th><?php endif?>
                        <th class="table-text text-left tb-name"><a <?php $Modules->array_modules['module_page_profiles']['setting']['status'] === 1 && print sprintf('href="%s?page=profiles&profile=%s&search=1"', $General->arr_general['site'], $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['auth'] ) : $res[$sz_i]['auth'] )?>><?php echo action_text_clear( action_text_trim($res[$sz_i]['name'], 16) )?></a></th>
                        <th class="text-center"><?php echo number_format( $res[ $sz_i ]['all_cash'], 0, '.', ' ' ) ?> RUB.</th>
                    </tr><?php endfor?></tbody>
            </table>
        </div>
    </div>
</div>