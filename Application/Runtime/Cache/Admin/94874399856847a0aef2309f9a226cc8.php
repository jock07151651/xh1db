<?php if (!defined('THINK_PATH')) exit();?><div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本设置</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" submit-url="<?php echo U('setting/setting');?>" method="POST">
                        <input type="hidden" name="data" value="<?php echo ($data); ?>" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站名称：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_name"]' value="<?php echo ($setting['site_name']); ?>" class="form-control" placeholder="请输入网站名称">
                            </div>
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如：虾囧网</span>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站域名：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_domain"]' value="<?php echo ($setting['site_domain']); ?>" class="form-control" placeholder="http://">
                            </div>
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如：http://www.lvchakeji.com</span>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机网站域名：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_murl"]' value="<?php echo ($setting['site_murl']); ?>" class="form-control" placeholder="http://">
                            </div>
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如：http://m.lvchakeji.com</span>
                        </div>                     
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">上传LOGO：</label>
                            <div class="col-sm-2">
                                <div class="input-group uploaderbox">
                                    <input type="hidden" name='setting["site_logo"]' value="<?php echo ($setting['site_logo']); ?>"/>
                                    <img src="<?php echo ($setting['site_logo']); ?>" width="150" height="75" class="img-responsive">
                                    <input type="file" id="site_logo"/>
                                </div>
                            </div>
                        </div>
                         <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">上传二维码：</label>
                            <div class="col-sm-2">
                                <div class="input-group uploaderbox">
                                    <input type="hidden" name='setting["site_qrcode"]' value="<?php echo ($setting['site_qrcode']); ?>"/>
                                    <img src="<?php echo ($setting['site_qrcode']); ?>" width="150" height="75" class="img-responsive">
                                    <input type="file" id="site_qrcode"/>
                                </div>
                            </div>
                        </div>           
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站关键字：</label>
                            <div class="col-sm-4">
                                <textarea name='setting["site_keyword"]' class="form-control"><?php echo ($setting['site_keyword']); ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站描述：</label>
                            <div class="col-sm-4">
                                <textarea name='setting["site_desc"]' class="form-control"><?php echo ($setting['site_desc']); ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备案信息：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_icp"]' value="<?php echo ($setting['site_icp']); ?>" class="form-control" placeholder="请输入备案信息">
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">前台模板选择：</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="hometpl"><?php if(is_array($dir)): $i = 0; $__LIST__ = $dir;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><option value="<?php echo ($admin["filename"]); ?>" <?php if($admin["filename"] == $Setting_config['DEFAULT_THEME']): ?>selected<?php endif; ?>><?php echo ($admin["filename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">站长邮箱：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_email"]' value="<?php echo ($setting['site_email']); ?>" class="form-control" placeholder="请输入电子邮箱">
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">视频播放器APPKey：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_appkey"]' value="<?php echo ($setting['site_appkey']); ?>" class="form-control" placeholder="请输入视频播放器APPKey">
                              </div>
                            <span class="help-block m-b-none"><a class="text-navy" href="http://www.videojj.com" target="_blank">马上获取APPKey</a></span>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">采集接口密码：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_caiji"]' value="<?php echo ($setting['site_caiji']); ?>" class="form-control" placeholder="请输入采集接口密码">
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">采集关联的用户ID：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_userid"]' value="<?php echo ($setting['site_userid']); ?>" class="form-control" placeholder="请输入关联的用户ID">
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">统计代码：</label>
                            <div class="col-sm-4">
                                <textarea name='setting["site_tongji_code"]' class="form-control"><?php echo ($setting['site_tongji_code']); ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">版权信息：</label>
                            <div class="col-sm-4">
                                <textarea name='setting["site_copyright"]' class="form-control"><?php echo ($setting['site_copyright']); ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">系统启闭：</label>
                            <div class="col-sm-2">
                                <label class="radio-inline">
                                    <input type="radio" value="0" name='setting["site_status"]' <?php if($setting['site_status'] == 0): ?>checked<?php endif; ?>>开启
                                    </label>
                                <label class="radio-inline">
                                    <input type="radio" value="1" name='setting["site_status"]' <?php if($setting['site_status'] == 1): ?>checked<?php endif; ?>>关闭
                                    </label>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关闭说明：</label>
                            <div class="col-sm-4">
                                <textarea name='setting["site_colse_desc"]' class="form-control"><?php echo ((isset($setting['site_colse_desc']) && ($setting['site_colse_desc'] !== ""))?($setting['site_colse_desc']):'系统维护中，请稍候访问！'); ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">积分文字配置：</label>
                            <div class="col-sm-2">
                                <input type="text" name='setting["site_jifen"]' value="<?php echo ($setting['site_jifen']); ?>" class="form-control" placeholder="请输入积分文字">
                            </div>
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 例如：囧币、金币、积分</span>
                        </div>
                        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                        
                        <div class="form-group">
                            <div class="col-sm-12 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit" data-form-action="App.submit_form"><i class="fa fa-check"></i> 保 存</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
         seajs.use(['upload'], function(upload){
                upload.uploadify('#site_logo','logo','image');
                upload.uploadify('#site_qrcode','image','image');
                $("input#water-text-color").minicolors({theme: 'bootstrap'});
                $("input#water-bgcolor").minicolors({theme: 'bootstrap'});
          });
    </script>