let minplayers = 0,maxplayers = 0, info, players;
if (servers != 0) {
    $.ajax({
        type: 'POST',
        url: domain+"app/modules/module_block_main_servers_monitoring/includes/js_controller.php",
        data: ({data: servers, my: "yes"}),
        dataType: 'json',
        global: false,
        async:true,
        success: function( data ) {
            for (var i = 0; i < data.length; i++) {
                console.log( data );
                info = data[i];
                players = data[i]["players"];
                minplayers += info['Players'];
                maxplayers += info['MaxPlayers'];
                document.getElementById('server-name-' + i).innerHTML = info['HostName'];
                document.getElementById('server-map-image-' + i).setAttribute("src", domain+"storage/cache/img/maps/"+data[i]['Mod']+"/"+info['Map_image']+".jpg");
                document.getElementById('server-image-' + i).setAttribute("src", domain+"storage/cache/img/mods/"+info["Mod"]+".png");
                document.getElementById('server-players-' + i).innerHTML = info['Players'] + "/" + info['MaxPlayers'];
                document.getElementById('server-map-' + i).innerHTML = info['Map'];
                document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*info['Players']/info['MaxPlayers'] + "%");
                document.getElementById('server-ip-' + i).innerHTML = info['ip'];

                var b = 1;
                if(players) {
                    if( players.length > 0 ) {
                        for (var i2 = 0; i2 < players.length; i2++) {
                            var str = '<tr>' +
                                '<th class="text-center">' + b++ + '</th>' +
                                '<th class="text-center">' + players[i2]['Name'].replace(/[\u00A0-\u9999<>\&]/g, function(i) {
                                    return '&#'+i.charCodeAt(0)+';';
                                 }) + '</th>' +
                                '<th class="text-center">' + players[i2]['Frags'] + '</th>' +
                                '<th class="text-center">' + players[i2]['TimeF'] + '</th>' +
                                '</tr>';
                            po = document.getElementById('players_online_' + i);
                            po.insertAdjacentHTML('beforeend', str);
                        }
                            var modal = document.getElementById('server-players-online-' + i );
                            document.getElementById('connect_server_' + i).setAttribute("href", "steam://connect/" + info['ip'] );
                    } else {
                        $('.btn_connect_' + i).prop("onclick", null).off("click");
                        $('.btn_connect_' + i).attr("href", "steam://connect/" + info['ip'] )
                        $('.str_connect_' + i).attr("onclick", "document.location = 'steam://connect/" + info['ip'] + "'" )
                    }
                }
            }
            document.getElementById('min_players').innerHTML = minplayers;
            document.getElementById('max_players').innerHTML = maxplayers;
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