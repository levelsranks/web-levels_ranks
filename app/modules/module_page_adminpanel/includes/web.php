<?php ! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' )?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Шаблонизатор</h5>
        </div>
        <div class="card-container">
            <div class="web-header">
                <div onclick="change_shablon(0)" id="one_yes" class="web-list">
                    <a class="sel">Главная</a>
                </div>
                <div onclick="change_shablon(1)" id="two_yes" class="web-list">
                    <a>Редактор</a>
                </div>
            </div>
        </div>
    </div>
</div>