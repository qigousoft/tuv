<?php
/**
 * ������������
 * @2011-4-27
 *
 *
 */

class setup_lianxi{
	private $db;
	private $dbtable;

	public function __construct() {
		global $db,$dbtable;
		$this->db = $db;
		$this->dbtable = $dbtable;
	}
	//ʹ��״̬
	public function showonline($online){
		$online == '1' ? $online = '����' : $online = '<font color=red>ͣ��</font>';
		return $online;
	}

	//���������ļ�
	public function file_setup(){
		$db = $this->db;
		$rst = DBUtil::GetArr($db,$this->dbtable['setup_lianxi'],'',' 1 ORDER BY isdesc ASC');
		$cache = "<?php\n";
		$cache .= "\$setup_lianxi=array(\n";
		foreach($rst as $v){
			$cache .= "\t'$v[code]' =>array(
			\n\t\t'code'=>'$v[code]',
			\n\t\t'msg'=>'$v[msg]',
			\n\t\t'online'=>'$v[online]'),\n";
		}
		$cache .= "\n);\n?>";
		File::writeFile(SET_DIR.'setup_lianxi.php', $cache);
	}

	//�б�������������Ϣ
	public function list_setup($params = array()){
		$search = $params['search'];
		$url = $params['url'];
		$sql['count'] = "SELECT COUNT(*) AS sum	FROM `{$this->dbtable[z_lianxi]}` WHERE 1 $search";
		$sql['data'] = "SELECT * FROM `{$this->dbtable[z_lianxi]}` WHERE 1 $search  ORDER BY isdesc ASC";
		$page = new Page($url, $sql);
		$result['data'] = $page->getPageData();
		$result['pages'] = $page->nav;
		$result['count'] = $page->count;
		return $result;
	}

	//��ȡ����������������
	public function get_setup($id,$fields=array()){
		$db = $this->db;
		$rst = DBUtil::GetOne($db, $this->dbtable['setup_lianxi'], '', "id='$id'");
		return $rst;
	}

	//����������������
	public function add_setup($value){
		$db = $this->db;
		DBUtil::insert_tb($db, $this->dbtable['setup_lianxi'], $value);
		$this->file_setup();
		return true;
	}

	//�޸ĸ�����������
	public function edit_setup($id, $value){
		$db = $this->db;
		DBUtil::update_tb($db, $this->dbtable['setup_lianxi'], $value, "id='$id'");
		$this->file_setup();
		return true;
	}

	//ɾ��������������
	public function del_setup($id){
		$db = $this->db;
		DBUtil::Del($db, $this->dbtable['setup_lianxi'], "id='$id'");
		$this->file_setup();
		return true;
	}
}

?>