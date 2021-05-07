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
        <div class="row">
            <div class="col-md-4 col-fixed">
            <div class="card-block-sb-big">
                <h3><?php echo number_format( $data['module_block_main_sb_stats']['count_admins'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_module_phrase( 'module_block_main_sb_stats', '_Count_admins' ) ?></div>
                <div class="figure"></div>
                <div class="figure_2"></div>
            </div>
            </div>
            <div class="col-md-4 col-fixed">
            <div class="card-block-sb-big">
                <h3><?php echo number_format( $data['module_block_main_sb_stats']['count_bans'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_module_phrase( 'module_block_main_sb_stats', '_Count_bans' ) ?></div>
                <div class="figure"></div>
                <div class="figure_2"></div>
            </div>
            </div>
            <div class="col-md-4 col-fixed">
            <div class="card-block-sb-big">
                <h3><?php echo number_format( $data['module_block_main_sb_stats']['count_comms'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_module_phrase( 'module_block_main_sb_stats', '_Count_comms' ) ?></div>
            </div>
            </div>
        </div>
    </div>
    </div>
</div>