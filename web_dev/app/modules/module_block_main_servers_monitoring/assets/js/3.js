if (servers != 0) {
    $.post("./app/modules/module_block_main_servers_monitoring/includes/SourceQuery/ServerJS.php", {
        data: servers
    }, function (data) {
        var arr_servers = JSON.parse(data);
        for (var i = 0; i < arr_servers.length; i++) {
                document.getElementById('server-name-' + i).innerHTML = arr_servers[i]['HostName'];
                document.getElementById('server-connect-' + i).setAttribute("onclick", "document.location = 'steam://connect/" + arr_servers[i]['ip'] + "'");
                document.getElementById('server-map-image-' + i).setAttribute("src", "./storage/cache/img/maps/"+ arr_servers[i]['Mod'] +"/" + arr_servers[i]['Map_image'] + ".jpg");
                document.getElementById('server-players-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
                document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*arr_servers[i]['Players']/arr_servers[i]['MaxPlayers'] + "%");
                document.getElementById('server-ip-' + i).innerHTML = arr_servers[i]['ip'];
            document.getElementById('server-tablename-' + i).innerHTML = arr_servers[i]['HostName'];
            document.getElementById('server-connect-table-' + i).setAttribute("onclick", "document.location = 'steam://connect/" + arr_servers[i]['ip'] + "'");
            document.getElementById('server-tablemap-' + i).innerHTML = arr_servers[i]['Map'];
            document.getElementById('server-tablemod-' + i).setAttribute("src", "./storage/cache/img/mods/" + arr_servers[i]['Mod'] + ".png");
            document.getElementById('server-tableplayers-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
        }
    })
};