<footer class="footer"><?php echo date("Y") ?> &copy; <a href="https://github.com/levelsranks/levels-ranks-web" target="_blank">Levels Ranks - Web Interface</a> #<?php echo VERSION?> by <a href="https://steamcommunity.com/id/M0st1ce/" target="_blank">M0st1ce</a></footer></div></div>
    <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<?php if( empty( $General->arr_general['enable_js_cache'] ) ) :
        for ( $js = 0, $js_s = sizeof( $Modules->js_library ); $js < $js_s; $js++ ):?>
    <script src="<?php echo $General->arr_general['site'] . $Modules->js_library[ $js ]?>"></script>
<?php   endfor;
      else:?>
    <script src="<?php echo ! file_exists( ASSETS_JS . '/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver'] . '.js' ) ? $General->arr_general['site'] . 'storage/assets/js/app' :  $General->arr_general['site'] . 'storage/assets/js/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver']?>.js"></script>
<?php endif; ?>
</body>
</html>