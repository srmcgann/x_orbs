<?php
  require_once('../db.php');
  $data = json_decode(file_get_contents('php://input'));
  $gameID = mysqli_real_escape_string($link, $data->{'gameID'});
  $userID = mysqli_real_escape_string($link, $data->{'userID'});
  $individualPlayerData = $data->{'individualPlayerData'};
  
  $igt = gettype($individualPlayerData);
  $has = false;
  switch($igt){
    case 'array':
      $has = array_key_exists('id', $individualPlayerData);
    break;
    case 'object':
      $has = property_exists($individualPlayerData, 'id');
    break;
  }
  
  $success = false;
  
  // ->maintenance
  // purge any player records that have not been updated in over 10 minutes
  for($i=2; $i--;){
    $table = '';
    switch($i){
      case 0: $table = 'platformSessions'; break;
      //case 1: $table = 'platformGames'; break;
    }
    if($table){
      $sql = "DELETE FROM $table WHERE TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, date)) >= 600;";
      $res = mysqli_query($link, $sql);
    }
  }
  // /maintenance

  $sql = "SELECT * FROM platformGames WHERE id = $gameID";
  $res = mysqli_query($link, $sql);
  $data = '';
  $needsReg = false;
  $found=false;
  if(mysqli_num_rows($res)){
    $success = true;
    $row = mysqli_fetch_assoc($res);
    $data = json_decode($row['data']);
    forEach($data->{'players'} as $key=>$player){
      // player drops if unseen for 5 seconds
      if(isset($player->{'time'}) && (time() - $player->{'time'} > 5)) unset($data->{'players'}->{$key});
    }
    if($userID){
      if($has){
        if(time() - $individualPlayerData->{'time'} < 60){ // player may reconnect for up to a minute
          $individualPlayerData->{'time'} = time();
          $data->{'players'}->{$userID} = $individualPlayerData;
        }
      }
      if(isset($data->{'players'}->{$userID})){
        $newData = mysqli_real_escape_string($link, json_encode($data));
        $sql = "UPDATE platformGames SET data = \"$newData\" WHERE id = $gameID";
        mysqli_query($link, $sql);
        $needsReg = false;
      }else{
        $needsReg = true;
      }
    }else{
      $needsReg = true;
    }
  }

  echo json_encode([$success, $data, $needsReg, $userID, $newData, $individualPlayerData, $found]);
?>