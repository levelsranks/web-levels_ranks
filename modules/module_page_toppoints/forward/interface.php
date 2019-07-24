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
                <h5 class="badge"><?php echo $Modules->get_translate_phrase('_Statistics') ?></h5>
                <div class="select-panel select-panel-table badge">
                    <select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled selected><?php echo $Db->db_data['LevelsRanks'][$server_group]['name'] ?></option>
                        <?php for ($b = 0; $b < $res_data_count; $b++) { ?>
                            <option value="<?php echo set_url_section(get_url(2), 'server_group', $b) ?>">
                                <a href="<?php echo set_url_section(get_url(2), 'server_group', $b) ?>"><?php echo $Db->db_data['LevelsRanks'][$b]['name'] ?></a></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="select-panel select-panel-pages badge">
                    <select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled selected><?php echo $page_num ?></option>
                        <?php for ($v = 0; $v < $res_data[$server_group]['count']; $v++) { ?>
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
                    <th><?php echo $Modules->get_translate_phrase('_Player') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'value') ?>';" class="text-center a-type tb-name <?php $_SESSION['filter'] == 'value' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Point') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'rank') ?>';" class="text-center a-type tb-rank <?php $_SESSION['filter'] == 'rank' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Rank') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'kills') ?>';" class="text-center a-type <?php $_SESSION['filter'] == 'kills' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Kills') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'deaths') ?>';" class="text-center a-type tb-death <?php $_SESSION['filter'] == 'deaths' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Deaths') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'headshots') ?>';" class="text-center a-type tb-hs <?php $_SESSION['filter'] == 'headshots' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Headshot') ?></th>
                    <th onclick="location.href = '<?php echo set_url_section(get_url(2), 'filter', 'playtime') ?>';" class="text-center a-type tb-time <?php $_SESSION['filter'] == 'playtime' && print 'selected';?>"><?php echo $Modules->get_translate_phrase('_Play_time') ?></th>
                </tr>
                </thead>
                <tbody><?php $sz = sizeof( $res[$server_group] );
                for ($sz_i = 0; $sz_i < $sz; $sz_i++) { ?>
                <?php if( $General->arr_general['avatars'] == 1 ) {?><script>CheckAvatar = <?php echo $General->checkAvatar(con_steam32to64($res[$server_group][$sz_i]['steam']), 2)?>;
                        if (CheckAvatar == 1) {
                            avatar.push("<?php echo con_steam32to64($res[$server_group][$sz_i]['steam'])?>");
                        }</script><?php } ?>
                    <tr class="pointer"
                        <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php echo $res[$server_group][$sz_i]['steam'] ?>&server_group=<?php echo $server_group ?>';"<?php } ?>>
                        <th class="text-center"><?php echo ++$page_num_min ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ) {?>
                        <th class="text-right tb-avatar"><img class="rounded-circle"
                                                              id="<?php if ( $General->arr_general['avatars'] == 1){ echo con_steam32to64($res[$server_group][$sz_i]['steam']);} ?>"
                            <?php if ($sz_i < '20') {
                                echo 'src';
                            } else {
                                echo 'data-src';
                            } ?>=
                            "
                            <?php if ( $General->arr_general['avatars'] == 1){ echo $General->getAvatar(con_steam32to64($res[$server_group][$sz_i]['steam']), 2);
                            } elseif( $General->arr_general['avatars'] == 2) {
                                echo 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                            }?>">
                        </th>
                        <?php }?>
                        <th class="table-text text-left tb-name"><a
                                <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php echo $res[$server_group][$sz_i]['steam'] ?>&server_group=<?php echo $server_group ?>"<?php } ?>><?php echo action_text_clear( action_text_trim($res[$server_group][$sz_i]['name'], 16) )?></a>
                        </th>
                        <th class="text-center"><?php echo number_format(str_replace(";", "", $res[$server_group][$sz_i]['value']), 0, '.', ' ') ?></th>
                        <th class="text-center table-text"><img
                            <?php if ($sz > 18) {
                                echo 'src';
                            } else {
                                echo 'data-src';
                            } ?>="<?php echo 'storage/cache/img/ranks/' . $General->arr_general['ranks_pack'] . '/';
                            if ($res[$server_group][$sz_i]['rank'] == '') {
                                echo '00';
                            } else {
                                echo $res[$server_group][$sz_i]['rank'];
                            } ?>.png"></th>
                        <th class="text-center"><?php echo number_format(str_replace(";", "", $res[$server_group][$sz_i]['kills']), 0, '.', ' ') ?></th>
                        <th class="text-center tb-death"><?php echo number_format(str_replace(";", "", $res[$server_group][$sz_i]['deaths']), 0, '.', ' ') ?></th>
                        <th class="text-center tb-hs"><?php echo number_format(str_replace(";", "", $res[$server_group][$sz_i]['headshots']), 0, '.', ' ') ?></th>
                        <th class="text-center tb-time"><?php echo round($res[$server_group][$sz_i]['playtime'] / 60 / 60) . ' Час.' ?></th>
                    </tr><?php } ?></tbody>
            </table>
            <div class="card-bottom">
                <?php if( $page_max != 1):?>
                <div class="select-panel-pages">
                    <?php endif;?>
                    <?php if ($page_num != 1) { ?>
                        <a href="<?php echo set_url_section(get_url(2), 'num', $page_num - 1) ?>"><h5
                                    class="badge"><?php $General->get_icon('zmdi', 'chevron-left') ?></h5></a>
                    <?php } ?>
                    <?php if ($page_num != $page_max) { ?>
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