<?php
!defined('IN_SUPU') && exit('Forbidden');
include(S_DIR.'include/module/setup_orgtype.php');
GrepUtil::InitGP(array('id'));
if ($id) {
	$s = new setup_orgtype();
	$rst = $s->get_setup($id);
}

include TEMP.'header.htm';
include TEMP.'setup/setup_orgtype_edit.htm';
include TEMP.'footer.htm';
?>