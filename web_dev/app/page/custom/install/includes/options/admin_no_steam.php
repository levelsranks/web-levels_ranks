<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title"><?php echo $options['language'] == 'EN' ? 'Administrator' : 'Администратор'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Login' : 'Логин'?></div>
                        <input name="admin_login" value="" placeholder="M0st1ce" required>
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Password' : 'Пароль'?></div>
                        <input name="admin_pass" value="" placeholder="*******" type="password" required>
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Emulated Steam ID' : 'Эмулированный Steam ID'?></div>
                        <input name="admin_steam" value="" required>
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="admin_nosteam_save" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Save' : 'Сохранить'?>"></div>
        </div>
    </form>
</div>