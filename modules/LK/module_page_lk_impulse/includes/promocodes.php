<?php if( !isset( $_SESSION['user_admin'] ) || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SettingsPromo')?></h5>
        </div>
        <div class="card-container">
                  <table class="table table-hover">
                <thead>
                <tr>
                    <th><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Promo')?></th>
                    <th><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_BonusPromo')?></th>
                    <th><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitUsePromo')?></th>
                    <th><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Snap')?></th>
                    <th><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Options')?></th>
                </tr>
            </thead>
             <tbody>
                <?php foreach($LK->LkPromocodes() as $key):?>
                    <tr>
                        <td><?php echo $key['code']?></td>
                        <td><?php echo $key['percent']?></td>
                        <td><?php echo $key['attempts']?></td>
                        <td><?php if(!empty($key['auth1'])): print '+'; else: print '-'; endif;?></td>
                        <td><a href="<?php echo set_url_section(get_url(2), 'promocode_edit', $key['id']) ?>" class="btn"><i class="zmdi zmdi-edit zmdi-hc-fw"></i></a></td>
                    </tr>
                <?php endforeach?>

             </tbody>
        </table>
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
             <div class="select-panel">
               <a class="btn" href="<?php echo set_url_section(get_url(2), 'promocode_add', 'promocodes') ?>"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddPromocode')?></a></option>
            </div>
        </div>
        </div>
    </div>
<?php if (!empty($_GET['promocode_edit'])): $promo = $LK->LkPromoCode($_GET['promocode_edit']);?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_EditPromo')?> - <?php echo $promo[0]['code']?></h5>
            <a class="module_setting close"><i data-del="delete" data-get="promocode_edit" class="zmdi zmdi-close zmdi-hc-fw"></i></a> 
        </div>
        <div class="card-container module_block">
            <form id="promocode_edit" data-default="true" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="editid" value="<?php echo $_GET['promocode_edit']?>">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Name')?>:</div><input name="editpromo" value="<?php echo $promo[0]['code']?>" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitUsePromo')?>:</div><input name="editlimit" value="<?php echo $promo[0]['attempts']?>" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_BonusPromo')?>:</div><input name="editbonuspecent" value="<?php echo $promo[0]['percent']?>" ></div>
                   <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="status" id="status" <?php $promo[0]['auth1'] && print 'checked';?>>
                        <label class="border-checkbox-label" for="status"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SnapSID')?></label>
                    </div>
             </form>
            <input class="btn"  type="submit" form="promocode_edit" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_Save')?>">
             <form  data-del="delete" data-get="promocode_edit" id="promocode_delete" data-default="true" enctype="multipart/form-data" method="post">
                     <input type="hidden" name="promocode_delete" value="<?php echo $_GET['promocode_edit']?>">         
             </form>
            <button class="btn float-left" type="submit" form="promocode_delete" ><i  class='zmdi zmdi-delete zmdi-hc-fw'></i></button>
            <br>
            <div class="user_pays">
                <?php $usage = $LK->LkUsagePromo($promo[0]['code']);
                    if(!empty($usage)):?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                            <th class="text-left"><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                            <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse', '_Date') ?></th>
                            <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse', '_Gateways') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ( $usage as $key ):?>
                            <tr>
                                <?php if( $General->arr_general['avatars'] != 0 ) {?>
                                    <th class="text-right tb-avatar pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php echo $key['pay_auth'] ?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64($key['pay_auth']) ?>"<?php $i  < '20' ? print 'src' : print 'data-src'?>="
                                    <?php if ( $General->arr_general['avatars'] == 1){ echo $General->getAvatar(con_steam32to64($key['pay_auth']), 2);
                                    } elseif( $General->arr_general['avatars'] == 2) {
                                            echo 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                                    }?>"></th>
                                <?php } ?>
                                <th class="text-left pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php echo $key['pay_auth'] ?>&search=1' "<?php } ?>>
                                    <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php echo $key['pay_auth'] ?>&search=1"<?php } ?>><?php echo action_text_clear( action_text_trim($LK->LkGetUserData($key['pay_auth'])[0]['name'], 13) )?></a>
                                </th>
                                <th class="text-left"><?php echo $key['pay_data'] ?></th>
                                <th class="text-left"><img src="app/modules/module_page_lk_impulse/assets/gateways/<?php echo mb_strtolower($key['pay_system'])?>.svg"></th>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else:?>
                    <?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse', '_PromoNotUse') ?>
                <?php endif?>    
            </div>
        </div>
    </div>
</div>
<?php endif?>
<?php if (!empty($_GET['promocode_add'])):?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddPromocode')?></h5>
            <a class="module_setting close"><i data-del="delete" data-get="promocode_add" class="zmdi zmdi-close zmdi-hc-fw"></i></a> 
        </div>
        <div class="card-container module_block">
            <form id="promocode_add" data-default="true" enctype="multipart/form-data" method="post">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddPromoName')?></div><input name="addpromo" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LimitUsePromo')?>:</div><input name="limit" ></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_BonusPromo')?>:</div><input name="bonuspecent"></div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="auth" id="status_add">
                        <label class="border-checkbox-label" for="status_add"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_SnapSID')?></label>
                    </div>           
             </form>
            <input class="btn" name="promocode_add" type="submit" form="promocode_add" value="<?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_AddPromocode')?>">
        </div>
    </div>
</div>
<?php endif?>
