<?php
global $_W, $_GPC;
load() -> func('tpl');
include 'common.php';
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
if ($_W['fans']['follow']==0){
	include $this -> template('follow');
	exit;
};


$mid=$this->get_mid();




//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//提交家庭成员表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
	
		
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'hid'=>$hid,			
			'city'=>$_GPC['city'],
			'county'=>$_GPC['county'],
			'town'=>$_GPC['town'],
			'village'=>$_GPC['village'],
			'bianma'=>$bianma,
			'mbianma'=>$_GPC['mbianma'],
			'fname'=>$_GPC['fname'],
			'sex'=>$_GPC['xb'],
			'id_card'=>$_GPC['id_card'],
			'guanxi'=>$_GPC['guanxi'],
			'nation'=>$_GPC['nation'],
			'education'=>$_GPC['education'],
			'school'=>$_GPC['school'],			
			'healthy'=>$_GPC['healthy'],
			'skill'=>$_GPC['skill'],			
			'workers'=>$_GPC['workers'],
			'workerstime'=>$_GPC['workerstime'],
			'medicalinsurance'=>$_GPC['medicalinsurance'],				
			'tpattr'=>$_GPC['tpattr'],
			'pkhattr'=>$_GPC['pkhattr'],
			'reason'=>$_GPC['reason'],
			'wfh'=>$_GPC['wfh'],
			'ysaq'=>$_GPC['ysaq'],	
			'yskn'=>$_GPC['yskn'],		
			'income'=>$_GPC['income'],
			'tel'=>$_GPC['tel'],
			'domicile'=>$_GPC['domicile'],				
			'residence'=>$_GPC['residence'],
			'political'=>$_GPC['political'],
			'marriage'=>$_GPC['marriage'],
			'flow'=>$_GPC['flow'],
			'home'=>$_GPC['home'],			
			'identity'=>$_GPC['identity'],
			'birth'=>$_GPC['birth'],
			'remark'=>$_GPC['remark'],				
			'factime'=>time(),
			'birthday'=>strtotime($_GPC['birthday']),
            'lonely'=>intval($_GPC['lonely']),
            'children'=>intval($_GPC['children']),
            'poverty'=>intval($_GPC['poverty']),
            'disability'=>intval($_GPC['disability']),
			 );
		$res = pdo_insert('nx_information_family', $newdata);
		if (!empty($res)) {
			message('提交成功！', $this -> createMobileUrl('family_list'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('family_add'), 'error');
		}

	}

}
	


include $this -> template('family_add');

?>