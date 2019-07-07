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
            <div class="header-profile">
                <div class="card-header">
                <h5 class="badge">Профиль игрока :: <?php echo action_text_trim($Player[$server_group]['name'],16)?></h5>
                    <div class="select-panel select-panel-table badge">
                        <select onChange="window.location.href=this.value">
                            <option style="display:none" value="" disabled selected><?php echo $res_data[$server_group]['name_servers']?></option>
                            <?php for ($b = 0;$b < $p_count;$b++) { if($Player_found[$b] != ''){ ?>
                                <option value="<?php echo set_url_section( get_url( 2 ), 'server_group', $b )?>">
                                    <a href="<?php echo set_url_section( get_url( 2 ), 'server_group', $b )?>"><?php echo $res_data[$b]['name_servers']?></a></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
            <div class="profile">
                <div class="col-md-12">
                <div class="left-block">
                    <div class="user-block">
                            <?php if( $General->arr_general['avatars'] == 1 ) {?><script>CheckAvatar = <?php echo $General->checkAvatar($General->steam32to64($Player[$server_group]['steam']),1)?>;if(CheckAvatar == 1) {avatar.push("<?php echo $General->steam32to64( $Player[$server_group]['steam'] )?>");}</script><?php } ?>
                            <a href="<?php $res_data[$server_group]['steam'] == 1 && print 'https://steamcommunity.com/profiles/' . $General->steam32to64($Player[$server_group]['steam'])?>" target="_blank"><img id="<?php echo $General->steam32to64( $Player[$server_group]['steam'] )?>"class="rounded-circle avatar" data-src="
                            <?php if ( $General->arr_general['avatars'] == 1){ echo $General->getAvatar( $General->steam32to64($Player[$server_group]['steam'] ), 1);
                                } elseif( $General->arr_general['avatars'] == 2 || $General->arr_general['avatars'] == 0) {
                                    echo 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';
                                }?>"></a>
                            <div class="name"><?php echo action_text_clear( action_text_trim($Player[$server_group]['name'],16) )?></div>
                            <div class="country">-</div>
                            <img class="rank-img" src="storage/cache/img/ranks/<?php echo $General->arr_general['ranks_pack'] . '/'; if($Player[$server_group]['rank'] == ''){echo '00';}else{echo $Player[$server_group]['rank'];}?>.png">
                            <div class="rank"><?=$Modules->get_translate_phrase('_Rank_' . $Player[$server_group]['rank'])?></div>
                        <div class="user-stats">Игрок</div>
                    </div>
                <div class="best-weapon-block">
                    <ul class="weapons">
                        <?php for ( $i = 0; $i < 3; $i++ ):?>
                        <li>
                            <?php $General->get_icon('custom', $max_weapons[ $i ]['name'], 'weapons')?>
                            <div class="kills"><span><?php echo $max_weapons[ $i ]['kills']?></span></div>
                        </li>
                        <?php endfor; ?>
                    </ul>
                    <div class="weapon-table">
                    <table class="table table-hover fixed_header">
                        <thead>
                        <tr>
                            <th class="text-right"></th>
                            <th class="text-left">Оружие</th>
                            <th class="text-center">Убийства</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $weapon_names = array_keys($Player[$server_group]['weapons']);$count_w = count($Player[$server_group]['weapons']);for ($w = 0; $w < $count_w; $w++) {?>
                            <tr>
                                <th class="text-right"><?php $General->get_icon( 'custom', $weapon_names[$w], 'weapons' )?></th>
                                <th class="text-left"><?php echo str_replace('_',' ',mb_strtoupper(str_replace('weapon_','',$weapon_names[$w])))?></th>
                                <th class="text-center"><?php echo $Player[$server_group]['weapons'][$weapon_names[$w]] ?> kills</th>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                        </div>
                </div>
                <div class="short-stats-block">
                    <div class="left-stats-block">
                        <ul>
                            <li><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Total_winning_percentage')?></li>
                            <li><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Ratio_KD')?></li>
                            <li><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Ratio_SH')?></li>
                            <li><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Game_time')?></li>
                            <li><?php echo $Modules->get_translate_phrase('_Headshot')?>:</li>
                            <li><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_First_round_kills')?></li>
                        </ul>
                    </div>
                    <div class="right-stats-block">
                        <ul>
                            <li><span><? $procent=round($Player[$server_group]['round_lose']/100, 1); if($procent == ''){echo '0';}else{echo round($Player[$server_group]['round_win']/$procent, 1);}?>% (<?php echo $Player[$server_group]['round_win']?> / <?php echo $Player[$server_group]['round_lose']?>)</span></li>
                            <li><span><?php if($Player[$server_group]['kills'] == '' || $Player[$server_group]['deaths'] == ''){echo '0';}else{echo round($Player[$server_group]['kills']/$Player[$server_group]['deaths'], 2);}?> (<?=$Player[$server_group]['kills']?> / <?=$Player[$server_group]['deaths']?>)</span></li>
                            <li><span><? $procent=round($Player[$server_group]['shoots']/100, 1); if($procent == ''){echo '0';}else{echo round($Player[$server_group]['hits']/$procent, 1);}?>% (<?php echo $Player[$server_group]['hits']?> / <?php echo $Player[$server_group]['shoots']?>)</span></li>
                            <li><span><?php echo round($Player[$server_group]['playtime'] /60 /60) , ' ' , $Modules->get_translate_phrase('_Hour')?></span></li>
                            <li><span><?php echo str_replace(";","",$Player[$server_group]['headshots'])?><? if($Player[$server_group]['headshots'] == ''){echo '0';}?> (<? $procent=round($Player[$server_group]['kills']/100, 1); if($procent == ''){echo '0';}else{echo round($Player[$server_group]['headshots']/$procent, 1);}?>%)</span></li>
                            <li><span>-</span></li>
                        </ul>
                    </div>
                    <div class="skull-block">
                        <div class="left-skull-block">
                            <div class="skull"></div>
                            <div class="info"><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Triple_Kills')?> <span></span>-</div>
                        </div>
                        <div class="center-skull-block">
                            <div class="skull"></div>
                            <div class="info"><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Quad_kills')?> <span></span>-</div>
                        </div>
                        <div class="right-skull-block">
                            <div class="skull"></div>
                            <div class="info"><?php echo $Modules->get_translate_module_phrase( 'module_page_profiles','_Ace')?> <span></span>-</div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="middle-block">
                    <div class="up_block">
                    <div class="best-maps">
                        <div class="map-top">
                            <img src="storage/cache/img/maps/<?php echo $res_data[$server_group]['mod']?>/de_mirage.jpg">
                            <div class="map-lower">
                                <div class="map-one"><span>1</span></div>
                                <div class="map-pretty-name"><span>MIRAGE</span></div>
                                <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                            </div>
                        </div>
                        <ul class="map-bottom">
                            <li>
                            <img src="storage/cache/img/maps/<?php echo $res_data[$server_group]['mod']?>/de_dust2.jpg">
                            <div class="map-lower">
                                <div class="map-one"><span>2</span></div>
                                <div class="map-pretty-name"><span>DUST 2</span></div>
                                <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                            </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $res_data[$server_group]['mod']?>/de_train.jpg">
                                <div class="map-lower">
                                    <div class="map-one"><span>3</span></div>
                                    <div class="map-pretty-name"><span>TRAIN</span></div>
                                    <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                                </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $res_data[$server_group]['mod']?>/de_inferno.jpg">
                                <div class="map-lower">
                                    <div class="map-one"><span>4</span></div>
                                    <div class="map-pretty-name"><span>INFERNO</span></div>
                                    <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                                </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $res_data[$server_group]['mod']?>/de_nuke.jpg">
                                <div class="map-lower">
                                    <div class="map-one"><span>5</span></div>
                                    <div class="map-pretty-name"><span>NUKE</span></div>
                                    <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                        <div class="hitstats-block">
                            <div class="hitstats">
                                <img class="back" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/back' ?>.jpg">
                                <div class="hit_player">
                                    <a class="tooltip-top" data-tooltip="% hits - Head - -%"><img class="hit_head" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/head' ?>.png"></a>
                                    <a class="tooltip-top" data-tooltip="% hits - Left Arm - -%"><img class="hit_left_arm" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/left_arm' ?>.png"></a>
                                    <a class="tooltip-top" data-tooltip="% hits - Right Arm - -%"><img class="hit_right_arm" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/right_arm' ?>.png"></a>
                                    <a class="tooltip-top" data-tooltip="% hits - Left Leg - -%"><img class="hit_left_leg" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/left_leg' ?>.png"></a>
                                    <a class="tooltip-top" data-tooltip="% hits - Right Leg - -%"><img class="hit_right_leg" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/right_leg' ?>.png"></a>
                                    <a class="tooltip-top" data-tooltip="% hits - Body - -%"><img class="hit_body" ondrag="return false" ondragstart="return false" src="<?php echo CACHE . 'img/hitstats/body' ?>.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-block">
                    <div class="top">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Rating')?></th>
                                <th class=""><?php echo $Modules->get_translate_phrase('_Player')?></th>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Point')?></th>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Rank')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $top = $Player[$server_group]['top']-6;for ($ti = 0; $ti < 11; $ti++) {?>
                                <tr class="pointer <?php if($Player[$server_group]['steam'] == $Player_top[$server_group][$ti]['steam']){echo 'table-active';}?>" onclick="location.href = '<?=$General->arr_general['site']?>?page=profiles&server_group=<?php echo $server_group?>&profile=<?=$Player_top[$server_group][$ti]['steam']?>';">
                                    <th class="text-center">#</th>
                                    <th class="table-text"><?php echo action_text_trim($Player_top[$server_group][$ti]['name'],16)?></th>
                                    <th class="text-center"><?php echo $Player_top[$server_group][$ti]['value']?></th>
                                    <th class="text-center table-text"><img data-src="<? echo 'storage/cache/img/ranks/' . $General->arr_general['ranks_pack'] . '/'; if($Player_top[$server_group][$ti]['rank'] == ''){echo '00';}else{echo $Player_top[$server_group][$ti]['rank'];}?>.png"></th>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
    </div>