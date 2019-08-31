<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title">Информация о серверах</div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <div class="info">Короткое название</div>
                        <input name="servers_name" value="" placeholder="Вафелька" required>
                    </div>
                </div>
                <div class="input-form">
                    <div class="input_text">
                        <div class="info">Полное название</div>
                        <input name="servers_full_name" value="" placeholder="Сеть игровых серверов - Вафелька" required>

                    </div>
                </div>
                <div class="input-form">
                    <div class="input_text">
                        <div class="info">Описание</div>
                        <div class="servers_info">
                            <input name="servers_info" value="" placeholder="Лучшая сеть игровых серверов по CS:S и CS:GO с огромным онлайном и лучшими админами!" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="servers_info_save" type="submit" value="Сохранить"></div>
        </div>
    </form>
</div>