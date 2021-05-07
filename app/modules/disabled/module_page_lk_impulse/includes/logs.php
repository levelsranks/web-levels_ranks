<?php if( !isset( $_SESSION['user_admin'] ) || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; };?>
<div class="col-md-2">
	<div class="card">
		<div class="card-header">
        	<h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_lk_impulse','_LogList');?></h5>
             <form id="clean_logs" data-default="true" enctype="multipart/form-data" method="post"><input type="hidden" name="clean_logs">
                        <button form="clean_logs" name="clean_logs" class="btn" style="padding: 1px 6px;" type="submit"><i  class='zmdi zmdi-delete zmdi-hc-fw'></i> кроме этого месяца</button>
            </form>
    	</div>
    	<div class="card-container" style="font-size: 14px;">
    		<?php foreach ($LK->LkLogs() as $log):?>
    			<div style="display: block;width:"><a href="<?php echo set_url_section(get_url(2), 'log', $log['log_name']) ?>"><?php echo $log['log_name']?></a>
                    <form id="log_delete" class=" float-right" data-default="true" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="log_delete" value="<?php echo $log['log_name']?>">
                        <button form="log_delete" name="log_delete" class="btn" style="padding: 1px 6px;" type="submit"><i  class='zmdi zmdi-delete zmdi-hc-fw'></i></button>
                    </form>
                </div>
    		<?php endforeach;?>
    	</div>
	</div>
</div>
<?php if(!empty($_GET['log'])):?>
<div class="col-md-10">
	<div class="card">
		<div class="card-header">
        	<h5 class="badge">Содержание лога</h5>
    	</div>
    	<div class="card-container">
    		<div style="text-align: left;font-size: 11px;">
    		<?php foreach ($LK->LkLogContent($_GET['log']) as $key):?>
    			<?php echo $key['log_name'].$key['log_time'].LangValReplace($Translate->get_translate_module_phrase('module_page_lk_impulse',$key['log_content']), json_decode(str_replace('[]','',$key['log_value']), true));?><br>
    		<?php endforeach;?>
    		</div>
    	</div>
        <div class="card-bottom">
            <form id="log_download" class="select-panel-pages float-left" enctype="multipart/form-data" method="post">
                <input type="hidden" name="log_download" value="<?php echo $_GET['log']?>">
                <button class="btn" style="padding: 1px 6px;margin-right: 5px;" type="submit" form="log_download" ><i  class='zmdi zmdi-download zmdi-hc-fw'></i></button>
            </form>
        </div>
	</div>
</div>
<?php  endif;?>