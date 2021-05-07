<body <?php $_SESSION['sidebar_open'] == false && print 'class="sidebar-collapse"'?>>
<?php 
    if(isset($_SESSION['steamid32']) && $Modules->route != 'lk' && isset($Db->db_data['lk'])){
        preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);
        $param = ['auth'=> '%'.$auth[0].'%'];
        if($Db->db_data['lk'][0]['mod'] == 1)
        {
            $infoUser =$Db->queryAll('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], "SELECT cash FROM lk WHERE auth LIKE :auth LIMIT 1", $param);
            $cash = 'cash';
        }
        else if($Db->db_data['lk'][0]['mod'] == 2)
        {
            $infoUser =$Db->queryAll('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], "SELECT money FROM lk_system WHERE auth LIKE :auth LIMIT 1", $param);
            $cash = 'money';
        }
        $Modules->set_user_info_text($Translate->get_translate_module_phrase('module_page_lk_impulse','_Balance').': '.$Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse').' <b class="material-balance">'.number_format($infoUser[0][$cash],0,' ', ' ').'</b>');
    }
?>