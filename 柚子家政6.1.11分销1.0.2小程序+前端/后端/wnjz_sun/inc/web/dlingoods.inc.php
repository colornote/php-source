<?php

global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$where=" WHERE  a.uniacid=:uniacid  and b.cityname=:cityname";
$type=isset($_GPC['type'])?$_GPC['type']:'wait';
if(isset($_GPC['keywords'])){
    $op=$_GPC['keywords'];
      $where.=" and a.goods_name LIKE  concat('%', :name,'%') ";  
       $data[':name']=$op;
       $type='all';
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and a.time >={$start} and a.time<={$end}";

}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

if($type=='wait'){
  $_GPC['state']=1;
}
if($_GPC['state']){
      $where.=" and a.state={$_GPC['state']} ";  

}
 $data[':uniacid']=$_W['uniacid'];
 $data[':cityname']= $_COOKIE['cityname'];
  $sql="select a.*,b.store_name from " . tablename("wnjz_sun_goods") . " a"  . " left join " . tablename("wnjz_sun_store") . " b on a.store_id=b.id" .$where."  order by a.time desc ";
  $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("wnjz_sun_goods") . " a"  . " left join " . tablename("wnjz_sun_store") . " b on a.store_id=b.id".$where."  order by a.time desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('wnjz_sun_goods',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl2('dlingoods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('wnjz_sun_goods',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl2('dlingoods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_goods',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl2('dlingoods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/dlingoods');