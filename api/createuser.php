<?php
$_POST = json_decode(file_get_contents("php://input"), true);
header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    include_once("./connect.php");

    $username = $_POST['username'];
    $pwd = $_POST['pwd'];

    if (isset($_POST['opt'])) {
        $opt = $_POST['opt'];
        $data = array();

        if ($opt == 'GameAdmin') {
            // if user is playing as admin

            $sql = "SELECT * FROM okrosplayers WHERE username = ?";
            $stmt = $database->stmt_init();
            $stmt->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // if in database is admin
                $sql = "SELECT * FROM okrosplayers WHERE username = ?";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $pwdHashed = $row['pwd'];
                    $checkPwd = password_verify($pwd, $pwdHashed);

                    if ($checkPwd == true) {
                        $data['login'] = "true";
                        $data['gamecode'] = $row['gameCode'];
                        echo json_encode($data);
                    } else {
                        $data['login'] = "false";
                        echo json_encode($data);
                    }
                } else {
                    $data['login'] = "false";
                    echo json_encode($data);
                }
            } else {
                // if in database isn't admin
                $sql = "INSERT INTO okrosplayers(opt, gameCode, username, pwd) VALUES(?,?,?,?)";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);

                $option['cost'] = 10;
                $pwdHashed = password_hash($pwd, PASSWORD_DEFAULT, $option);

                $gamecode = uniqid();
                $data["gamecode"] = $gamecode;

                $stmt->bind_param("ssss", $opt, $gamecode, $username, $pwdHashed);
                $stmt->execute();

                $row = $stmt->insert_id;

                $sql = "INSERT INTO okros(playerID) VALUES(?)";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);
                $stmt->bind_param("i", $row);
                $stmt->execute();

                $data['login'] = "true";
                echo json_encode($data);
            }
        } else if ($opt == 'GamePlayer') {
            // if user is playing as player
            $sql = "SELECT * FROM okrosplayers WHERE username = ?";
            $stmt = $database->stmt_init();
            $stmt->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                //if in database is player

                $sql = "SELECT * FROM okrosplayers WHERE username = ?";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $pwdHashed = $row['pwd'];
                    $checkPwd = password_verify($pwd, $pwdHashed);

                    if ($checkPwd == true) {
                        $data['login'] = "true";
                        echo json_encode($data);
                    } else {
                        $data['login'] = "false";
                        echo json_encode($data);
                    }
                } else {
                    $data['login'] = "false";
                    echo json_encode($data);
                }
            } else {
                //if in database isn't player

                $sql = "INSERT INTO okrosplayers(opt, gameCode, username, pwd) VALUES(?,?,?,?)";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);

                $option['cost'] = 10;
                $pwdHashed = password_hash($pwd, PASSWORD_DEFAULT, $option);

                $gamecode = $_POST['gamecode'];

                $stmt->bind_param("ssss", $opt, $gamecode, $username, $pwdHashed);
                $stmt->execute();

                $row = $stmt->insert_id;

                $sql = "INSERT INTO okros(playerID) VALUES(?)";
                $stmt = $database->stmt_init();
                $stmt->prepare($sql);
                $stmt->bind_param("s", $row);
                $stmt->execute();


                $data['login'] = "true";
                echo json_encode($data);
            }
        }
    }
}

if (isset($_POST['order'])) {
    $order = $_POST['order'];
    $data = array();

    include_once("./connect.php");

    $sql = "SELECT username FROM okrosplayers WHERE gameCode = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $order);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if (isset($_POST['newplayer']) && isset($_POST['gamecode'])) {
    $newplayer = $_POST['newplayer'];
    $gamecode = $_POST['gamecode'];
    $opt = 'GamePlayer';

    include_once("./connect.php");

    $sql = "INSERT INTO okrosplayers(opt,gameCode,username,pwd) VALUES(?, ?, ?, ?)";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $pwd = $newplayer . '1234';
    $option["cost"] = 10;
    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT, $option);

    $stmt->bind_param("ssss", $opt, $gamecode, $newplayer, $pwdHash);
    $stmt->execute();
}

if (isset($_POST['delplayer'])) {
    $name = $_POST['delplayer'];

    include_once('./connect.php');

    $sql = "SELECT playerID FROM okrosplayers WHERE username = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id = $row["playerID"];

    $sql = "DELETE FROM okrosplayers WHERE username = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $sql = "DELETE FROM okros WHERE playerID = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_POST['showall'])) {
    $gamecode = $_POST['showall'];
    $data = array();

    include_once('./connect.php');

    $sql = "SELECT okrosplayers.playerID, okrosplayers.username, okros.* FROM okrosplayers, okros WHERE okrosplayers.gameCode = ? AND okrosplayers.playerID = okros.playerID";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $gamecode);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

if (isset($_POST['name']) && isset($_POST['column']) && isset($_POST['value'])) {
    $id = $_POST['name'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    include_once("./connect.php");

    $sql = "UPDATE okros SET " . $column . " = ? WHERE playerID = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ii", $value, $id);
    $stmt->execute();
}

if (isset($_POST['getnumbers'])) {
    $gamecode = $_POST['getnumbers'];
    $data = array();

    include_once('./connect.php');

    $sql = "SELECT okrosplayers.playerID, okrosplayers.username, okros.* FROM okrosplayers, okros WHERE okrosplayers.gameCode = ? AND okrosplayers.playerID = okros.playerID";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $gamecode);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_row()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

if (isset($_POST['getcurrentplayer'])) {
    $player = $_POST['getcurrentplayer'];
    $data = array();

    include_once('./connect.php');

    $sql = "SELECT okrosplayers.playerID, okrosplayers.username, okros.* FROM okrosplayers, okros WHERE okrosplayers.username = ? AND okrosplayers.playerID = okros.playerID";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $player);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

if (isset($_POST['restart'])) {
    $restart = $_POST['restart'];

    include_once('./connect.php');

    $sql = "SELECT playerID FROM okrosplayers WHERE gameCode = ?";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $restart);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = 0;

    while($row = $result->fetch_assoc()){
        $column = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'];
        $id = $row['playerID'];

        for($i = 0; $i < count($column); $i++){

            $sql = "UPDATE okros SET " . $column[$i] . " = ? WHERE playerID = ?";
            $stmt = $database->stmt_init();
            $stmt->prepare($sql);
            $stmt->bind_param("ii", $value, $id);
            $stmt->execute();
    
        }
    }

    $sql = "SELECT okrosplayers.playerID, okrosplayers.username, okros.* FROM okrosplayers, okros WHERE okrosplayers.gameCode = ? AND okrosplayers.playerID = okros.playerID";
    $stmt = $database->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $restart);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);

}
