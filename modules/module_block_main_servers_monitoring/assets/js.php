<?php
    /**
     * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
     *
     * @link https://steamcommunity.com/profiles/76561198038416053
     * @link https://github.com/M0st1ce
     *
     * @license GNU General Public License Version 3
     */
?>
<script>
    if (servers != 0) {
        $.post("./app/modules/module_block_main_servers_monitoring/includes/SourceQuery/ServerJS.php", {
            data: servers
        }, function (data) {
            var arr_servers = JSON.parse(data);
            for (var i = 0; i < arr_servers.length; i++) {
            <?php if($Modules->array_modules['module_block_main_servers_monitoring']['setting']['type'] == '1'){?>
                document.getElementById('server-name-' + i).innerHTML = arr_servers[i]['HostName'];
                document.getElementById('server-connect-' + i).setAttribute("onclick", "document.location = 'steam://connect/" + arr_servers[i]['ip'] + ":" + arr_servers[i]['port'] + "'");
                document.getElementById('server-map-' + i).innerHTML = arr_servers[i]['Map'];
                document.getElementById('server-map-image-' + i).setAttribute("src", "./storage/cache/img/maps/"+ arr_servers[i]['Mod'] +"/" + arr_servers[i]['Map'] + ".jpg");
                document.getElementById('server-players-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
             <?php }elseif($Modules->array_modules['module_block_main_servers_monitoring']['setting']['type'] == '3'){?>
                document.getElementById('server-name-' + i).innerHTML = arr_servers[i]['HostName'];
                document.getElementById('server-connect-' + i).setAttribute("onclick", "document.location = 'steam://connect/" + arr_servers[i]['ip'] + ":" + arr_servers[i]['port'] + "'");
                document.getElementById('server-map-image-' + i).setAttribute("src", "./storage/cache/img/maps/"+ arr_servers[i]['Mod'] +"/" + arr_servers[i]['Map'] + ".jpg");
                document.getElementById('server-players-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
                document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*arr_servers[i]['Players']/arr_servers[i]['MaxPlayers'] + "%");
                document.getElementById('server-ip-' + i).innerHTML = arr_servers[i]['ip'] + ":" + arr_servers[i]['port'];
            <?php }?>
                document.getElementById('server-tablename-' + i).innerHTML = arr_servers[i]['HostName'];
                document.getElementById('server-connect-table-' + i).setAttribute("onclick", "document.location = 'steam://connect/" + arr_servers[i]['ip'] + ":" + arr_servers[i]['port'] + "'");
                document.getElementById('server-tablemap-' + i).innerHTML = arr_servers[i]['Map'];
                document.getElementById('server-tablemod-' + i).setAttribute("src", "./storage/cache/img/mods/" + arr_servers[i]['Mod'] + ".png");
                document.getElementById('server-tableplayers-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
            }
        })
    };</script>