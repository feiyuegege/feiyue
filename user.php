<?php 
//-----------------------请修改以下配置------------------------------------

//防盗链域名，多个用|隔开，（不设置盗链请留空，请填写授权是顶级域名的二级域名）
define('REFERER_URL', ''); //如：define('REFERER_URL', 'www.8090.la|jiexi.baidu.com|8090g.cn');

//此处设置防盗信息及错误提示
define('ERROR', '<html><meta name="robots" content="noarchive"><head><title>全网视频在线解析服务</title></head><style>h1{color:#C7636C; text-align:center; font-family: Microsoft Jhenghei;}p{color:#f90; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>本站接口不对外开放</h1><p>如需使用，请联系本站管理员进行授权</p></table></body></html>');
//此处进行用户相关配置
$user = array(

		'uid' => '', //这里填写你的UID信息(填写在单引号内),用户授权UID，在 http://user.seakee.cn 平台可以查看

		'token' => '', //这里填写你的用户密匙信息(填写在单引号内),用户授权TOKEN，在 http://user.seakee.cn 平台可以查看

		'path' => '/8090', //一般不用修改,除非你放置在根目录或其他目录，默认在8090目录，修改格式 '/8090' （修改二级目录一定看好格式），如果放在根目录就请留空，格式：'path' => ''

		'hdd' => '3', //视频默认清晰度，1标清，2高清，3超清，如果没有高清会自动下降一级（请保持默认，无需修改）
  
  		'p2p' => '0', //是否显示P2P加速信息 默认开启 1:开启,0:关闭 （关闭显示不影响加速效果）

		'autoplay' => '1', //电脑端autoplay是否自动播放：参数设置为：1,表示自动播放;参数设置为：0,表示不自动播放

		'h5' => '0', //手机端h5是否自动播放：参数设置为：1,表示自动播放;参数设置为：0,表示不自动播放

		'online' => '1', //当前无法解析的地址是否启动备用解析接口  默认开启,1:开启,0:关闭  开启时要在下面填入备用解析接口
  
		'ather' => 'https://www.8090.la/beiyong2021/?url=', //已为大家设置好备用接口,无特殊要求可以不用更改,如果不需要删除即可.//填写实例：'ather' => 'https://www.8090g.cn/?url=',

		'dplayer' => '', //用户设置dplayer播放器右键,不设置请留空。填写实例:'dplayer' => '8090解析,https://www.8090g.cn'
		
		'title' => '', //设置解析页面title名称   例如：'title' => '8090视频解析',

		'tongji' => '', //用户统计代码.  例如:s6.cnzz.com/z_stat.php?id=xxxxx&web_id=xxxxx,百度统计与之类似.不会添加的话就直接把统计代码加到index.php底部!

		'ad' => '', //用户设置广告代码,例如:xxx.com/xxx.js,无需添加http,多个广告请用逗号分开!也可以直接把广告代码加到index.php底部!

		'hand' => '', //ckplayer播放器右键,例如:'hand'=>'8090g解析,https://www.8090g.cn'

) 			
//-----------------------修改区域结束---------------------------------------
?>