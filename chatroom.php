<!DOCTYPE html>
<html>
    <head>
        <title>Chat</title>
        <link rel="icon" href="attachments/message-icon.png" type="image/gif" sizes="16x16">

        <!-- BOOSTRAP LINK -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <script src="lib/jsencrypt.js"></script>

        <link rel="stylesheet" href="css/CHATROOM_styles.css">
    </head>
    <body>
        <div class="container">

            <div class="row mt-5">
                <div class="col-md-4">
                    <?php
                        session_start();
                        if(!isset($_SESSION['user']))
                        {
                            header("location: index.php");
                        }
                        require("db/users.php");
                        require("db/chatrooms.php");

                        $objChatroom = new chatrooms;
                        $chatrooms   = $objChatroom->getAllChatRooms();

                        $objUser = new users;
                        $users   = $objUser->getAllUsers();
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class='text-center'>
                                    <?php
                                        foreach ($_SESSION['user'] as $key => $user)
                                        {
                                            $userId = $key;
                                            echo '<input type="hidden" name="userId" id="userId" value="'.$key.'">';
                                            echo "<div class='text-center'><h5 class='m-0'>Hello ".$user['name']."</h5></div>";
                                        }
                                    ?>
                                </td>
                                <td align="right" colspan="2">
                                    <input type="button" class="btn btn-secondary" id="leave-chat" name="leave-chat" value="Leave">
                                </td>
                            </tr>
                            <tr>
                                <th>Users</th>
                                <th>Last login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($users as $key => $user)
                                {
                                    $color = 'color: red';
                                    if($user['login_status'] == 1)
                                    {
                                        $color = 'color: green';
                                    }
                                    if( !isset($_SESSION['user'][$user['id']])  )
                                    {
                                        echo "<tr><td>".$user['name']."</td>";
                                        echo "<td>".$user['last_login']."</td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8" >
                    <div class="row justify-content-center">
                        <h1 class="text-center">Chat Room</h1>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id="messages" >
                                <table id="chats" class="table table-striped">
                                    <tbody>
                                    <?php
                                    foreach ($chatrooms as $key => $chatroom) {

                                        if($userId == $chatroom['userid']) {
                                            $from = "Me";
                                        } else {
                                            $from = $chatroom['name'];
                                        }
                                        echo '<tr><td valign="top"><div><strong>'.$from.'</strong></div><div>'.$chatroom['msg'].'</div><td align="right" valign="top">'.date("d-m-Y h:i:s", strtotime($chatroom['created_on'])).'</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <form id="chat-room-frm" method="post" action="">
                                <div class="form-group">
                                    <textarea class="form-control" id="msg" name="msg" placeholder="Enter Message"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="button" value="Send" class="btn btn-secondary btn-block" id="send" name="send">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>

<script type="text/javascript">
    var crypt = new JSEncrypt({default_key_size: 1024});
    var privateKey = sessionStorage.getItem("privateKey");
    var publicKey = sessionStorage.getItem("publicKey");
    console.log(privateKey);
    console.log(publicKey);
    var othersPubKey;
    var myMsg;
    var ignoreFirst = true;

    $(document).ready(function(){
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
            var userId 	= $("#userId").val();
            var msg 	= "<strong>JOINED CHAT</strong>";
            var data = {
                userId: userId,
                msg: msg
            };
            console.log("SENDING KEY");
            conn.send(JSON.stringify(data));
        };

        conn.onmessage = function(e) {
            console.log("#####OnMessage#####");
            var myID 	= $("#userId").val();
            console.log(e.data);
            var data = JSON.parse(e.data);
            console.log("Encrypted Message:" + data.msg);
            if((data.userId != myID) )//if NOT current users message
            {
                var keys = data.keys;
                var keys = JSON.stringify(keys[0]);
                var othersKey = keys.replace("\\r\\n", '\n');
                othersKey = othersKey.replace("\\r\\n", '\n');
                othersKey = othersKey.replace("\\r\\n", '\n');
                othersKey = othersKey.replace("\\r\\n", '\n');
                othersKey = othersKey.replace("\\r\\n", '\n');
                othersKey = othersKey.replace("\"", '');
                othersKey = othersKey.replace("\"", '');
                othersPubKey = othersKey;
                console.log("PublicKey Changed");

                //decrypt
                crypt.setKey(privateKey);
                var ddemsg = crypt.decrypt(data.msg);
                var demsg = (data.msg == "<strong>JOINED CHAT</strong>") ? "<strong>JOINED CHAT</strong>":ddemsg;
                console.log("Decrypted Message:" + demsg);
            }
            else//if IS current users message
            {
                console.log("PublicKey Not Changed");
                console.log("No Decryption Needed");
                var demsg = (data.msg == "<strong>JOINED CHAT</strong>") ? "<strong>JOINED CHAT</strong>":myMsg;
            }
            var row = '<tr><td valign="top"><div><strong>' + data.from + '</strong></div><div>' + demsg + '</div><td align="right" valign="top">' + data.dt + '</td></tr>';
            $('#chats > tbody').append(row);

        };
        conn.onclose = function(e) {
            console.log("#####Connection Closed!#####");
        }
        $("#send").click(function(){
            console.log("#####SendMessage#####");
            var userId 	= $("#userId").val();
            var msg 	= $("#msg").val();
            //--------------
            myMsg = msg;
            crypt.setKey(othersPubKey);
            var emsg = crypt.encrypt(msg);
            var data =
            {
                userId: userId,
                msg: emsg
            };
            conn.send(JSON.stringify(data));
            $("#msg").val("");
        });
        $("#leave-chat").click(function(){
            var userId 	= $("#userId").val();
            $.ajax({
                url:"action.php",
                method:"post",
                data: "userId="+userId+"&action=leave"
            }).done(function(result){
                var data = JSON.parse(result);
                if(data.status == 1) {
                    conn.close();
                    location = "index.php";
                } else {
                    console.log(data.msg);
                }
            });
        })
    })
</script>
</html>