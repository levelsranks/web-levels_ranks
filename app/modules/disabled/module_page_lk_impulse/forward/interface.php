<?php
/**
 * @author SAPSAN 隼 #3604
 *
 * @link https://hlmod.ru/members/sapsan.83356/
 * @link https://github.com/sapsanDev
 *
 * @license GNU General Public License Version 3
 */
if( IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit;}
$Gateways = $LK->LkGetGatewaysOn();
if(isset( $_SESSION['user_admin'] )):?>
<aside class="sidebar-right unshow">
    <section class="sidebar">
        <div class="user-sidebar-right-block">
            <div class="info">
                <div class="details">
                    <div class="admin_type"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Chief_admin')?></div>
                    <div class="admin_rights"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_All_access_rights')?></div>
                </div>
            </div>
        </div>
        <div class="card menu">
            <ul class="nav">
                <li <?php get_section( 'section', 'gateways' ) == 'users' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','users')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_UsersList')?></a>
                </li>
                <li <?php get_section( 'section', 'gateways' ) == 'gateways' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','gateways')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SettingsGateways')?></a>
                </li>
                <li <?php get_section( 'section', 'gateways' ) == 'payments' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','payments')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_PaymentsList')?></a>
                </li>
                <li <?php get_section( 'section', 'gateways' ) == 'promocodes' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','promocodes')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Promo')?></a>
                </li>
                <li <?php get_section( 'section', 'gateways' ) == 'logs' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','logs')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Logs')?></a>
                </li>
            </ul>
        </div>
    </section>
</aside>
<?php endif;
if(!empty($_GET['section']) && isset($_SESSION['steamid32'])):?>
    <div class="row">
        <?php switch ( $_GET['section']):
            case $_GET['section']:
                require MODULES . 'module_page_lk_impulse/includes/'.$_GET['section'].'.php';
                break;
        endswitch;?>
</div>
<?php else:?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><i class="zmdi zmdi-money zmdi-hc-fw"></i> <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LK')?></h5>
                <div style="position: absolute;top: 15px;right: 15px;text-align: center;" id="profile"></div>
            </div>
                    <div class="col-10 col-md-8 align-center">
                        <form id="pay" data-default="true" enctype="multipart/form-data" method="post">
                        <?php if(!empty($Gateways)):
                                if(COUNT($Gateways)>1 || $Gateways[0]['id'] == 5):?>
                                <div class="input-form text-center"><div style="margin-bottom: 10px;" class="input_text text-left"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ChangeGateway')?></div>
                                <?php foreach($Gateways as $info):?>
                                    <input type="radio" name="gatewayPay" value="<?php echo mb_strtolower($info['name_kassa'])?>" id="Gateway<?=$info['id']?>" class="gateways">
                                    <label for="Gateway<?=$info['id']?>" style="background: url('<?php echo $General->arr_general['site'] . MODULES ?>module_page_lk_impulse/assets/gateways/<?php echo mb_strtolower($info['name_kassa'])?>.svg') no-repeat;background-position: center;" class="gateways-label"></label>
                                    <?php if(mb_strtolower($info['name_kassa']) == 'yandexmoney' && empty($PCYM)):?>
                                    <input type="radio" name="gatewayPay" value="yandexmoneycard" id="Gateway99" class="gateways">
                                    <label for="Gateway99" style="background: url('<?php echo $General->arr_general['site'] . MODULES ?>module_page_lk_impulse/assets/gateways/yandexmoneycard.svg') no-repeat;background-position: center;" class="gateways-label"></label>

                                <?php $PCYM=1; endif; endforeach?>
                                </div>
                                <?php else:?>
                                <input type="hidden" name="gatewayPay" value="<?php echo mb_strtolower($Gateways[0]['name_kassa'])?>">
                                <?php endif;
                             endif;?>
                        <?php if(isset($_SESSION['steamid32'])):?>
                             <input type="hidden" name="steam" value="<?php echo $_SESSION['steamid32']?>" >
                        <?php else:?>
                            <div class="input-form"><div class="input_text">STEAM ID:</div><input name="steam" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/... "></div>
                        <?php endif?>
                        <div class="input-form">
                            <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ToUpAmount')?></div>
                            <input name="amount">
                        </div>
                        <div class="input-form">
                            <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Promo')?></div>
                            <input name="promocode">
                        </div>
                        <div class="input-form" id="promoresult"></div>
                         </form>
                    </div>
                    <div class="card-bottom text-center padding-botom-20">
                        <input class="btn" form="pay" type="submit" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ButtonPay')?>"></h5>
                    </div>
                    <br>
                    <div  style="display: none;" id="resultForm"></div>
        </div>
    </div>
</div>
<?php endif?>

<style type="text/css">
    .input-form
    {
        margin-bottom: 25px;
    }
</style>
