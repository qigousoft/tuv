<?php
$seach_arr = array(
	//每个表单控件NAME值作为KEY
	'eiregistername'=>array(
	  'kind'=>'company',   //要搜索的类型，企业搜索固定为company
	  'name'=>'eiregistername',
	  'msg'=>'企业名称',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'zuzhi_id',
	  'sql_kind'=>'in'
	),
	  'htcode'=>array(
	  'kind'=>'htcode',
	  'name'=>'htcode',
	  'msg'=>'合同编号',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'ht_id',
	  'sql_kind'=>'='
	),
	'htfrom'=>array(
	  'kind'=>'select',   //要搜索的类型
	  'name'=>'htfrom',
	  'msg'=>'合同来源',
	  'width'=>'80px',
	  'arr'=>$setup_htfrom,
	  'sql_field'=>'htfrom',
	  'sql_kind'=>'='
	),
	'invoice'=>array(
	  'kind'=>'text',
	  'name'=>'invoice',
	  'msg'=>'发票号',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'invoice',
	  'sql_kind'=>'='
	),
	'date_s'=>array(
	  'kind'=>'date1',
	  'name'=>'date_s',
	  'msg'=>'发票日期',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'invoicemoneytime',
	  'sql_kind'=>'>='
	),
	'date_e'=>array(
	  'kind'=>'date2',
	  'name'=>'data_e',
	  'msg'=>'',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'invoicemoneytime',
	  'sql_kind'=>'<='
	),
	'br'=>array(
		'kind'=>'br'
	),
	 'htxmcode'=>array(
	  'kind'=>'text',
	  'name'=>'htxmcode',
	  'msg'=>'项目编号',
	  'width'=>'80px',
	  'arr'=>'',
	  'sql_field'=>'',
	  'sql_kind'=>''
	)
);
?>