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
                info = data[i]["info"];
                players = data[i]["players"];
                minplayers += info['Players'];
                maxplayers += info['Playersmax'];
                document.getElementById('server-name-' + i).innerHTML = info['Name'];
                document.getElementById('server-map-image-' + i).setAttribute("src", domain+info['Map_image']);
                document.getElementById('server-image-' + i).setAttribute("src", domain+"storage/cache/img/mods/"+info["Appid"]+".png");
                document.getElementById('server-players-' + i).innerHTML = info['Players'] + "/" + info['Playersmax'];
                document.getElementById('server-map-' + i).innerHTML = info['Map'];
                document.getElementById('online_gr-' + i).setAttribute("style", "width:" + 100*info['Players']/info['Playersmax'] + "%");
                document.getElementById('server-ip-' + i).innerHTML = info['Ip']+":"+info["Port"];

                var b = 1;
                if(players) {
                    if( players.length > 0 ) {
                        console.log(players);
                        for (var i2 = 0; i2 < players.length; i2++) {
                            var str = '<tr>' +
                                '<th class="text-center">' + b++ + '</th>' +
                                '<th class="text-center">' + players[i2]['Name'] + '</th>' +
                                '<th class="text-center">' + players[i2]['Score'] + '</th>' +
                                '<th class="text-center">' + players[i2]['Time'] + '</th>' +
                                '</tr>';
                            po = document.getElementById('players_online_' + i);
                            po.insertAdjacentHTML('beforeend', str);
                        }
                            var modal = document.getElementById('server-players-online-' + i );
                            document.getElementById('connect_server_' + i).setAttribute("href", "steam://connect/" + info['Ip']+":"+info["Port"] );
                    } else {
                        $('.btn_connect_' + i).prop("onclick", null).off("click");
                        $('.btn_connect_' + i).attr("href", "steam://connect/" + info['Ip']+":"+info["Port"] )
                        $('.str_connect_' + i).attr("onclick", "document.location = 'steam://connect/" + info['Ip']+":"+info["Port"] + "'" )
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