<?php
  //$db_user  = 'id21269596_user';
  //$db_user  = 'id21284549_user';
  //$db_user  = 'id21257390_user';
  $db_user  = 'id21552617_user';
  $db_pass  = 'Chrome57253!*';
  $db_host  = 'localhost';
  //$db       = "id21269596_videodemos";
  //$db       = "id21284549_videodemos2";
  //$db       = "id21257390_default";
  $db       = "id21552617_orbs2";
  $port     = '3306';
  $link     = mysqli_connect($db_host,$db_user,$db_pass,$db,$port);

	//$db_user="id21284549_user";
	//$db_pass="Chrome57253!*";
	//$db_host="localhost";
	//$db="id21284549_videodemos2";
	$baseDomain="x.cantelope.org";
	$appletDomain="x.cantelope.org";
	$baseURL="http://$baseDomain/codegolf";
	$appletURL="http://$appletDomain/applet";
?>
