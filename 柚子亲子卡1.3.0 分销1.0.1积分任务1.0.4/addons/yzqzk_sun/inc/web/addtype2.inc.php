<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

	$info = pdo_get('yzqzk_sun_type2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));


	$pid=$_GPC['type_id'];
//    p($pid);
	$type = pdo_getall('yzqzk_sun_type',array('uniacid' => $_W['uniacid']));

		if(checksubmit('submit')){

			$data['num']=$_GPC['num'];			
			$data['name']=$_GPC['name'];
			$data['state']=$_GPC['state'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){	
			$data['type_id']=$_GPC['type_id'];
				$res=pdo_insert('yzqzk_sun_type2',$data);

				if($res){
					message('添加成功',$this->createWebUrl('type2',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
                $data['type_id']=$_GPC['type_id'];

				$res = pdo_update('yzqzk_sun_type2', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('type2',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addtype2');