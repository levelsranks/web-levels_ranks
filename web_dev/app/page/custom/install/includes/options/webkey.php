<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title">STEAM WEB API KEY</div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <input name="web_key" value="<?php ! empty( $error ) && $error == true && print 'WEB API KEY - ERROR'?>" placeholder="WEB API KEY">
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="check" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Check' : 'Проверить'?>"></div>
            <div class="webkey_btn_dont_key"><input class='btn' name="nope" type="submit" value="<?php echo $options['language'] == 'EN' ? 'I do not use authorization via Steam and I do not need player avatars' : 'Я не использую авторизацию через Steam и мне не нужны аватары игроков'?>"></div>
        </div>
    </form>
</div>