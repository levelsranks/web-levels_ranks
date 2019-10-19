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
    <div class="col-md-4 col-fixed">
        <div class="card">
            <div class="card-block-big">
                <div class="figure"></div>
                <div class="figure_2"></div>
                <h3><?php echo number_format( $data['module_block_main_stats']['Total_players'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_module_phrase( 'module_block_main_stats', '_Total_players' ) ?></div>
                <i class="icon-stats"><?php $General->get_icon( 'zmdi', 'accounts-alt', null ) ?></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-fixed">
        <div class="card">
            <div class="card-block-big">
                <div class="figure"></div>
                <div class="figure_2"></div>
                <h3><?php echo number_format( $data['module_block_main_stats']['Players_24h'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_module_phrase( 'module_block_main_stats', '_Players_24_hours' ) ?></div>
                <i class="icon-stats"><?php $General->get_icon( 'zmdi', 'star', null ) ?></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-fixed">
        <div class="card">
            <div class="card-block-big">
                <div class="figure"></div>
                <div class="figure_2"></div>
                <h3><?php echo number_format( $data['module_block_main_stats']['Headshot'], 0, '.', ' ' ) ?></h3>
                <div class="info"><?php echo $Translate->get_translate_phrase( '_Headshot' ) ?></div>
                <i class="icon-stats"><?php $General->get_icon( 'zmdi', 'fire', null ) ?></i>
            </div>
        </div>
    </div>
</div>