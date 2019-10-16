if (servers != 0) {

    var data_servers = $.ajax({
        type: 'POST',
        url: "./app/modules/module_block_main_servers_monitoring/includes/ServerJS.php",
        data: ({data: servers}),
        dataType: 'text',
        global: false,
        async:false,
        success: function( data ) {
            return data;
        }
    }).responseText;

    var arr_servers = JSON.parse(data_servers);

    for (var i = 0; i < arr_servers.length; i++) {
        document.getElementById('server-name-' + i).innerHTML = arr_servers[i]['HostName'];
        document.getElementById('server-map-image-' + i).setAttribute("src", "./storage/cache/img/maps/"+ arr_servers[i]['Mod'] +"/" + arr_servers[i]['Map_image'] + ".jpg");
        document.getElementById('server-players-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
        document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*arr_servers[i]['Players']/arr_servers[i]['MaxPlayers'] + "%");
        document.getElementById('server-ip-' + i).innerHTML = arr_servers[i]['ip'];
        document.getElementById('server-tablename-' + i).innerHTML = arr_servers[i]['HostName'];
        document.getElementById('server-tablemap-' + i).innerHTML = arr_servers[i]['Map'];
        document.getElementById('server-tablemod-' + i).setAttribute("src", "./storage/cache/img/mods/" + arr_servers[i]['Mod'] + ".png");
        document.getElementById('server-tableplayers-' + i).innerHTML = arr_servers[i]['Players'] + "/" + arr_servers[i]['MaxPlayers'];
    }

    function get_players_data(server) {
        var b = 1;
        if( arr_servers[server]['players'].length > 0 ) {
            for (var i = 0; i < arr_servers[server]['players'].length; i++) {
                var str = '<tr>' +
                    '<th class="text-center">' + b++ + '</th>' +
                    '<th class="text-center">' + arr_servers[server]['players'][i]['Name'] + '</th>' +
                    '<th class="text-center">' + arr_servers[server]['players'][i]['Frags'] + '</th>' +
                    '<th class="text-center">' + arr_servers[server]['players'][i]['TimeF'] + '</th>' +
                    '</tr>';
                players_online.insertAdjacentHTML('beforeend', str);
                var modal = document.getElementById('server-players-online');
                document.getElementById('connect_server').setAttribute("href", "steam://connect/" + arr_servers[server]['ip']);
                modal.style.display = "block";
            }
        } else {
            $('.btn_connect_' + server).attr("href", "steam://connect/" + arr_servers[server]['ip'] )
            $('.str_connect_' + server).attr("onclick", "document.location = 'steam://connect/" + arr_servers[server]['ip'] + "'" )
            location.href = 'steam://connect/' + arr_servers[server]['ip'];
        }
    }

    function close_modal() {
        $("#players_online").empty();
        var modal = document.getElementById('server-players-online');
        modal.style.display = "none";
    }
};