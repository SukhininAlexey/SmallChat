<?php
set_time_limit(0);
$source = "message.txt";
$mysqli = new mysqli("127.0.0.1", "root", "", "small_chat");

if(isset($_POST['author']) && isset($_POST['message'])){
    $author = $_POST['author'];
    $message = $_POST['message'];
    $time = time();
    $query = "INSERT INTO `small_chat`.`message` (`time`, `author`, `message`) VALUES ({$time}, '{$author}', '{$message}')";
    $res = $mysqli->query($query);
    var_dump($query);
    exit;
}

while(true){
    
    $lastRequest = (int) (isset($_GET['id']) ? $_GET['id'] : null);
    $lastRow = $mysqli->query("Select max(`id`) as `maxid` from `message`")->fetch_all()[0][0];
    clearstatcache();
    
    if($lastRequest == 0 || $lastRequest < $lastRow){
        $query = "SELECT * FROM small_chat.message WHERE small_chat.message.id > {$lastRequest} LIMIT 30";
        $result2 = $mysqli->query($query)->fetch_all();
        $response = [
            'id' => $lastRow,
            'arr' => $result2,
        ];
        
        echo json_encode($response);
        break;
    }else{
        sleep(1);
    }
}
