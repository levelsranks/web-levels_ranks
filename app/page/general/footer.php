<footer class="footer"><?php echo date("Y") ?> &copy; <a href="https://github.com/levelsranks/levels-ranks-web" target="_blank">Levels Ranks - Web Interface</a> #<?php echo VERSION?> by <a href="https://steamcommunity.com/id/M0st1ce/" target="_blank">M0st1ce</a></footer></div></div>
    <script src="<?php echo $General->arr_general['site'] ?>/storage/assets/js/vendors/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $General->arr_general['site'] ?>/storage/assets/js/vendors/jquery/jquery-ui.min.js"></script>
    <script>let domain = '<?php echo $General->arr_general['site'] ?>';</script>
<?php if( empty( $General->arr_general['enable_js_cache'] ) ) :
        for ( $js = 0, $js_s = sizeof( $Modules->js_library ); $js < $js_s; $js++ ):?>
    <script src="<?php echo $General->arr_general['site'] . $Modules->js_library[ $js ]?>"></script>
<?php   endfor;
if( ! empty( $Modules->arr_module_init['page'][ $Modules->route ]['js'] ) ):
    for ( $js = 0, $js_s = sizeof( $Modules->arr_module_init['page'][ $Modules->route ]['js'] ); $js < $js_s; $js++ ):?>
        <script src="<?php echo $General->arr_general['site'] . 'app/modules/' . $Modules->arr_module_init['page'][ $Modules->route ]['js'][ $js ]['name'] . '/assets/js/' . $Modules->arr_module_init['page'][ $Modules->route ]['js'][ $js ]['type'] . '.js'?>"></script>
    <?php if(isset($Modules->template_modules)):
    if(isset($Modules->template_modules[ $Modules->arr_module_init['page'][ $Modules->route ]['js'][ $css ]['name'] ][ 'js' ])) { ?>
        <script src="<?php echo $General->arr_general['site'] . 'app/templates/' . $General->arr_general['theme'] . '/modules/' . $Modules->arr_module_init['page'][ $Modules->route ]['js'][ $css ]['name'] . '/dop.js'; ?>"></script>
    <?php }
    endif;endfor;
endif;
      else:?>
    <script src="<?php echo ! file_exists( ASSETS_JS . '/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver'] . '.js' ) ? $General->arr_general['site'] . 'storage/assets/js/app' :  $General->arr_general['site'] . 'storage/assets/js/generation/app_generated.min.ver.' . $Modules->actual_library['actual_js_ver']?>.js"></script>
<?php endif;

if(!empty($General->notes)):
    for($i = 0; $i < sizeof($General->notes); $i++)
        echo "<script>note({content: '".$General->notes[$i]['content']."',type: '".$General->notes[$i]['status']."',time: ".$General->notes[$i]['time']."});</script>";
endif;

// Дополнительный пулл под модули, которые должны быть объявлены на каждой странице - inbodyend
if( ! empty( $Modules->arr_module_init['interface_always']['inbodyend'] ) ):
    for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['interface_always']['inbodyend'] ); $module_id < $c_mi; $module_id++ ):
        $file = MODULES . $Modules->arr_module_init['interface_always']['inbodyend'][ $module_id ]['name'] . '/forward/interface_always.php';
        file_exists( $file ) && require $file;
    endfor;
endif;

// Подгрузка данных из модулей которые относятся к интерфейсу - inbodyend
if( ! empty( $Modules->arr_module_init['page'][ $Modules->route ]['interface']['inbodyend'] ) ):
    for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['page'][ $Modules->route ]['interface']['inbodyend'] ); $module_id < $c_mi; $module_id++ ):
        $file = MODULES . $Modules->arr_module_init['page'][ $Modules->route ]['interface']['inbodyend'][ $module_id ] . '/forward/interface.php';
        file_exists( $file ) && require $file;
    endfor;
endif?>
</body>
<?php
// Дополнительный пулл под модули, которые должны быть объявлены на каждой странице - afterbody
if( ! empty( $Modules->arr_module_init['interface_always']['afterbody'] ) ):
    for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['interface_always']['afterbody'] ); $module_id < $c_mi; $module_id++ ):
        $file = MODULES . $Modules->arr_module_init['interface_always']['afterbody'][ $module_id ]['name'] . '/forward/interface_always.php';
        file_exists( $file ) && require $file;
    endfor;
endif;

// Подгрузка данных из модулей которые относятся к интерфейсу - afterbody
if( ! empty( $Modules->arr_module_init['page'][ $Modules->route ]['interface']['afterbody'] ) ):
    for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['page'][ $Modules->route ]['interface']['afterbody'] ); $module_id < $c_mi; $module_id++ ):
        $file = MODULES . $Modules->arr_module_init['page'][ $Modules->route ]['interface']['afterbody'][ $module_id ] . '/forward/interface.php';
        file_exists( $file ) && require $file;
    endfor;
endif?>
</html>