<?php
!defined('IN_SUPU') && exit('Forbidden');
include_once S_DIR.'/include/module/Item.php';
include_once S_DIR.'/include/module/Auditor.php';
include(S_DIR.'include/topsearch.php');
include_once S_DIR.'include/setup/setup_htfrom.php';
include_once S_DIR.'include/setup/setup_audit_type.php';
include_once S_DIR.'include/setup/setup_audit_iso.php';

Power::CkPower('K1S');
$width='1200px';
$seach_arr = array(
	//每个表单控件NAME值作为KEY
	'eiregistername'=>array(
	  'kind'=>'company',   //要搜索的类型，企业搜索固定为company
	  'name'=>'eiregistername',
	  'msg'=>'企业名称',
	  'width'=>'100px',
	  'arr'=>'',
	  'sql_field'=>'zuzhi_id',
	  'sql_kind'=>'in'
	),
	'audit_type'=>array(
	  'kind'=>'select',
	  'name'=>'audit_type',
	  'msg'=>'审核类型',
	  'width'=>'70px',
	  'arr'=>$setup_audit_type,
	  'sql_field'=>'',
	  'sql_kind'=>''
	),
	'taskBeginDate1'=>array(
	  'kind'=>'date1',
	  'name'=>'taskBeginDate1',
	  'msg'=>'审核开始日期',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'taskBeginDate',
	  'sql_kind'=>'>='
	),
   'taskBeginDate2'=>array(
	  'kind'=>'date2',
	  'name'=>'taskBeginDate2',
	  'msg'=>'',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'taskBeginDate',
	  'sql_kind'=>'<='
	),
	'empName'=>array(
	  'kind'=>'text',
	  'name'=>'empName',
	  'msg'=>'审核员',
	  'width'=>'100px',
	  'arr'=>'',
	  'sql_field'=>'empName',
	  'sql_kind'=>'%like%'
	),
	'br1'=>array(
	'kind'=>'br'
	),
	'htxmcode'=>array(
		'kind'=>'text',
		'name'=>'htxmcode',
		'msg'=>'项目编号',
		'width'=>'100px',
		'arr'=>'',
		'sql_field'=>'',
		'sql_kind'=>''
	  ),
	'iso'=>array(
	  'kind'=>'select',
	  'name'=>'iso',
	  'msg'=>'认证体系',
	  'width'=>'70px',
	  'arr'=>$setup_audit_iso,
	  'sql_field'=>'',
	  'sql_kind'=>''
	),
	  'taskEndDate1'=>array(
	  'kind'=>'date1',
	  'name'=>'taskEndDate1',
	  'msg'=>'审核结束日期',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'taskEndDate',
	  'sql_kind'=>'>='
	),
	  'taskEndDate2'=>array(
	  'kind'=>'date2',
	  'name'=>'taskEndDate2',
	  'msg'=>'',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'taskEndDate',
	  'sql_kind'=>'<='
	),
	'htfrom'=>array(
	  'kind'=>'select',   //要搜索的类型
	  'name'=>'htfrom',
	  'msg'=>'合同来源',
	  'width'=>'104px',
	  'arr'=>$setup_htfrom,
	  'sql_field'=>'htfrom',
	  'sql_kind'=>'='
	),
	'br2'=>array(
	'kind'=>'br'
	),
	'product'=>array(
		'kind'=>'text',
		'name'=>'product',
		'msg'=>'认证产品',
		'width'=>'100px',
		'arr'=>'',
		'sql_field'=>'',
		'sql_kind'=>''
	)
);
$TopSearch = new TopSearch($seach_arr);
//构造翻页地址
$baseurl	= 'index.php?m='.$TopSearch->SearchName['m'].'&do='.$TopSearch->SearchName['do'].'&';
$url		= $baseurl.$TopSearch->SearchUrl;
$sql_temp	= $TopSearch->SearchSql;		//构造搜索SQL
$SearchHtml	= $TopSearch->SearchHtml;		//构造搜索HTML表单项

if($htxmcode != ''){
	$htxmid = array();
	$sql = "SELECT id FROM ht_contract_item WHERE htxmcode like '%{$htxmcode}%'";
	$query = $db->query($sql);
	while($rows = $db->fetch_array($query)){
		$htxmid []= $rows['id'];
	}
	$htxmid = implode('\',\'',$htxmid);
	$xm_q = $db->query("SELECT taskId FROM xm_item WHERE htxm_id in ('$htxmid')");
	while($xm = $db->fetch_array($xm_q)){
		$taskId_t []= $xm['taskId'];
	}
	$taskId_t = implode("','",$taskId_t);
	$sql_temp = "  and taskId IN('$taskId_t')".$sql_temp;
}

if ($iso != ''){$sql_temp = $sql_temp." and id in(SELECT auditorId FROM {$dbtable['xm_auditor_plan']} WHERE iso='{$iso}')";}
if ($audit_type != ''){$sql_temp = $sql_temp." and taskId in(SELECT taskId FROM {$dbtable['xm_item']} WHERE audit_type='{$audit_type}')";}
if($product!='')
{
	$sql_temp = $sql_temp." AND taskId  IN(SELECT taskId FROM xm_item WHERE ht_id IN (SELECT ht_id FROM ht_contract_item  WHERE product in( SELECT code FROM setup_product WHERE msg LIKE '%$product%' )))";
}
$sql_temp  = "and online=0 and taskId in (SELECT id FROM `xm_task` WHERE `xmonline` ='3') and empId ='".$_SESSION['userid']."'".$sql_temp;
$params = array(
	'search' => $sql_temp,
	'url' => $url,
);

$Auditor = new Auditor();
$result = $Auditor->listAuditor($params);

include_once TEMP.'header.htm';
include_once TEMP.'auditor/au_audit_item_list.htm';
include_once TEMP.'footer.htm';
?>