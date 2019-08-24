<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Настройка переводов</h5>
        </div>
    </div>
</div>