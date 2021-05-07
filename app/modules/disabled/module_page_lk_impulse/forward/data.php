<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

use app\modules\module_page_lk_impulse\ext\Lk_module;

if( IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }

$LK = new Lk_module( $Translate, $Notifications, $General, $Modules, $Db);

if(isset($_POST['steam']))
{
    $LK->LkOnPayment($_POST); exit;
}
else if(!empty($_POST['promocode']) && !empty($_POST['amount']) && !empty($_POST['steamid']))
{
    $LK->LkCalculatePromo($_POST['promocode'], $_POST['steamid'], $_POST['amount']);exit;
}
else if(isset($_POST['steamidload']))
{
    $LK->LkLoadPlayerProfile($_POST['steamidload']); exit;
}

if(isset( $_SESSION['user_admin'] )  && isset($_GET['section']))
{

    switch ($_GET['section']) {
        case 'users':
             if(isset($_POST['user']))
            {
                $LK->LkUpdateBalance($_POST);exit;
            }
            else if(isset($_POST['users_clean']))
            {
                $LK->LkDelUsers();exit;
            }
            else if(isset($_POST['search_users']))
            {
               $LK->SearchUser($_POST['search_users']);
            }
            define('PLAYERS_ON_PAGE', '10');
            $page_num = get_section( 'num', '1' );
            $page_max = $LK->UsersPageMax(PLAYERS_ON_PAGE);
            $page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;
            $playersAll = $LK->LkGetAllPlayers($page_num_min, PLAYERS_ON_PAGE);
        break;
        case 'gateways':
            if(!empty($_POST['gateway']))
            {
                $LK->LkAddGateway($_POST); exit;
            }
            else if(isset($_POST['gateway_edit']))
            {
                $LK->LkEditGateway($_POST); exit;
            }
            else if(isset($_POST['chart']))
            {
                $LK->LkChart(); exit;
            }
            else if(isset($_POST['gateway_delete']))
            {
                $LK->LkDeleteGateway($_POST); exit;
            }
            else if(isset($_POST['webhoock_url']))
            {
                $LK->LkAddDiscord($_POST); exit;
            }
        break;
        case 'promocodes':
            if(isset($_POST['addpromo']))
            {
                $LK->LkAddPromocode($_POST); exit;
            }
            else if(isset($_POST['editid']))
            {
                $LK->LkEditPromocode($_POST); exit;
            }
            else if(isset($_POST['promocode_delete']))
            {
                $LK->LkDeletePromocode($_POST); exit;
            }
        break;
        case 'logs':
            if(isset($_POST['clean_logs']))
            {
                $LK->LkCleanLogs();exit;
            }
            else if(isset($_POST['log_delete']))
            {
                $LK->LkLogdelete($_POST['log_delete']);exit;
            }
            else if(isset($_POST['log_download']))
            {
                $LK->LkDownloadLog($_POST['log_download']);
            }
        break;
        case 'search':
            if(isset($_POST['search_users']))
            {
               $LK->SearchUser($_POST['search_users']);
            }
            else  if(isset($_POST['user']))
            {
                $LK->LkUpdateBalance($_POST);exit;
            }
        break;
    }
}

if(!empty($_GET['gateway'])){
    require MODULES.'module_page_lk_impulse/includes/result.php';
    exit;
}

if(empty($Db->db_data['lk']))
{
    require MODULES.'module_page_lk_impulse/includes/install.php';
    exit;
}

//Проверка в базе данных наличие таблиц.
if(isset($Db->db_data['lk'])){
    if($Db->db_data['lk'][0]['mod'] == 1)
        $tableLk = 'lk';
    else if($Db->db_data['lk'][0]['mod'] == 2)
        $tableLk = 'lk_system';
    
    $checkTable =  array(
        $tableLk,
        'lk_discord',
        'lk_logs',
        'lk_pays',
        'lk_pay_service',
        'lk_promocodes',
    );
    foreach ($checkTable as $key) {
       if(!$Db->mysql_table_search('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], $key))
       {
           require MODULES.'module_page_lk_impulse/includes/install.php';
            exit;
        }
    }
}

$LK->LkBalancePlayer();

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_module_phrase('module_page_lk_impulse','_LK'));

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_module_phrase('module_page_lk_impulse','_LK') . ' :: ' . $Translate->get_translate_module_phrase('module_page_lk_impulse','_DescPageLK'));
