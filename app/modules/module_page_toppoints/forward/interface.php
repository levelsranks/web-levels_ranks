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
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Statistics') ?></h5>
                <div class="select-panel select-panel-table badge">
                    <select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled selected><?php echo $Db->statistics_table[ $server_group ]['name']?></option>
                        <?php for ($b = 0; $b < $Db->table_statistics_count; $b++) { ?>
                            <option value="<?php echo set_url_section(get_url(2), 'server_group', $b) ?>">
                                <a href="<?php echo set_url_section(get_url(2), 'server_group', $b) ?>"><?php echo $Db->statistics_table[ $b ]['name']?></a></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="select-panel select-panel-pages badge">
                    <select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled selected><?php echo $page_num ?></option>
                        <?php for ($v = 0; $v < $page_max; $v++) { ?>
                        <option value="<?php echo set_url_section(get_url(2), 'num', $v + 1) ?>">
                            <a href="<?php echo set_url_section(get_url(2), 'num', $v + 1) ?>"><?php echo $v + 1 ?></a></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="tb-avatar"></th><?php } ?>
                    <th><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'value') ?>';" class="text-center a-type tb-name <?php $_SESSION['filter'] == 'value' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Point') ?></th>
                    <?php if( $res_data[ $server_group ]['statistics'] != 'RankMeKento' ):?><th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'rank') ?>';" class="text-center a-type tb-rank <?php $_SESSION['filter'] == 'rank' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Rank') ?></th><?php endif?>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'kills') ?>';" class="text-center a-type tb-death<?php $_SESSION['filter'] == 'kills' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Kills') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'deaths') ?>';" class="text-center a-type tb-death <?php $_SESSION['filter'] == 'deaths' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Deaths') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'kd') ?>';" class="text-center a-type <?php $_SESSION['filter'] == 'kd' && print 'selected';?>">K/D</th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'headshots') ?>';" class="text-center a-type tb-hs <?php $_SESSION['filter'] == 'headshots' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Headshot') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'playtime') ?>';" class="text-center a-type tb-time <?php $_SESSION['filter'] == 'playtime' && print 'selected';?>"><?php echo $Translate->get_translate_phrase('_Play_time') ?></th>
                </tr>
                </thead>
                <tbody><?php for ( $sz_i = 0, $sz = sizeof( $res ); $sz_i < $sz; $sz_i++ ):
                    $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['steam'] ) : $res[$sz_i]['steam'] )?>
                    <tr class="pointer"
                        <?php if ( $Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['steam'] ) : $res[$sz_i]['steam']?>/<?php echo $server_group ?>';"<?php } ?>>
                        <th class="text-center"><?php echo ++$page_num_min ?></th>
                        <?php if( ! empty( $General->arr_general['avatars'] ) ):?><th class="text-right tb-avatar"><img class="rounded-circle" id="<?php $General->arr_general['avatars'] === 1 && print con_steam32to64( $res[ $sz_i ]['steam'] )?>"<?php echo $sz_i < '20' ? 'src' : 'data-src'?>="<?php echo $General->getAvatar( con_steam32to64( $res[ $sz_i ]['steam'] ), 2 )?>"></th><?php endif?>
                        <th class="table-text text-left tb-name"><a <?php $Modules->array_modules['module_page_profiles']['setting']['status'] === 1 && print sprintf('href="%sprofiles/%s/%d"', $General->arr_general['site'], $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$sz_i]['steam'] ) : $res[$sz_i]['steam'], $server_group )?>><?php echo action_text_clear( action_text_trim($res[$sz_i]['name'], 16) )?></a></th>
                        <th class="text-center"><?php echo number_format( $res[ $sz_i ]['value'], 0, '.', ' ' ) ?></th>
                        <?php if( $res_data[ $server_group ]['statistics'] != 'RankMeKento' ):?><th class="text-center table-text"><img <?php echo sprintf('%s="../storage/cache/img/ranks/%s/%d', $sz > 18 ? 'src' :'data-src', $Db->statistics_table[ $server_group ]['ranks_pack'], empty( $res[ $sz_i ]['rank'] ) ? (int) 00 : $res[ $sz_i ]['rank'] )?>.png"></th><?php endif?>
                        <th class="text-center tb-death"><?php echo number_format( (int) $res[ $sz_i ]['kills'], 0, '.', ' ' )?></th>
                        <th class="text-center tb-death"><?php echo number_format( (int) $res[ $sz_i ]['deaths'], 0, '.', ' ' )?></th>
                        <th class="text-center"><?php echo $res[ $sz_i ]['kd'] ?></th>
                        <th class="text-center tb-hs"><?php echo empty( $res[ $sz_i ]['headshots'] ) ? 0 : number_format( $res[ $sz_i ]['headshots'], 0, '.', ' ' )?></th>
                        <th class="text-center tb-time"><?php echo $Modules->action_time_exchange( $res[ $sz_i ]['playtime'], 2 )?></th>
                    </tr><?php endfor?></tbody>
            </table>
            <div class="card-bottom">
                <?php if( $page_max != 1):?>
                <div class="select-panel-pages">
                    <?php endif;?>
                    <?php if ( $page_num != 1) { ?>
                        <a href="<?php echo set_url_section(get_url(2), 'num', $page_num - 1) ?>"><h5
                                    class="badge"><?php $General->get_icon('zmdi', 'chevron-left') ?></h5></a>
                    <?php } ?>
                    <?php if ( $page_num != $page_max) { ?>
                        <a href="<?php echo set_url_section(get_url(2), 'num', $page_num + 1) ?>"><h5
                                    class="badge"><?php $General->get_icon('zmdi', 'chevron-right') ?></h5></a>
                    <?php } ?>
                    <?php if( $page_max != 1):?>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>