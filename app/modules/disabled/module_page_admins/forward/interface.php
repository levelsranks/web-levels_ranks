<?php
    /**
     * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
     *
     * @link https://steamcommunity.comprofiles/76561198038416053
     * @link https://github.com/M0st1ce
     *
     * @license GNU General Public License Version 3
     */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Admins_sb')?></h5>
            </div>
            <table class="table table-hover">
                <thead>
                <tr class="pointer">
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                    <th class="text-left"><?php echo $Translate->get_translate_phrase('_Admin') ?></th>
                    <th class="text-center">Группа</th>
                    <th class="text-center">Количество банов</th>
                    <th class="text-center">Количество мутов / гагов</th>
                </tr>
                </thead>
                <tbody>
                <?php for ( $i = 0, $sz = sizeof( $res ); $i < $sz; $i++ ): $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid'] )?>
                    <tr class="pointer" onclick="location.href = '<?php echo sprintf('%sprofiles/%s/0', $General->arr_general['site'], $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid'] )?>';">
                    <?php if( $General->arr_general['avatars'] != 0 ) {?>
                        <th class="text-right tb-avatar"><img class="rounded-circle" id="<?php echo con_steam32to64( $res[ $i ]['authid'] ) ?>"<?php echo $i  < '20' ? 'src' : 'data-src'?>="<?php echo $General->getAvatar( con_steam32to64( $res[ $i ]['authid'] ), 2 )?>"></th>
                    <?php } ?>
                    <th class="text-left" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid']?>/0' "<?php } ?>>
                        <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid']?>/0"<?php } ?>><?php echo action_text_clear( action_text_trim($res[ $i ]['user'], 13) )?></a>
                    </th>
                    <th class="text-center"><?php echo $res[ $i ]['srv_group']?></th>
                    <th class="text-center"><?php echo $res[ $i ]['bans_count']?></th>
                    <th class="text-center"><?php echo $res[ $i ]['comms_count']?></th>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>