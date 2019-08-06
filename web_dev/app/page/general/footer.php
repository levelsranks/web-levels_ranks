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
<footer class="footer"><?php echo date("Y") ?> &copy; <a href="https://github.com/levelsranks/levels-ranks-web">Levels Ranks - Web Interface</a> #<?php echo VERSION?> by <a href="https://steamcommunity.com/id/M0st1ce/">M0st1ce</a></footer></div></div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="<?php echo $General->arr_general['site']?>/storage/assets/js/app.js"></script>
<?php if ( ! empty( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['js'] ) ):
for ( $i = 0, $c = get_arr_size( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['js'] ); $i < $c; $i++ ):
    require MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['js'][ $i ] . '/assets/js.php';
endfor;
endif;?>
</body>
</html>