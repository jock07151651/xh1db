<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
    .content img{max-width:200px;max-height: 200px}
</style>
<script type="text/javascript" src="http://7xl3wn.com2.z0.glb.qiniucdn.com/socket.io.min.js"></script>
<script type="text/javascript" src="http://7xjfim.com2.z0.glb.qiniucdn.com/Iva.js"></script>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>已通过笑话</h5>
            </div>
            <div class="ibox-content">
            <form class="form-horizontal" submit-url="<?php echo U('xiaohua/delete');?>">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                        <tr>
                            <th class="text-center" width="50"><input type="checkbox"></th>
                            <th class="text-center" width="100">ID</th>
                            <th class="text-center" width="150">发布人</th>
                            <th class="text-center">内容</th>
                            <th class="text-center" width="80">类别</th>
                            <th class="text-center" width="100">笑点</th>
                            <th class="text-center" width="80">状态</th>
                            <th class="text-center" width="80">是否推荐</th>
                            <th class="text-center" width="150">发布时间</th>
                            <th class="text-center" width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($joke_list)): $i = 0; $__LIST__ = $joke_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                            <td class="text-center"><input type="checkbox" name="id[]" value="<?php echo ($val["id"]); ?>"></td>
                            <td class="text-center"><?php echo ($val["id"]); ?></td>
                            <td class="text-center"><img src="<?php echo ($val["user_info"]["avatar"]); ?>" width="80"/><br/><?php echo ($val["user_info"]["username"]); ?></td>
                            <?php if($val['type'] == 4): ?><td  class="text-center content"><b><?php echo ($val["title"]); ?></b><br/><br/><div id="video-<?php echo ($val['id']); ?>" style="width:600px;height:340px; margin-left:auto; margin-right:auto"></div></td>
                            <?php else: ?>
                            <td  class="text-center content"><b><?php echo ($val["title"]); ?></b><br/><br/><?php echo (htmlspecialchars_decode($val["content"])); ?></td><?php endif; ?>
                            <td class="text-center">
                            <?php if($val["type"] == 1): ?>文字<?php endif; ?>
                            <?php if($val["type"] == 2): ?>图片<?php endif; ?>
                            <?php if($val["type"] == 3): ?>动态图<?php endif; ?>
                            <?php if($val["type"] == 4): ?>视频<?php endif; ?>
                            <?php if($val["type"] == 0): ?><font color="red">未分类，请分类</font><?php endif; ?>
                            </td>
                            <td class="text-center"><?php if(is_array($val['tags'])): $i = 0; $__LIST__ = $val['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sval): $mod = ($i % 2 );++$i; echo ($sval["name"]); ?> &nbsp;<?php endforeach; endif; else: echo "" ;endif; ?></td>
                            <td class="text-center"><?php if($val["status"] == 2): ?><font style="color:#00ff00">已通过</font>
            <?php else: ?>
                <font style="color:#cccccc">未通过</font><?php endif; ?></td>
                            <td class="text-center" id="commend_<?php echo ($val["id"]); ?>"><?php if($val["commend"] == 1): ?><font style="color:#ff0000">已推荐</font><br/>
               <a href="javascript:commend(<?php echo ($val["id"]); ?>,0)" class="blue">取消推荐</a>
            <?php else: ?>
                <a href="javascript:commend(<?php echo ($val["id"]); ?>,1)" class="blue">推荐</a><br/>
                <font style="color:#cccccc">未推荐</font><?php endif; ?></td>
                            <td class="text-center"><?php echo (date('Y-m-d H:i:s',$val["created_time"])); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                <a href="javascript:void(0)" link-url="<?php echo U('xiaohua/edit',array('id' => $val['id']));?>"><button class="btn btn-white btn-sm" type="button"><em class="fa fa-pencil-square"></em> 修改</button></a>
                                <a href="javascript:void(0)" data-action="App.del" data-url="<?php echo U('xiaohua/delete');?>" data-id="<?php echo ($val['id']); ?>"><button class="btn btn-white btn-sm" type="button"><em class="fa fa-trash-o"></em>删除</button></a>
                                </div>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary btn-sm" type="button" data-form-action="App.del_select"><i class="fa fa-trash-o"></i> 批量删除</button>
                <div class="pull-right pagination m-t-no">
                    <?php echo (str_replace('href','href="javascript:void(0)" link-url',$page)); ?>
                </div>
                <div class="clearfix"></div>
                </from>
            </div>
        </div>
    </div>
</div>
<!--视频播放api-->
<script type="text/javascript">
<?php if(is_array($joke_list)): $i = 0; $__LIST__ = $joke_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; if($val['type'] == 4): ?>var ivaInstance = new Iva('video-<?php echo ($val["id"]); ?>',{appkey:'<?php echo ($setting["site_appkey"]); ?>',live:false,video:'<?php echo ($val["content"]); ?>',title:'<?php echo ($val["title"]); ?>',cover:'<?php echo ($val["image"]); ?>',});<?php endif; endforeach; endif; else: echo "" ;endif; ?>
</script>
<script type="text/javascript">
function commend(id,commend) {
    $.get("<?php echo u('xiaohua/commend');?>", { id: id,commend:commend}, function(jsondata){
        if(commend == 0) {
            $('#commend_'+id).html('<a href="javascript:commend('+id+',1)" class="blue">推荐</a><br/><font style="color:#cccccc">未推荐</font>');
        }else {
            $('#commend_'+id).html('<font style="color:#ff0000">已推荐</font><br/><a href="javascript:commend('+id+',0)" class="blue">取消推荐</a>');
        }

    },'json');
}
</script>