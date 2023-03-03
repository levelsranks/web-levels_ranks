<body <?php $_SESSION['sidebar_open'] == false && print 'class="sidebar-collapse"'?>>
<?php 
    $balance = $Modules->get_balance();
    if( $balance && $Modules->route != "lk" )
        $Modules->set_user_info_text($Translate->get_translate_module_phrase('module_page_lk_impulse','_Balance').': '.$Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse').' <b class="material-balance">'.$balance.'</b>');
?>