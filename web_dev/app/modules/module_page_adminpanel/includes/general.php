<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_General_settings')?></h5>
        </div>
        <div class="card-container option_one">
            <form id="options_one" enctype="multipart/form-data" method="post">
                    <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Full_name')?></div><input name="full_name" value="<?php echo $General->arr_general['full_name']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Short_name')?></div><input name="short_name" value="<?php echo $General->arr_general['short_name']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Basic_information')?></div><input name="info" value="<?php echo $General->arr_general['info']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Language')?></div>
                        <select class="select" name="language">
                            <option style="display:none" value="<?php echo $General->arr_general['language']?>"><?php echo $Modules->get_translate_phrase( '_' . $General->arr_general['language'] )?></option>
                            <option value="RU">Русский</option>
                            <option value="EN">Английский</option>
                            <option value="UA">Украинский</option>
                            <option value="LT">Литовский</option>
                        </select>
                    </div>
                    <div class="input-form"><div class="input_text">Авторизация по Steam</div>
                        <select name="steam_auth">
                            <option style="display:none" value="<?php echo (int) $General->arr_general['steam_auth']?>"><?php $General->arr_general['steam_auth'] == 1 ? print 'Есть' : print 'Нету'?></option>
                            <option value="1">Есть</option>
                            <option value="0">Нету</option>
                        </select>
                    </div>
                    <div class="input-form"><div class="input_text">Steam WEB KEY</div><input name="web_key" value="<?php echo $General->arr_general['web_key']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Chief_administrator_Steam')?></div><input name="admin" value="<?php echo $General->arr_general['admin']?>"></div>
                <div class="input-form">
                    <input class="border-checkbox" type="checkbox" name="only_steam_64" id="only_steam_64" <?php $General->arr_general['only_steam_64'] === 1 && print 'checked'?>>
                    <label class="border-checkbox-label" for="only_steam_64"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Use_Steam_ID')?></label>
                </div>
                <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="SB_admins_import" id="SB_admins_import" <?php $General->arr_general['SB_admins_import'] === 1 && print 'checked'?>>
                        <label class="border-checkbox-label" for="SB_admins_import"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Import_admin_list')?></label>
                </div>
            </form>
            <input class='btn' name="option_one_save" type="submit" form="options_one" value="<?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Save')?>">
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Extra_settingss')?></h5>
        </div>
        <div class="card-container option_two">
            <form id="options_two" enctype="multipart/form-data" method="post">
                <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Dark_mode_default')?></div>
                    <select name="dark_mode">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['dark_mode']?>"><?php $General->arr_general['dark_mode'] == 1 ? print 'Включен' : print 'Выключен и вообще я хорошо вижу'?></option>
                        <option value="1">Включен</option>
                        <option value="0">Выключен и вообще я хорошо вижу</option>
                    </select>
                </div>
                <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Animation_default')?></div>
                    <select name="animations">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['animations']?>"><?php $General->arr_general['animations'] == 1 ? print 'Включены' : print 'Лучше поменьше'?></option>
                        <option value="1">Включены</option>
                        <option value="0">Лучше поменьше</option>
                    </select>
                </div>
                <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Show_avatars')?></div>
                    <select name="avatars">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['avatars']?>"><?php if( $General->arr_general['avatars'] == 1 ) { echo 'Показывать';} elseif ( $General->arr_general['avatars'] == 2) { echo 'Использовать случайные аватарки';} else { echo 'Не показывать';}?></option>
                        <option value="1">Показывать</option>
                        <option value="2">Использовать случайные аватарки</option>
                        <option value="0">Не показывать</option>
                    </select>
                </div>
                <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Sidebar_default')?></div>
                    <select name="sidebar_open">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['sidebar_open']?>"><?php $General->arr_general['sidebar_open'] == 1 ? print 'Развёрнут' : print 'Свёрнут'?></option>
                        <option value="1">Развёрнут</option>
                        <option value="0">Свёрнут</option>
                    </select>
                </div>
                <div class="input-form"><div class="input_text"><?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Round_shapes')?></div>
                    <select name="form_border">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['form_border']?>"><?php $General->arr_general['form_border'] == 1 ? print 'Закруглить' : print 'Оквадратить'?></option>
                        <option value="1">Закруглить</option>
                        <option value="0">Оквадратить</option>
                    </select>
                </div>
            </form>
            <input class='btn' name="option_two_save" type="submit" form="options_two" value="<?php echo $Modules->get_translate_module_phrase( 'module_page_adminpanel','_Save')?>">
        </div>
    </div>
</div>