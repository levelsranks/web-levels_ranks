<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title">Администратор</div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <div class="info">Логин</div>
                        <input name="admin_login" value="" placeholder="M0st1ce" required>
                        <div class="info">Пароль</div>
                        <input name="admin_pass" value="" placeholder="*******" type="password" required>
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="admin_nosteam_save" type="submit" value="Сохранить"></div>
        </div>
    </form>
</div>