<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

/**
 * A-a-aye, I'm on vacation
 * Every single day cause I love my occupation
 * A-a-aye, I'm on vacation
 * If you don't like your life, then you should go and change it
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Rank_stats') ?></h5>
                <div class="select-panel select-panel-table badge">
                    <select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled selected><?php echo $Db->statistics_table[ $server_group ]['name'] ?></option>
                        <?php for ( $b = 0; $b < $Db->table_statistics_count; $b++ ):?>
                            <option value="<?php echo set_url_section( get_url(2), 'server_group', $b ) ?>">
                                <a href="<?php echo set_url_section( get_url(2), 'server_group', $b ) ?>"><?php echo $Db->statistics_table[ $b ]['name'] ?></a></option>
                        <?php endfor?>
                    </select>
                </div>
            </div>
            <div class="container-ranks">
                <?php for ( $i = 0, $count = sizeof( $data['module_page_rankstats']['data'][ $server_group ] ); $i < $count; $i++ ):
                    if( ! empty( $data['module_page_rankstats']['data'][ $server_group ][ $i ]['Percent'] ) && $data['module_page_rankstats']['data'][ $server_group ][ $i ]['Percent'] != 0 ):?>
                <div class="row-rank">
                    <div class="rank"><img src="<?php echo '../storage/cache/img/ranks/' . $Db->statistics_table[ $server_group ]['ranks_pack'] . '/' . $data['module_page_rankstats']['data'][ $server_group ][ $i ]['rank'] ?>.png"></div>
                    <div class="line">
                        <div class="i" style="width:<?php echo $data['module_page_rankstats']['data'][ $server_group ][ $i ]['Percent'] ?>%"></div>
                        <div class="value" ><?php echo $data['module_page_rankstats']['data'][ $server_group ][ $i ]['Percent'] ?>%</div>
                    </div>
                </div>
                <?php endif;
                endfor;?>
            </div>
            </div>
            </div>
            </div>