if (servers != 0) {
    $.ajax({
        type: 'POST',
        url: domain+"/app/modules/module_block_main_servers_monitoring/includes/js_controller.php",
        data: ({data: servers}),
        dataType: 'json',
        global: false,
        async:true,
        success: function( data ) {
            for (var i = 0; i < data.length; i++) {
                document.getElementById('server-name-' + i).innerHTML = data[i]['HostName'];
                document.getElementById('server-map-image-' + i).setAttribute("src", domain+"/storage/cache/img/maps/"+ data[i]['Mod'] +"/" + data[i]['Map_image'] + ".jpg");
                document.getElementById('server-players-' + i).innerHTML = data[i]['Players'] + "/" + data[i]['MaxPlayers'];
                document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*data[i]['Players']/data[i]['MaxPlayers'] + "%");
                document.getElementById('server-ip-' + i).innerHTML = data[i]['ip'];
                document.getElementById('server-tablename-' + i).innerHTML = data[i]['HostName'];
                document.getElementById('server-tablemap-' + i).innerHTML = data[i]['Map'];
                document.getElementById('server-tablemod-' + i).setAttribute("src", domain+"/storage/cache/img/mods/" + data[i]['Mod'] + ".png");
                document.getElementById('server-tableplayers-' + i).innerHTML = data[i]['Players'] + "/" + data[i]['MaxPlayers'];

                var b = 1;
                if(data[i]['players']) {
                    if( data[i]['players'].length > 0 ) {
                        console.log(data[i]['players']);
                        for (var i2 = 0; i2 < data[i]['players'].length; i2++) {
                            var str = '<tr>' +
                                '<th class="text-center">' + b++ + '</th>' +
                                '<th class="text-center">' + data[i]['players'][i2]['Name'] + '</th>' +
                                '<th class="text-center">' + data[i]['players'][i2]['Frags'] + '</th>' +
                                '<th class="text-center">' + data[i]['players'][i2]['TimeF'] + '</th>' +
                                '</tr>';
                            po = document.getElementById('players_online_' + i);
                            po.insertAdjacentHTML('beforeend', str);
                        }
                            var modal = document.getElementById('server-players-online-' + i );
                            document.getElementById('connect_server_' + i).setAttribute("href", "steam://connect/" + data[i]['ip'] );
                    } else {
                        $('.btn_connect_' + i).prop("onclick", null).off("click");
                        $('.btn_connect_' + i).attr("href", "steam://connect/" + data[i]['ip'] )
                        $('.str_connect_' + i).attr("onclick", "document.location = 'steam://connect/" + data[i]['ip'] + "'" )
                    }
                }
            }
        }
    });
    
    function get_players_data( i ) {
        var modal = document.getElementById('server-players-online-' + i );
        modal.style.display = "block";
    }

    function close_modal( i ) {
        var modal = document.getElementById('server-players-online-' + i );
        modal.style.display = "none";
    }
};