<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */

if( !isset( $_SESSION['user_admin'] ) || IN_LR != true ) { header('Location: ' . $General->arr_general['site'] ); exit; }

// задаём основную кодировку страницы.
header('Content-Type: text/html; charset=utf-8');

// Отключаем показ ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

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
       if(!$Db->mysql_table_search('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], $key)){
            $table[$key] = 1;
        }
    }
}

// Проверка соединения с базой данных.
if(isset($_POST['db_check'])) {
    $con = mysqli_connect($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['db_1']);
    if ( $con ) {
        $db_check = 2;
    } else {
        $db_check = 1;
    }
    mysqli_close($con);
}

// Сохранение настроек базы данных
if( isset( $_POST['save_db'] ) ) {
    $dblk = ['lk' => [['HOST' => $_POST['host'], 'USER' => $_POST['user'], 'PASS' => $_POST['pass'], 'DB' => [['DB' => $_POST['db_1'], 'Prefix' => [['table' => $_POST['table'], 'mod' => $_POST['lk_mod']]]]]]]];
    $Config = file_get_contents( SESSIONS . '/db.php');
    $ConfigReplace = str_replace("];", "", $Config);
    $ConfigReplacePUT = substr(var_export_opt( $dblk, true ),1);
    file_put_contents( SESSIONS . '/db.php', $ConfigReplace.$ConfigReplacePUT.";" );
    header("Refresh:2");
}

// Установка таблиц в базу данных
if( isset( $_POST['table_install'] ) ) {
        if($Db->db_data['lk'][0]['mod'] == 1)
            $tableLkCreate = "CREATE TABLE IF NOT EXISTS `lk` ( `auth` VARCHAR(64) NOT NULL , `name` VARCHAR(64) NOT NULL , `cash` FLOAT NOT NULL , `all_cash` FLOAT NOT NULL ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
        else if($Db->db_data['lk'][0]['mod'] == 2)
            $tableLkCreate = "CREATE TABLE IF NOT EXISTS `lk_system` ( `auth` VARCHAR(64) NOT NULL , `name` VARCHAR(64) NOT NULL , `money` FLOAT NOT NULL , `all_money` FLOAT NOT NULL ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
        $sql = array(
          $tableLkCreate,
          "CREATE TABLE IF NOT EXISTS `lk_discord` (`url` TEXT NOT NULL , `auth` INT NOT NULL DEFAULT '0' ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",
          "INSERT INTO `lk_discord`(`url`, `auth`) VALUES ('',0)",
          "CREATE TABLE IF NOT EXISTS `lk_logs` (`log_id` INT NOT NULL AUTO_INCREMENT , `log_name` TEXT NOT NULL , `log_value` TEXT NOT NULL , `log_time` TEXT NOT NULL , `log_content` TEXT NOT NULL , PRIMARY KEY (`log_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",
          "CREATE TABLE IF NOT EXISTS `lk_pays` ( `pay_id` INT NOT NULL AUTO_INCREMENT , `pay_order` INT NOT NULL , `pay_auth` TEXT NOT NULL , `pay_summ` FLOAT NOT NULL , `pay_data` TEXT NOT NULL , `pay_system` TEXT NOT NULL , `pay_promo` TEXT NOT NULL , `pay_status` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`pay_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",
          "CREATE TABLE IF NOT EXISTS `lk_pay_service` ( `id` INT NOT NULL , `name_kassa` TEXT NOT NULL , `shop_id` TEXT NOT NULL , `secret_key_1` TEXT NOT NULL , `secret_key_2` TEXT NOT NULL , `status` INT NOT NULL DEFAULT '0' ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",
          "CREATE TABLE IF NOT EXISTS `lk_promocodes` ( `id` INT NOT NULL AUTO_INCREMENT , `code` TEXT NOT NULL , `percent` FLOAT NOT NULL , `attempts` INT NOT NULL , `auth1` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;",
        );
        foreach($sql as $key){
            $Db->query('lk', $Db->db_data['lk'][0]['USER_ID'], $Db->db_data['lk'][0]['DB_num'], $key);
        }
        header("Location: ".get_url(2)."?page=lk&section=gateways");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Добро пожаловать в мастер установки LR!</title>
</head>
<link rel="stylesheet" href="storage/assets/css/themes/mainstream_white/style.css">
<style>
    :root <?php echo str_replace( ',', ';', str_replace( '"', '', file_get_contents_fix ( 'storage/assets/css/themes/mainstream_white/palettes/dark_mode_palette.json' ) ) )?>
</style>
<style>
    .badge {
        display: inline-block;
        padding: .35em .6em;
        font-size: 75%;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        fill: #ffffff;
        color: #ffffff!important;
        background-color: var(--span-color);
        box-shadow: var(--span-color-back) 5px 5px;
    }

    .badge a {
        fill: #ffffff;
        color: #ffffff!important;
        transition-duration: 400ms;
    }

    .input-form 
    {
        position: relative;
        text-align: left;
        margin-top: 6px;
        margin-bottom: 6px;
        width: 100%;
    }

    .btn 
    {
        margin-top: 12px;
        float: right;
    }

    .container-fluid 
    {
        width: 100%;
        padding-top: 0px;
    }

    .card 
    {
        margin-bottom: 17px;
    }
    .lds-ellipsis 
    {
      display: inline-block;
      position: relative;
      width: 55px;
      height: 14px;
    }
    .lds-ellipsis div 
    {
      position: absolute;
      top: 5px;
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: #fff;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }
    .lds-ellipsis div:nth-child(1) 
    {
      left: 6px;
      animation: lds-ellipsis1 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(2) 
    {
      left: 6px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(3) 
    {
      left: 26px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(4) 
    {
      left: 45px;
      animation: lds-ellipsis3 0.6s infinite;
    }
    @keyframes lds-ellipsis1 {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }
    @keyframes lds-ellipsis3 {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(0);
      }
    }
    @keyframes lds-ellipsis2 {
      0% {
        transform: translate(0, 0);
      }
      100% {
        transform: translate(19px, 0);
      }
    }

</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LKInstall')?></h5>
                </div>
                <?php if(!empty($table)):?>
                    <div class="card-container option_one">
                        <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_InstallTable')?> <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LK')?></h5><br>
                        <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ForWork')?><br>
                        <?php foreach($table as $tableKey => $val):?>
                            <b>`<?php echo $tableKey?>`</b><br>
                        <?php endforeach;?>
                        <form enctype="multipart/form-data" method="post">
                            <input class="btn" name="table_install" type="submit" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_InstallBTN')?>">
                        </form>
                    </div>
               <?php else :?>
                <div class="card-container option_one">
                    <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SettingsBD')?></h5><br>
                    <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LKForInstall')?> <a href="https://hlmod.ru/resources/lichnyj-kabinet-1mpulse-core-modules.887/"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LK')?></a>
                    <form id="db_check" enctype="multipart/form-data" method="post">
                    <div class="input-form"><div class="input_text">Host: </div><input name="host" value="<?php echo $_POST['host']?>"></div>
                        <div class="input-form"><div class="input_text">User: </div><input name="user" value="<?php echo $_POST['user']?>"></div>
                        <div class="input-form"><div class="input_text">Pass: </div><input name="pass" value="<?php echo $_POST['pass']?>"></div>
                        <div class="input-form"><div class="input_text">DB: </div><input name="db_1" value="<?php echo $_POST['db_1']?>"></div>
                        <div class="input-form"><div class="input_text">Table: </div><input placeholder="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Example')?>: lk" name="table" value="<?php echo $_POST['table']?>"></div>
                        <div class="input-form"><div class="input_text">LK mod</div>
                            <select name="lk_mod">
                                <option value="1">LK Impulse</option>
                                <option value="2">LK McD4CK</option>
                            </select>
                        </div>
                    </form>
                    <?php if ( $db_check != 2 ):?>
                    <input class="btn" name="db_check" type="submit" form="db_check" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_DBCheckBTN')?>">
                    <?php elseif( $db_check == 2 ):?>
                        <input class="btn" name="save_db" type="submit" form="db_check" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_NextBTN')?>">
                    <?php endif;?>
                </div>
        <?php endif;?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Information')?></h5>
                    <ul class="right-area" style="right: 30px;top: 20px;">
                        <li class="section">
                            <a href="#" class="navbar-icon">
                                <?php $General->get_icon( 'custom', 'translate', 'global' )?>
                            </a>
                            <ul class="subsection">
                                <li>
                                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'RU' )?>'">
                                        <?php $General->get_icon( 'custom', 'ru', 'flags' )?> <?php echo $Translate->get_translate_phrase( '_RU' )?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'EN' )?>'">
                                        <?php $General->get_icon( 'custom', 'en', 'flags' )?> <?php echo $Translate->get_translate_phrase( '_EN' )?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'UA' )?>'">
                                        <?php $General->get_icon( 'custom', 'ua', 'flags' )?> <?php echo $Translate->get_translate_phrase( '_UA' )?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'LT' )?>'">
                                        <?php $General->get_icon( 'custom', 'lt', 'flags' )?> <?php echo $Translate->get_translate_phrase( '_LT' )?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="card-container">
                    <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Php')?> <?php if( PHP_VERSION >= '7' ) { echo '<div class="color-green">'  . PHP_VERSION . '</div>';} else { echo '<div class="color-red">'  . PHP_VERSION . '</div>
                    <div>'.$Translate->get_translate_module_phrase('module_page_lk_impulse','_PhpRecomendation').'</div>';} ?>
                    <div>cURL:</div>
                    <?php if (in_array ('curl', get_loaded_extensions())):?>
                          <span style="color:#4fa361;">installed</span>
                          <?php  else :?>
                           <span style="color:#dc4f49">not installed</span>
                     <?php endif; ?>
                    <?php if ( $db_check == 1 ):?>
                        <div><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_DBCheckConnect')?></div>
                    <?php elseif( $db_check == 2 ): ?>
                        <div><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_DBCheckConnectSucc')?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $('.btn').click(function(){
        setTimeout(function(){
        $('.btn').replaceWith('<div class="btn"></div>');
           $(".btn").append('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
       },100);
    });
</script>
</body>
</html>
