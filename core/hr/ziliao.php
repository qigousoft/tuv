<?php
$sql_temp = "AND r.idcode != 'admin' ";

if($s_ren_msg != ''){$sql_temp .= " AND r.ename = '$s_ren_msg'";}


$url = "index.php?m=hr&do=ziliao&s_ren_msg=$s_ren_msg&";

$params = array(
	'search' => $sql_temp,
	'url' => $url,
);
$result = ZiliaoDao::list_ziliao($params);

include TEMP.'header.htm';
include TEMP.'hr/ziliao.htm';
include TEMP.'footer.htm';
?>