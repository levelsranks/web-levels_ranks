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
                <h5 class="badge">Профиль игрока :: <?php echo action_text_trim( $Player->get_name(),16 )?></h5>
                    <div class="select-panel select-panel-table badge">
                        <select onChange="window.location.href=this.value">
                            <option style="display:none" value="" disabled selected><?php echo $Player->found[  $Player->server_group  ]['name_servers']?></option>
                            <?php for ($b = 0, $_c = sizeof( $Player->found );$b < $_c;$b++) { if($Player->found[$b] != ''){ ?>
                                <option value="<?php echo set_url_section( get_url( 2 ), 'server_group', $b )?>">
                                    <a href="<?php echo set_url_section( get_url( 2 ), 'server_group', $b )?>"><?php echo $Player->found[$b]['name_servers']?></a></option>
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
                    <?php if( $General->arr_general['avatars'] == 1 ) {?><script>CheckAvatar = <?php echo $General->checkAvatar(con_steam32to64( $Player->get_steam_32() ),1)?>;if(CheckAvatar == 1) {avatar.push("<?php echo con_steam32to64(  $Player->get_steam_32()  )?>");}</script><?php } ?>
                    <a href="<?php $Player->found[  $Player->server_group  ]['steam'] == 1 && print 'https://steamcommunity.com/profiles/' . con_steam32to64( $Player->get_steam_32() )?>" target="_blank"><img id="<?php $General->arr_general['avatars'] == 1 && print con_steam32to64(  $Player->get_steam_32()  )?>"class="rounded-circle avatar" data-src="
                           <?php if ( $General->arr_general['avatars'] == 1){ echo $General->getAvatar( con_steam32to64( $Player->get_steam_32()  ), 1);
                           } elseif( $General->arr_general['avatars'] == 2 || $General->arr_general['avatars'] == 0) {
                               echo 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';
                           }?>"></a>
                    <div class="name"><?php echo action_text_clear( action_text_trim( $Player->get_name(), 16 ) )?></div>
                    <div class="country">-</div>
                    <img class="rank-img" src="storage/cache/img/ranks/<?php echo $General->arr_general['ranks_pack'] . '/' . $Player->get_rank()?>.png">
                    <div class="rank"><?php echo $Modules->get_translate_phrase('_Rank_' . $Player->get_rank())?></div>
                    <div class="user-stats">Игрок</div>
                </div>
                <div class="best-weapon-block">
                    <ul class="weapons">
                        <?php for ( $i = 0; $i < 3; $i++ ):?>
                        <li>
                            <?php $General->get_icon('custom', $Player->top_weapons[ $i ]['name'], 'weapons')?>
                            <div class="kills"><span><?php echo $Player->top_weapons[ $i ]['kills']?></span></div>
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
                        <?php $weapon_names = array_keys( $Player->weapons );$_c = count( $Player->weapons );for ($w = 0; $w < $_c; $w++) {?>
                            <tr>
                                <th class="text-right"><?php $General->get_icon( 'custom', $weapon_names[$w], 'weapons' )?></th>
                                <th class="text-left"><?php echo str_replace('_',' ',strtoupper(str_replace('weapon_','',$weapon_names[$w])))?></th>
                                <th class="text-center"><?php echo $Player->weapons[$weapon_names[$w]] ?> kills</th>
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
                            <li><span><?php echo $Player->get_percent_win()?></span></li>
                            <li><span><?php echo $Player->get_kd()?></span></li>
                            <li><span><?php echo $Player->get_percent_hits()?></span></li>
                            <li><span><?php echo $Player->get_playtime()?> <?php echo $Modules->get_translate_phrase('_Hour')?></span></li>
                            <li><span><?php echo $Player->get_percent_headshots()?></span></li>
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
                            <img src="storage/cache/img/maps/<?php echo $Player->found[ $Player->server_group ]['mod']?>/de_mirage.jpg">
                            <div class="map-lower">
                                <div class="map-one"><span>1</span></div>
                                <div class="map-pretty-name"><span>MIRAGE</span></div>
                                <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                            </div>
                        </div>
                        <ul class="map-bottom">
                            <li>
                            <img src="storage/cache/img/maps/<?php echo $Player->found[ $Player->server_group ]['mod']?>/de_dust2.jpg">
                            <div class="map-lower">
                                <div class="map-one"><span>2</span></div>
                                <div class="map-pretty-name"><span>DUST 2</span></div>
                                <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                            </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $Player->found[ $Player->server_group ]['mod']?>/de_train.jpg">
                                <div class="map-lower">
                                    <div class="map-one"><span>3</span></div>
                                    <div class="map-pretty-name"><span>TRAIN</span></div>
                                    <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                                </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $Player->found[ $Player->server_group ]['mod']?>/de_inferno.jpg">
                                <div class="map-lower">
                                    <div class="map-one"><span>4</span></div>
                                    <div class="map-pretty-name"><span>INFERNO</span></div>
                                    <div class="map-title-rounds">- <i class="icon"><?php $General->get_icon( 'custom', 'cup', 'global' )?></i></div>
                                </div>
                            </li>
                            <li>
                                <img src="storage/cache/img/maps/<?php echo $Player->found[ $Player->server_group ]['mod']?>/de_nuke.jpg">
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
                            <?php for ($ti = 0; $ti < 11; $ti++) {?>
                                <tr class="pointer <?php if( $Player->get_steam_32()  == $Player->top_with_player[$ti]['steam']){echo 'table-active';}?>" onclick="location.href = '<?php echo $General->arr_general['site']?>?page=profiles&server_group=<?php echo $Player->server_group ?>&profile=<?php echo $Player->top_with_player[$ti]['steam']?>';">
                                    <th class="text-center">#</th>
                                    <th class="table-text"><?php echo action_text_trim($Player->top_with_player[$ti]['name'],16)?></th>
                                    <th class="text-center"><?php echo $Player->top_with_player[$ti]['value']?></th>
                                    <th class="text-center table-text"><img src="<?php echo 'storage/cache/img/ranks/' . $General->arr_general['ranks_pack'] . '/'; empty( $Player->top_with_player[$ti]['rank'] ) ? print 0 : print $Player->top_with_player[$ti]['rank'];?>.png"></th>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>