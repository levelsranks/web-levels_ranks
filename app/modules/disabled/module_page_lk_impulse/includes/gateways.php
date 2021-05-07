<?php if( !isset( $_SESSION['user_admin'] ) || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }

$GatewaysArrayList = [
    'freekassa'     =>'FreeKassa MULTI',
    'webmoney'      =>'WebMoney MULTI',
    'qiwi'          =>'Qiwi P2P RUS',
    'unitpay'       =>'UnitPay',
    'interkassa'    =>'Interkassa MULTI',
    'robokassa'     =>'Robokassa MULTI',
    'yandexmoney'   =>'Yandex Money',
    'paypal'        =>'PayPal MULTI',
    //'g2apay'        =>'G2APay MULTI',
    //'paysera'       =>'Paysera',
    //'paysafecard'   =>'PAYSAFECard',
    //'payssion'      =>'Payssion MULTI'
];?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SettingsGateways')?></h5>
            <div style="float: right;position: relative;top: 30px;right: 25px;"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse', '_BalanceAllTime') ?>:
             <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse').$LK->LkAllDonats()?></div>
        </div>
        <div class="card-container">
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php foreach($LK->LkGetAllGateways() as $key):
                            $GatewaysExist[mb_strtolower($key['name_kassa'])]=1;?>
                            <li class="dd-item" >
                                <a class="module_setting" href="<?php echo set_url_section(get_url(2), 'geteway_edit', mb_strtolower($key['name_kassa']))?>"><i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                                <div class="dd-handle"><?php echo $key['name_kassa'];?>
                                    <div style="float: right;"><small><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AmountCourse').$LK->LkAllDonatsToPayGateway(mb_strtolower($key['name_kassa']));?></small></div>
                                </div>
                            </li>
                        <?php endforeach?>
                    </ol>
                </div>
        </div>
        <div class="asa" id="containerChart"></div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Options')?></h5>
        </div>
        <div class="card-container">
             <div class="select-panel badge">
                <select onChange="window.location.href=this.value">
                	 <option value="" disabled selected><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddGateways')?></option>
                     <?php foreach($GatewaysArrayList as $url => $name):
                        if(empty($GatewaysExist[$url])):?>
                        <option value="<?php echo set_url_section(get_url(2), 'gateway_add', $url) ?>">
                            <a href="<?php echo set_url_section(get_url(2), 'gateway_add', $url) ?>"><?php echo $name ?> </a></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>
            <div style="padding-top:15px;">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_DiscordMessage')?></h5>
                 <form id="webhook_discord" data-default="true" enctype="multipart/form-data" method="post">
                <div class="input-form"><div class="input_text">Webhook URL:</div><input name="webhoock_url" value="<?php $LK->LkDiscordData()['url'] && print $LK->LkDiscordData()['url'];?>"></div>
                <div class="input-form">
                    <input class="border-checkbox" type="checkbox" name="webhoock_url_offon" id="webhoock_url_offon" <?php $LK->LkDiscordData()['auth'] && print 'checked';?>>
                    <label class="border-checkbox-label" for="webhoock_url_offon">вкл. / выкл.</label>
                </div>
                </form>
                <input class="btn"  type="submit" form="webhook_discord" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Save')?>">
            </div>
        </div>
        </div>
    </div>
<?php if (!empty($_GET['geteway_edit'])): $Gateway = $LK->LkGetGateway($_GET['geteway_edit']);?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SetGateways')?> - <?php echo ucfirst($_GET['geteway_edit'])?></h5>
            <a class="module_setting close"><i data-del="delete" data-get="geteway_edit" class="zmdi zmdi-close zmdi-hc-fw"></i></a> 
        </div>
        <div class="card-container module_block">
            <form id="gateway_edit" data-default="true" enctype="multipart/form-data" method="post">
            <?php switch ($_GET['geteway_edit']):
                case 'webmoney':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Purse')?></div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=webmoney</div></div>
                   <div class="input-form">
		                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
		                <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
		            </div>
                <?php break;
                case 'yandexmoney':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Purse')?></div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?></div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?> "></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=yandexmoney</div></div>
                     <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
                    </div>
                <?php break; 
                 case 'qiwi':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_PublicKey')?>:</div><input name="secret1" value="<?php echo $Gateway[0]['secret_key_1']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>"></div>
                   <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=qiwi</div></div>
                    <div class="input-form">
		                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
		                <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
		            </div>
                 <?php break; 
                 case 'unitpay':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_PublicKey')?>:</div><input name="secret1" value="<?php echo $Gateway[0]['secret_key_1']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>"></div>
                   <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=unitpay</div></div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
                    </div>
                 <?php break; 
                 case 'paypal':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_BusinessAccount')?>:</div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ISOCourse')?> (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div><input name="secret1" value="<?php echo $Gateway[0]['secret_key_1']?>"></div>
                   <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=paypal</div></div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
                    </div>
                 <?php break;
                    case 'interkassa':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ISOCourse')?> (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div>
                     <select name="secret1">
                         <option value="USD" <?php if($Gateway[0]['secret_key_1'] == 'USD')print'selected' ?>>USD</option>
                         <option value="RUB" <?php if($Gateway[0]['secret_key_1'] == 'RUB')print'selected' ?>>RUB</option>
                         <option value="UAH" <?php if($Gateway[0]['secret_key_1'] == 'UAH')print'selected' ?>>UAH</option>
                     </select>
                    </div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=interkassa</div></div>
                   <div class="input-form">
		                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
		                <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
		            </div>
                <?php break; 
                  case 'robokassa':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #1</div><input name="secret1" value="<?php echo $Gateway[0]['secret_key_1']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #2</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway =robokassa</div></div>
                   <div class="input-form">
		                <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
		                <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
		            </div>
                <?php break; 
                 case 'freekassa':?>
                    <input type="hidden" name="gateway_edit" value="<?php echo $_GET['geteway_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" value="<?php echo $Gateway[0]['shop_id']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #1</div><input name="secret1" value="<?php echo $Gateway[0]['secret_key_1']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #2</div><input name="secret2" value="<?php echo $Gateway[0]['secret_key_2']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=freekassa</div></div>
                   <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $Gateway[0]['status'] && print 'checked';?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ActGateways')?></label>
                    </div>
                <?php break; 
                endswitch?>
             </form>
            <input class="btn"  type="submit" form="gateway_edit" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Save')?>">
             <form data-get="geteway_edit" id="gateway_delete" data-default="true" enctype="multipart/form-data" method="post">
                     <input type="hidden" name="gateway_delete" value="<?php echo $Gateway[0]['id']?>">         
             </form>
            <button class="btn float-left" type="submit" form="gateway_delete" ><i  class='zmdi zmdi-delete zmdi-hc-fw'></i></button>
        </div>
    </div>
</div>
<?php endif?>
<?php if (!empty($_GET['gateway_add'])):?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddGateways')?> - <?php echo ucfirst($_GET['gateway_add'])?></h5>
            <a class="module_setting close"><i data-del="delete" data-get="gateway_add" class="zmdi zmdi-close zmdi-hc-fw"></i></a> 
        </div>
        <div class="card-container module_block">
            <form id="gateway_add" data-default="true" data-get="gateway_add" enctype="multipart/form-data" method="post">
            <?php switch ($_GET['gateway_add']):
                case 'webmoney':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Purse')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=webmoney</div></div>
                   
                <?php break;
                case 'yandexmoney':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Purse')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?></div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=yandexmoney</div></div>
                   
                <?php break; 
                 case 'qiwi':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_PublicKey')?>:</div><input name="secret1" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=qiwi</div></div>
                 <?php break; 
                 case 'interkassa':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?>:</div><input name="secret2" ></div>
                     <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ISOCourse')?> (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div>
                     <select name="secret1">
                         <option value="USD">USD</option>
                         <option value="RUB">RUB</option>
                         <option value="UAH">UAH</option>
                     </select>
                    </div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=interkassa</div></div>
                   
                <?php break; 
                  case 'robokassa':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #1</div><input name="secret1" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #2</div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=robokassa</div></div>
                   
                <?php break; 
                 case 'freekassa':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Indetificator')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #1</div><input name="secret1" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Password')?> #2</div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=freekassa</div></div>
                   
                <?php break; 
                 case 'unitpay':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_PublicKey')?></div><input name="secret1" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SecretKey')?></div><input name="secret2" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ResultUrl')?></div><div><?php echo $LK->https().get_url(2)?>?gateway=unitpay</div></div>
                <?php break; 
                 case 'paypal':?>
                    <input type="hidden" name="gateway" value="<?php echo $_GET['gateway_add']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_BusinessAccount')?></div><input name="shopid" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_ISOCourse')?> (<a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">ISO 4217</a>)</div>
                    <input name="secret1" placeholder="USD">
                    </div>
                <?php break; 
                endswitch?>
             </form>
            <input class="btn" name="gateway_save" type="submit" form="gateway_add" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddGateways')?>">
        </div>
    </div>
</div>
<?php endif?>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-core.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-bundle.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/themes/dark_earth.min.js"></script>
<script type="text/javascript"><?=$LK->LKChart()?></script>