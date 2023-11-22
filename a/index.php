<?php 
  error_reporting(0);
  function alphaToDec($val){
    $pow=0;
    $res=0;
    while($val!=""){
      $cur=$val[strlen($val)-1];
      $val=substr($val,0,strlen($val)-1);
      $mul=ord($cur)<58?$cur:ord($cur)-(ord($cur)>96?87:29);
      $res+=intval($mul)*pow(62,$pow);
      $pow++;
    }
    return intval($res);
  }

  require('db.php');
  $query = explode('/',$_GET['i']);
  $title = 'Videos & Demos';
  if($query[0] === 'd'){
    $id = alphaToDec(mysqli_real_escape_string($link, $query[1]));
    $sql = 'SELECT * FROM items WHERE id = ' . $id;
    $res = mysqli_query($link, $sql);
    if(mysqli_num_rows($res)){
      $row = mysqli_fetch_assoc($res);
      if($row['title']) $title = $row['title'];
      $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "http:" : "http:") . "//{$_SERVER['HTTP_HOST']}/vidThumb.php?id=" . $id;
		  $image = json_decode(file_get_contents($url));
    }
  } elseif($query[0] === 'u') {
    $sql = 'SELECT name, avatar FROM users  WHERE name LIKE "' . mysqli_real_escape_string($link, $query[1]) . '";';
    $res = mysqli_query($link, $sql);
    if(mysqli_num_rows($res)){
      $row = mysqli_fetch_assoc($res);
      if($row['name']) $title = $row['name'];
      $image = $row['avatar'];
    }
  } else {
    $image = 'http://jsbot.cantelope.org/1HVS37.png';
  }
  $url =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "http:" : "http:") . "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
  $type = 'website';
  $description = 'Free code playground with the option to feature a video.';
?> <!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=1024"><title><?php echo $title?></title><meta name="description" content="<?php echo $description?>"><meta name="keywords" content="<?php $title . ' ' . $description?>"> <?php  if($image){?> <link rel="icon" href="<?php echo 'http://x.cantelope.org/a/imgProxy.php?url='.$image?>"><?php }else{?> <link rel="icon" href="http://jsbot.cantelope.org/1HVS37.png"> <?php }?> <?php  if($image){?><meta property="og:url" content="<?php echo $url?>"><?php }?> <?php  if($image){?><meta property="og:type" content="<?php echo $type?>"><?php }?> <?php  if($image){?><meta property="og:title" content="<?php echo $title?>"><?php }?> <?php  if($image){?><meta property="og:description" content="<?php echo $description?>"><?php }?> <?php  if($image){?><meta property="og:image" content="<?php echo $image?>"><?php }?> <?php  if($image){?><meta property="og:image:secure_url" content="<?php echo 'http://x.cantelope.org/a/imgProxy.php?url='.$image?>"><?php }?> <link href="css/app.00b479a4.css" rel="preload" as="style"><link href="js/app.041e9d75.js" rel="preload" as="script"><link href="js/chunk-vendors.65a56b13.js" rel="preload" as="script"><link href="css/app.00b479a4.css" rel="stylesheet"></head><body><noscript><strong>We're sorry but vidlist.whitehotrobot.com doesn't work properly without JavaScript enabled. Please enable it to continue...</strong></noscript><div id="app"></div><script src="js/chunk-vendors.65a56b13.js"></script><script src="js/app.041e9d75.js"></script></body></html>
