<?php
if(version_compare(PHP_VERSION,'5.4.0','<')){exit('请升级当前PHP环境,本版本解析需PHP5.4以上版本支持！');}
define('SELF', pathinfo(__file__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __file__)));
require_once FCPATH . 'config.php';
@$url = htmlspecialchars($_GET['url'] ? $_GET['url'] : $_GET['vid']);
if(!isset($_GET['url'])){
	exit('<html><meta name="robots" content="noarchive"><head><title>全网视频解析</title></head><style>h1{color:#C7636C; text-align:center; font-family: Microsoft Jhenghei;}p{color:#f90; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>欢迎使用本站解析系统</h1><p>如有任何问题请联系管理员处理，本站第一时间为您解决后顾之忧</p></table></body></html>');
} else if(isset($_GET['url'])&&$_GET['url'] == ''){
	exit('<html><meta name="robots" content="noarchive"><head><title>全网视频解析</title></head><style>h1{color:#00FFFF; text-align:center; font-family: Microsoft Jhenghei;}p{color:#CCCCCC; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>温馨提示：Url地址为空~!</h1><p>&nbsp;</p><p>&nbsp;</p><p></p><p class="STYLE2"><font size="2">本系统只为内部交流学习，不以盈利为目的<br>所有资源均来源第三方资源，并不提供影片资源存储，录制、上传相关视频等，视频版权归属其合法持有人所有,本站不对使用者的行为负担任何法律责任<br>如果有因为本站而导致您的权益受到损害，请与我们联系，我们将理性对待，协助你解决相关问题。 </font><font size="2"></font></p></table></body></html>');
}
if(strstr($url,'miguvideo.com')==true){preg_match('|cid=(\d+?)|U',$url,$cid);$url=$cid['1'].'@miguvideo';}elseif (strstr($url, 'm.v.qq.com')==true){parse_str(str_replace('?', '&', $_SERVER['QUERY_STRING']),$list);if ($list['vid'] && $list['cid']){$url='https://v.qq.com/x/cover/'.$list['cid'].'/'.$list['vid'].'.html';}elseif ($list['vid']){$url='https://v.qq.com/x/cover/'.$list['vid'].'/'.$list['vid'].'.html';}elseif ($list['cid']){$url='https://v.qq.com/x/cover/'.$list['cid'].'.html';}}elseif (strstr($url, 'm.fun.tv')==true){parse_str(str_replace('?', '&', $_SERVER['QUERY_STRING']),$list);if ($list['mid'] && $list['vid']){$url='https://www.fun.tv/vplay/g-'.$list['mid'].'.v-'.$list['vid'];}elseif($list['mid']){$url='https://www.fun.tv/vplay/g-'.$list['mid'].'/';}elseif($list['vid']){$url='https://www.fun.tv/vplay/v-'.$list['vid'].'/';}}$a=new __abose();$us_lotime=0;if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){$ios = '1';}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){$ios = '0';}if (!$a->is_referer()){if(USER_LOTIME ==''|| USER_LOLINK==''){header('HTTP/1.1 403 Forbidden');exit(ERROR);}else{$us_lotime='1';}}$c_to_yz=$a->xxtea_encrypt(C_ROOT_TOKEN,C_ROOT_KEY);if (!is_dir('cache/')) mkdir('cache/');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/> 
<meta name="renderer" content="webkit"/>
<meta name="referrer" content="never">
<meta http-equiv="Access-Control-Allow-Origin" content="*" />
<meta http-equiv="X-UA-Compatible" content="IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=USER_TITLE?USER_TITLE:'解析系统';?></title>
<style type="text/css">body,html,.content{background-color:black;padding: 0;margin: 0;width:100%;height:100%;color:#999;}.divs{width:100%;height:auto;position:fixed;left:0;top:0;z-index:999}</style>
<link rel="stylesheet" href="<?=$user['path'];?>/player/dplayer/Dplayer.min.css"/>
<script type="text/javascript" src="//apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=$user['path'];?>/player/ckplayer/ckplayer.js"></script>
<script type="text/javascript" src="<?=$user['path'];?>/player/ckplayer/base64.js"></script>
<script type="text/javascript" src="<?=$user['path'];?>/player/dplayer/flv.min.js"></script>
<script type="text/javascript" src="<?=$user['path'];?>/player/dplayer/Dplayer.min.js"></script>
<script type="text/javascript" src="<?=$user['path'];?>/player/dplayer/hls.min.js"></script>
<style type="text/css">#stats{position:fixed;top:5px;left:0px;font-size:12px;color:rgb(0,200,200);z-index:2147483647;text-shadow:1px 1px 1px #000, 1px 1px 1px #000}</style>
</head>
<body style="overflow-y:hidden;">
<div id="loading" align="center"><div style="padding-top:20%;width='100%';height='100%"><span class="tips">视频正在加载，客官请稍等... <font class="timemsg">0</font> 秒<br><br><img border="0" <img="" src="loading.gif"></span></div><span class="timeout" style="display:none;color:#f90;">服务器响应超时，请刷新重试！</span></div>
<input type="hidden" id="k1" value='<?= time(); ?>'/>
<div id="a1" class="content" style="background: #000000;width='100%';height='100%" align="center"></div>
<div id="stats"></div>
<div id="error" class="content" style="display:none;color:#f90;padding-top:20%;width='100%';height='100%" align="center"></div>
<script type="text/javascript">
function tipstime(count){
    $('.timemsg').text(count);
    if (count == 20) {
       $('.tips').hide();
       $('.timeout').show();
    } else {
        count += 1;
        setTimeout(function () {
            tipstime(count);
        }, 1000);
    }
}
tipstime(0);
skin={'skin':'<?=$user['skin']?>','hand':'<?=$user['hand']?>','logo':'<?=$user['cklogo']?>','href':'<?=$user['ckhref']?>','font':'<?=$user['ckfont']?>','dp':'<?=$user['dplayer']?>','expire':'<?=$user['danmaku']?>','autoplay':'<?=$user['autoplay']?>','id':'<?=C_ROOT_ID?>'};site_domaim=function(){var path=window.location.pathname;if(path.indexOf(".")>-1){var i=path.lastIndexOf("/");var path=path.substring(0,i+1);}return path;}();ver='<?=base64_encode(VERSION)?>';auto='<?=USER_AUTO=="1"?1:0;?>';auto_h5='<?=USER_AUTO_H5=="1"?1:0;?>';var str_href=window.location.href,other_l =str_href.substring(str_href.indexOf('=')+1);if(!other_l){var other_l='kkkk';};function player(){var y = new Base64();var isiPad=navigator.userAgent.match(/iPad|iPhone|Android|Linux|iPod/i)!=null;var form;if(isiPad){form='1';}else{form='0';}$.post("api.php",{'url':'<?php echo $url; ?>','referer':'<?=base64_encode(@$_SERVER['HTTP_REFERER']);?>','ref':form,'time':'<?= time() ?>','type':'<?=htmlspecialchars(@$_REQUEST['type']);?>','other':y.encode(other_l),'ref':form,'ios':'<?php echo $ios;?>'},function(data){if(data.code=="200"){var _0xods='jiexi',_0x3f70=[_0xods,'w5nCkio=','KMO7Tm4=','w4zDiBnCgR5sNcKzw40xQxs2w4DCvcKBw5fCnGHDs8OuSgdJwoRKci/DlcKocD/DlUXClsOdw7RSwoMXw7NgGcODWh7DlsOhw6hvw5pmw65QZB9IT8OoDzYew6XDoCl2EWbDvFnCoztZJcOFV8OMMH/DhcK6woTDpknDvXpGNMKpwrVkw4rDg8KgLsKDfk5/FUrDi13DgkAQwqErwp0eMMKzLWnDgHNbPRQIw7M=','FcODwqhkYw==','wqvDvSDCtsKd','T8KFRsKYSA==','w5HCkcKgMsOV','wr/CjcKBUX8=','eMKCT8Kt','HkPCtA==','wr48w54=','T8KJwo8ZRw==','wp/ClcKl','bcK7woIYTw==','WBFHG8KG','eMKYXsK5aQ==','woDDksO8w6vDmcOdw5fClsOKb1TDnkDCm1tywrI=','OBEKw4HDnClYw7rCqg==','wpTDmCHCnRvDtQ7CoQ==','w5Z2worDvxvDqE7Cl8Ohw7fDoFTDsg==','wpnDtT/Csyc=','wpXCkXF7Bj4=','wo7CtcK8Tns=','wpnDuCPCscK2','UcO0U3HClmQ=','BcKsw5ZCw7PDlgM=','wonCiMKncV8Uw5Q=','O0TCj8KUw5o=','ScOew77Ckyw=','wpIHQw==','woFyw5rDpl3DoBLChMK/','wobDny7CnQo=','VVN5BQ==','wqXDpMOpYRc=','XcKCw4LCqgzDo8OT','bho4','XQ1mOA==','w6XCu8KXKcONwoYl','wq42w5HCkMK1woYxUno=','wrLDrQXCqA==','FMKjw7DCizgqwrQ=','JMOqQXfCgg==','TsKFC8O/','XxnDi00=','wpZvw5/Dpl/Dph7CmQ==','aMOcwqpZLGZT','wrjDscOzbRE=','Z8OUw6J9w6XDjsKtwq45w7zDrSTCrMKjdhzCj8OLHsO1','wobCjRHCgQ==','U1HDtn/Dvk0Dw4bCi8Orw70=','bXPDug==','ciVYwqw1wqh/','wonDvQfCmw==','wpzCjQDCiUItNg==','H0jCqMKh','wpYcSVY=','w7nCssKf','w5DCjTjClwvDqAnDsiwYAMKWwp/CryTDn8ObU8O4w5d8w5bDrsKrw68uUcK/w7pQdyjDmcKbcRPCnmIpcAgIw4XDvyPCr8OsURQHw4l9w7/ChsOzPMOqwoRvwoXCpDnCp8KswqrDqAlUw7rCq3QVUHTClTbDm8OKbMOdb8KdwqFWwp7CusKmwonCqMKlYsOYwr9zwo3CqcOVw6zCv3I4woLDpjjCvgzDvDnDrx7ClsOgwr7CtGLCiUvDrVAFwqPCqcOtQMK8UEILOF9dw6zDkE3Cqk9XwobDlcKCQ8KnI8K8YcOcFMKRwqtZwoF5wqnCocKUAcK+wo/CncOFw61pNgUXw7N+w6EYwoXDnMO5XsOkwpodw59Gw7/CrEB6OsO9wpHDphnCr8OUHFvCuCnDvsKkHMOzwpzCosKhwpLDoMKaF0UBMglzHSbCrcKteik5w55awpTChsODLWQgwqzDsSXCtsKzVcOUYW9fJMOXZnPDgsOoJyU9Q8Oxw4IVwqPCg8Ktw6zCrkdABcKvwodNwr3Cu3rDmjXCkcKbOD/CuMK5EsKadsKnwoI/ehjCjU9Lw6nCsTtzTcOcVcKNL04BBEvDn8K5SsO2w7LCi8OmwrxOasKew5opCsKZNDzDlcOsWhAMwpvCgcOCw5JL','TgtNBw==','w7LCrMKPPg==','w6zCp8KWNA==','OxYAw4LDlQ==','w4XDnMKj','wqLDng7Crig=','w67CjcKNwqXDmQ==','S8Kfw4A=','wrDDosOubRo=','Y0dPCEc=','w7bCuMKYIw==','NGglw6o=','wrjCvsK8BQ==','Xx54','wo9bwq7DmcKM','w43DmyTCmxbCoQ==','wpvCmhw=','wofDnyM=','wq1Qw7XDtms=','MMOjQns=','RQDDi10=','QB97OA==','DMOewoxtQA==','R1PDqg==','RwtgIA==','w5Q5w5TCig==','OA0C','w6/CusKfNQ==','wqvDrwLCvg==','E8OGwotyRg==','jWiYbHUJBexEiSOVaSsZlQu=='];(function(_0x450a69,_0x3e7aa1,_0x254e7f){var _0x416eeb=function(_0x441bef,_0x4ac2bc,_0x47a658,_0x5bd788,_0x4d4c31){_0x4ac2bc=_0x4ac2bc>>0x8,_0x4d4c31='po';var _0x3c8e62='shift',_0x119e22='push';if(_0x4ac2bc<_0x441bef){while(--_0x441bef){_0x5bd788=_0x450a69[_0x3c8e62]();if(_0x4ac2bc===_0x441bef){_0x4ac2bc=_0x5bd788;_0x47a658=_0x450a69[_0x4d4c31+'p']();}else if(_0x4ac2bc&&_0x47a658['replace'](/[WYbHUJBESOVaSsZlQu=]/g,'')===_0x4ac2bc){_0x450a69[_0x119e22](_0x5bd788);}}_0x450a69[_0x119e22](_0x450a69[_0x3c8e62]());}return 0x941a8;};return _0x416eeb(++_0x3e7aa1,_0x254e7f)>>_0x3e7aa1^_0x254e7f;}(_0x3f70,0x10b,0x10b00));var _0x6324=function(_0x809e09,_0x53aac3){_0x809e09=~~'0x'['concat'](_0x809e09);var _0x5afbf7=_0x3f70[_0x809e09];if(_0x6324['pkRfmM']===undefined){(function(){var _0x2c17a2=typeof window!=='undefined'?window:typeof process==='object'&&typeof require==='function'&&typeof global==='object'?global:this;var _0x3899ee='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x2c17a2['atob']||(_0x2c17a2['atob']=function(_0x50c403){var _0x26a60a=String(_0x50c403)['replace'](/=+$/,'');for(var _0x154ad7=0x0,_0x1ff618,_0x1fe573,_0x3a7c1f=0x0,_0x51e51d='';_0x1fe573=_0x26a60a['charAt'](_0x3a7c1f++);~_0x1fe573&&(_0x1ff618=_0x154ad7%0x4?_0x1ff618*0x40+_0x1fe573:_0x1fe573,_0x154ad7++%0x4)?_0x51e51d+=String['fromCharCode'](0xff&_0x1ff618>>(-0x2*_0x154ad7&0x6)):0x0){_0x1fe573=_0x3899ee['indexOf'](_0x1fe573);}return _0x51e51d;});}());var _0x231556=function(_0x1c3385,_0x53aac3){var _0x1d241c=[],_0x531e3b=0x0,_0x52e97a,_0x2ffc12='',_0x2808e2='';_0x1c3385=atob(_0x1c3385);for(var _0x4b0647=0x0,_0x47e326=_0x1c3385['length'];_0x4b0647<_0x47e326;_0x4b0647++){_0x2808e2+='%'+('00'+_0x1c3385['charCodeAt'](_0x4b0647)['toString'](0x10))['slice'](-0x2);}_0x1c3385=decodeURIComponent(_0x2808e2);for(var _0x2188ae=0x0;_0x2188ae<0x100;_0x2188ae++){_0x1d241c[_0x2188ae]=_0x2188ae;}for(_0x2188ae=0x0;_0x2188ae<0x100;_0x2188ae++){_0x531e3b=(_0x531e3b+_0x1d241c[_0x2188ae]+_0x53aac3['charCodeAt'](_0x2188ae%_0x53aac3['length']))%0x100;_0x52e97a=_0x1d241c[_0x2188ae];_0x1d241c[_0x2188ae]=_0x1d241c[_0x531e3b];_0x1d241c[_0x531e3b]=_0x52e97a;}_0x2188ae=0x0;_0x531e3b=0x0;for(var _0x5cbd76=0x0;_0x5cbd76<_0x1c3385['length'];_0x5cbd76++){_0x2188ae=(_0x2188ae+0x1)%0x100;_0x531e3b=(_0x531e3b+_0x1d241c[_0x2188ae])%0x100;_0x52e97a=_0x1d241c[_0x2188ae];_0x1d241c[_0x2188ae]=_0x1d241c[_0x531e3b];_0x1d241c[_0x531e3b]=_0x52e97a;_0x2ffc12+=String['fromCharCode'](_0x1c3385['charCodeAt'](_0x5cbd76)^_0x1d241c[(_0x1d241c[_0x2188ae]+_0x1d241c[_0x531e3b])%0x100]);}return _0x2ffc12;};_0x6324['YZYDFc']=_0x231556;_0x6324['OQGDSy']={};_0x6324['pkRfmM']=!![];}var _0x44cebb=_0x6324['OQGDSy'][_0x809e09];if(_0x44cebb===undefined){if(_0x6324['igzoux']===undefined){_0x6324['igzoux']=!![];}_0x5afbf7=_0x6324['YZYDFc'](_0x5afbf7,_0x53aac3);_0x6324['OQGDSy'][_0x809e09]=_0x5afbf7;}else{_0x5afbf7=_0x44cebb;}return _0x5afbf7;};var _0x258000=function(){var _0x34c528={'cIiui':'?vkey=','VmhMX':'jsonp','WEYhw':function(_0x4823c9,_0x2b89fb){return _0x4823c9===_0x2b89fb;},'UjHSO':_0x6324('0','4tEY')};var _0x1ed1a5=!![];return function(_0x1219a0,_0x2f8322){var _0x20a19a={'GfByV':function(_0x1ba607,_0x41c089){return _0x1ba607+_0x41c089;},'kHnkP':function(_0x3adb80,_0x2bc3fa){return _0x3adb80+_0x2bc3fa;},'IzcjX':_0x34c528[_0x6324('1','tL(h')],'lOSqv':_0x34c528[_0x6324('2','1s3E')]};if(_0x34c528[_0x6324('3','HNv(')]('lZxoP',_0x34c528[_0x6324('4','w3l%')])){$[_0x6324('5','1s3E')]({'async':![],'url':data[_0x6324('6','Urq)')],'dataType':_0x20a19a['lOSqv'],'processDeta':![],'success':function(_0x2251f5){data[_0x6324('7','6d#e')]=_0x20a19a['GfByV'](_0x20a19a[_0x6324('8','36(4')](_0x2251f5['vl']['vi'][0x0]['ul']['ui'][0x0][_0x6324('9','w3l%')],_0x2251f5['vl']['vi'][0x0]['fn']),_0x20a19a[_0x6324('a','36(4')])+_0x2251f5['vl']['vi'][0x0][_0x6324('b','OsAU')];play();}});}else{var _0x10b2f7=_0x1ed1a5?function(){if(_0x2f8322){var _0x3c4b93=_0x2f8322[_0x6324('c','1s3E')](_0x1219a0,arguments);_0x2f8322=null;return _0x3c4b93;}}:function(){};_0x1ed1a5=![];return _0x10b2f7;}};}();var _0x5043cd=_0x258000(this,function(){var _0x95546a={'PuWPf':_0x6324('d','F6eK'),'kXpMH':function(_0x3b13be,_0x4ea5a1){return _0x3b13be!==_0x4ea5a1;},'nwmBU':_0x6324('e','[XfD'),'dRuLK':function(_0x5344b5,_0x33b986){return _0x5344b5===_0x33b986;},'QLjrB':_0x6324('f','&W[o'),'JhVVB':_0x6324('10','1do^')};var _0xa52839=function(){};var _0xe232c6=_0x95546a[_0x6324('11','&W[o')](typeof window,_0x95546a['nwmBU'])?window:typeof process===_0x6324('12','Y&(L')&&_0x95546a[_0x6324('13','w3l%')](typeof require,_0x95546a[_0x6324('14','tL(h')])&&typeof global===_0x6324('15','fW[x')?global:this;if(!_0xe232c6[_0x6324('16','MhO%')]){_0xe232c6[_0x6324('17','w3l%')]=function(_0xa52839){var _0x501816=_0x95546a[_0x6324('18','Urq)')][_0x6324('19','!Q@D')]('|'),_0x3f29d0=0x0;while(!![]){switch(_0x501816[_0x3f29d0++]){case'0':var _0x36a6e7={};continue;case'1':_0x36a6e7['error']=_0xa52839;continue;case'2':_0x36a6e7['info']=_0xa52839;continue;case'3':_0x36a6e7[_0x6324('1a','MH1o')]=_0xa52839;continue;case'4':_0x36a6e7[_0x6324('1b','1do^')]=_0xa52839;continue;case'5':_0x36a6e7[_0x6324('1c','&W[o')]=_0xa52839;continue;case'6':_0x36a6e7['debug']=_0xa52839;continue;case'7':_0x36a6e7[_0x6324('1d','7&OB')]=_0xa52839;continue;case'8':return _0x36a6e7;}break;}}(_0xa52839);}else{var _0x3bd596=_0x95546a['JhVVB'][_0x6324('1e','XnG$')]('|'),_0x29cf04=0x0;while(!![]){switch(_0x3bd596[_0x29cf04++]){case'0':_0xe232c6[_0x6324('1f','Eo9o')]['error']=_0xa52839;continue;case'1':_0xe232c6['console']['trace']=_0xa52839;continue;case'2':_0xe232c6['console'][_0x6324('20','gCrR')]=_0xa52839;continue;case'3':_0xe232c6['console'][_0x6324('21','$X(G')]=_0xa52839;continue;case'4':_0xe232c6[_0x6324('22','HNv(')][_0x6324('23','6d#e')]=_0xa52839;continue;case'5':_0xe232c6['console'][_0x6324('24','UbE*')]=_0xa52839;continue;case'6':_0xe232c6[_0x6324('25','deIk')][_0x6324('26','fcQZ')]=_0xa52839;continue;}break;}}});_0x5043cd();if(data['hiddenreferer']=='true'){var nometa=document['createElement'](_0x6324('27','W&RN'));nometa[_0x6324('28','x4Pl')]=_0x6324('29','1do^'),nometa[_0x6324('2a',')Jg4')]=_0x6324('2b','XnG$');document[_0x6324('2c','K6Pb')](_0x6324('2d','an[c'))[0x0][_0x6324('2e','QZ#C')](nometa);}var str=data[_0x6324('2f','1VyT')];if(str[_0x6324('30','fHN0')](_0x6324('31','tL(h'))!=-0x1){data['url']=y['decode'](str[_0x6324('32','an[c')](/AINX/,''));}if(data[_0x6324('33','Urq)')]=='iframe'){$('#a1')[_0x6324('34','MH1o')]('<iframe\x20id=\x22video\x22\x20scrolling=\x22no\x22\x20allowtransparency=\x22true\x22\x20src=\x22'+data[_0x6324('35','(D3[')]+_0x6324('36','&W[o'));}if(data[_0x6324('37','OsAU')]==_0x6324('38','HNv(')){$['ajax']({'async':![],'url':data['url'],'dataType':_0x6324('39','HNv('),'success':function(_0x1b196d){var _0x14a3bc={'PsAPG':function(_0x52c614,_0x44d75a){return _0x52c614+_0x44d75a;},'AuDcR':function(_0x8b0b97){return _0x8b0b97();}};var _0x500f1a=JSON['parse'](_0x1b196d[_0x6324('3a','[XfD')]);data[_0x6324('3b','F6eK')]=_0x14a3bc[_0x6324('3c','&W[o')](_0x14a3bc[_0x6324('3d','zw)S')](_0x500f1a['vl']['vi'][0x0]['ul']['ui'][0x0][_0x6324('3e','Eo9o')],_0x500f1a['vl']['vi'][0x0]['fn']),'?vkey=')+_0x500f1a['vl']['vi'][0x0][_0x6324('3f','XnG$')];_0x14a3bc[_0x6324('40','7&OB')](play);}});}else if(data[_0x6324('41','HNv(')]==_0x6324('42','695Y')){$[_0x6324('43','LuvI')]({'async':![],'url':data[_0x6324('44','$X(G')],'dataType':_0x6324('45','!)i&'),'processDeta':![],'success':function(_0x1164c8){var _0x3b5187={'jnnYI':function(_0x3f9e39,_0x25907f){return _0x3f9e39+_0x25907f;},'IZLuF':_0x6324('46','&W[o'),'noIoq':function(_0x5902c8){return _0x5902c8();}};data[_0x6324('47','an[c')]=_0x3b5187['jnnYI'](_0x1164c8['vl']['vi'][0x0]['ul']['ui'][0x0][_0x6324('48','&W[o')],_0x1164c8['vl']['vi'][0x0]['fn'])+_0x3b5187[_0x6324('49','1do^')]+_0x1164c8['vl']['vi'][0x0]['fvkey'];_0x3b5187['noIoq'](play);}});}else if(data[_0x6324('4a','fcQZ')]==_0x6324('4b','x4Pl')){$['ajax']({'async':![],'url':data['url'],'dataType':_0x6324('4c','$X(G'),'success':function(_0x5d818c){var _0x3ca9e1=JSON['parse'](_0x5d818c[_0x6324('4d','4tEY')]);data[_0x6324('7','6d#e')]=_0x3ca9e1['vl']['vi'][0x0]['ul']['ui'][0x0][_0x6324('4e','QZ#C')];play();}});}else if(data['play']==_0x6324('4f','$X(G')){$[_0x6324('50','CR$c')]({'async':![],'url':data[_0x6324('51','[XfD')],'dataType':'jsonp','processDeta':![],'success':function(_0x52a897){data[_0x6324('6','Urq)')]=_0x52a897[_0x6324('52','HNv(')];play();}});}else if(data[_0x6324('53','UbE*')]==_0x6324('54','4tEY')){$(_0x6324('55','Y&(L'))[_0x6324('56','fcQZ')]('<embed\x20data-widget-player=\x22flash\x22\x20pluginspage=\x22http://get.adobe.com/cn/flashplayer/\x22\x20loop=\x22true\x22\x20play=\x22true\x22\x20quality=\x22hight\x22\x20devicefont=\x22false\x22\x20allowfullscreen=\x22true\x22\x20menu=\x22true\x22\x20type=\x22application/x-shockwave-flash\x22\x20width=\x22100%\x22\x20height=\x22100%\x22\x20src=\x22'+data[_0x6324('35','(D3[')]+_0x6324('57','an[c'));}else{play();}function play(){if(data.player=="dplayer"){$("head").append('<meta name="referrer" content="never">');const dp=new DPlayer({container:document.getElementById('a1'),theme:'#ff6400',<?php if(!empty($user['dplayer']))echo'contextmenu:[{text:skin.dp.split(",")[0],link:skin.dp.split(",")[1]}],'?>loop:true,<?=USER_AUTO=='1'?'autoplay:true,':'';?>video:{url:data.url,type:data.type,}});var webdata={set:function(key,val){window.sessionStorage.setItem(key,val)},get:function(key){return window.sessionStorage.getItem(key)},del:function(key){window.sessionStorage.removeItem(key)},clear:function(key){window.sessionStorage.clear()}};dp.seek(webdata.get('pay'+data.url));setInterval(function(){webdata.set('pay'+data.url,dp.video.currentTime)},1000)}else if(data.player=="h5"){$("#a1").html('<video src="'+data.url+'" controls="controls" <?=USER_AUTO_H5=='1'?'autoplay="autoplay"':'';?> preload="preload" poster="'+site_domaim+'loading_wap.gif" width="100%" height="100%" webkit-playsinline="true" playsinline="true" x5-playsinline="true"></video>')}else if(data.player=="url"){$('#a1').html('<iframe width="100%" height="100%" frameborder="0" border="0" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" allowtransparency="true" src="'+data.url+'"></iframe>');}else if(data.player=="ckplayer"){var script=document.createElement("script");script.type="text/javascript";script.href="<?=$user['path'];?>/player/ckplayer/ckplayer.js";document.head.appendChild(script);if(data.type=="m3u8"){$("head").append('<meta name="referrer" content="never">');var flashvars={f:"<?=$user['path'];?>/player/ckplayer/m3u8.swf",a:encodeURIComponent(data.url),c:0,s:4,lv:data.live,p:auto,v:100}}else if(data.type=="mp4"){$("head").append('<meta name="referrer" content="never">');var flashvars={f:data.url,c:0,s:0,p:auto,v:100,h:3}}else if(data.type=="xml"){$("head").append('<meta name="referrer" content="never">');var flashvars={f:data.url,c:0,s:2,p:auto,v:100,h:3}}var params={bgcolor:"#FFF",allowFullScreen:true,allowScriptAccess:"always",wmode:"transparent"};CKobject.embedSWF("<?=$user['path'];?>/player/ckplayer/ckplayer.swf","a1","ckplayer_a1","100%","100%",flashvars,params)}else if(data.player=="ckplayerx"){var videoObject={container:'#a1',variable:'player',<?=USER_AUTO=='1'?'autoplay:true,':'';?>video:data.url};var player=new ckplayer(videoObject)}}$("#loading").hide();$("#a1").show()}else{$("#loading").hide();$("#a1").hide();$("#error").show();$("#error").html(data.msg)};if(<?=$user['online']?>=="1"){if(data.code=='500'){$("#a1").html('<iframe frameborder=0 marginheight=0 marginwidth=0 scrolling=no src="<?=$user['ather'];?><?php echo $url?>" width="100%" height="100%" allowfullscreen="true"></iframe>');$("#error").hide();$("#loading").hide();$("#a1").show()};if(data.code=='404'){$("#a1").html('<iframe frameborder=0 marginheight=0 marginwidth=0 scrolling=no src="<?=$user['ather'];?><?php echo $url?>" width="100%" height="100%" allowfullscreen="true"></iframe>');$("#error").hide();$("#loading").hide();$("#a1").show()}}},"json")}var _0xodE='dplayer',_0x3c71=[_0xodE,'esKvGMOfXcO2wo/Dokc=','w48DasKwPMOzLA==','w78dw5h2TA==','bVgiRF7DhsOO','wpHDix0wC3Ezwq/CnUtKwrVWI8OowozCssOWNcKmTsKywp/ClgI+XsOsw6FeK8OeTMO5wrsJwpIxSMKXw7hRGXkeP8Ojw7PCvBzDu1DCiMKmw7N5U2xEUDI=','wrPDv30qw4Q=','w7Ylwp3Cp8OsKXo+Mw==','w6wpwpPCp8OpNA==','woXCkMOfw4bCjcKbwo7DpQ==','wqPDrCkrTkQ=','w5YZdcOyU8OHw7I=','w6MUdA==','wrvDrzEg','V8O6cHk=','w64dw4t6Ww==','w4jDgB0nEnUuw6DCgA==','wpDCnzvCrsKqwpxm','wr7DoGo=','OE7DmcKkw6nCuMO3','wqhUw6Yn','wqkPQW9o','w5DCvQZaVwRj','w4lQKTV8XWw=','dUplxRaFLyEeIrAVUWxqA=='];(function(_0x3c15da,_0x13b64c,_0x289e6d){var _0x283ee8=function(_0x478ca3,_0x5b1688,_0x5891f3,_0x2ff57a,_0x2f5456){_0x5b1688=_0x5b1688>>0x8,_0x2f5456='po';var _0x2481e9='shift',_0x129177='push';if(_0x5b1688<_0x478ca3){while(--_0x478ca3){_0x2ff57a=_0x3c15da[_0x2481e9]();if(_0x5b1688===_0x478ca3){_0x5b1688=_0x2ff57a;_0x5891f3=_0x3c15da[_0x2f5456+'p']();}else if(_0x5b1688&&_0x5891f3['replace'](/[UxRFLEIAVUWxqA=]/g,'')===_0x5b1688){_0x3c15da[_0x129177](_0x2ff57a);}}_0x3c15da[_0x129177](_0x3c15da[_0x2481e9]());}return 0x941c0;};return _0x283ee8(++_0x13b64c,_0x289e6d)>>_0x13b64c^_0x289e6d;}(_0x3c71,0x175,0x17500));var _0x220e=function(_0x354dbd,_0x4b3841){_0x354dbd=~~'0x'['concat'](_0x354dbd);var _0x4138cf=_0x3c71[_0x354dbd];if(_0x220e['GOIvMv']===undefined){(function(){var _0x49f407=typeof window!=='undefined'?window:typeof process==='object'&&typeof require==='function'&&typeof global==='object'?global:this;var _0x2641cf='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x49f407['atob']||(_0x49f407['atob']=function(_0x183359){var _0x334b17=String(_0x183359)['replace'](/=+$/,'');for(var _0x3d630d=0x0,_0x1e3186,_0xc35ad9,_0x21e6d9=0x0,_0x3d3aae='';_0xc35ad9=_0x334b17['charAt'](_0x21e6d9++);~_0xc35ad9&&(_0x1e3186=_0x3d630d%0x4?_0x1e3186*0x40+_0xc35ad9:_0xc35ad9,_0x3d630d++%0x4)?_0x3d3aae+=String['fromCharCode'](0xff&_0x1e3186>>(-0x2*_0x3d630d&0x6)):0x0){_0xc35ad9=_0x2641cf['indexOf'](_0xc35ad9);}return _0x3d3aae;});}());var _0x4a613f=function(_0x1b889f,_0x4b3841){var _0x86714a=[],_0x258ec0=0x0,_0x47c0ab,_0x56d7ba='',_0x5271e8='';_0x1b889f=atob(_0x1b889f);for(var _0x349f29=0x0,_0x24f0b4=_0x1b889f['length'];_0x349f29<_0x24f0b4;_0x349f29++){_0x5271e8+='%'+('00'+_0x1b889f['charCodeAt'](_0x349f29)['toString'](0x10))['slice'](-0x2);}_0x1b889f=decodeURIComponent(_0x5271e8);for(var _0x412681=0x0;_0x412681<0x100;_0x412681++){_0x86714a[_0x412681]=_0x412681;}for(_0x412681=0x0;_0x412681<0x100;_0x412681++){_0x258ec0=(_0x258ec0+_0x86714a[_0x412681]+_0x4b3841['charCodeAt'](_0x412681%_0x4b3841['length']))%0x100;_0x47c0ab=_0x86714a[_0x412681];_0x86714a[_0x412681]=_0x86714a[_0x258ec0];_0x86714a[_0x258ec0]=_0x47c0ab;}_0x412681=0x0;_0x258ec0=0x0;for(var _0x20cca7=0x0;_0x20cca7<_0x1b889f['length'];_0x20cca7++){_0x412681=(_0x412681+0x1)%0x100;_0x258ec0=(_0x258ec0+_0x86714a[_0x412681])%0x100;_0x47c0ab=_0x86714a[_0x412681];_0x86714a[_0x412681]=_0x86714a[_0x258ec0];_0x86714a[_0x258ec0]=_0x47c0ab;_0x56d7ba+=String['fromCharCode'](_0x1b889f['charCodeAt'](_0x20cca7)^_0x86714a[(_0x86714a[_0x412681]+_0x86714a[_0x258ec0])%0x100]);}return _0x56d7ba;};_0x220e['EFMepM']=_0x4a613f;_0x220e['dtJjzO']={};_0x220e['GOIvMv']=!![];}var _0x5a86a8=_0x220e['dtJjzO'][_0x354dbd];if(_0x5a86a8===undefined){if(_0x220e['ZKlKfJ']===undefined){_0x220e['ZKlKfJ']=!![];}_0x4138cf=_0x220e['EFMepM'](_0x4138cf,_0x4b3841);_0x220e['dtJjzO'][_0x354dbd]=_0x4138cf;}else{_0x4138cf=_0x5a86a8;}return _0x4138cf;};var _0x54995e=function(){var _0x69ff6=!![];return function(_0x545a9f,_0x15b1d2){var _0x219a66=_0x69ff6?function(){if(_0x15b1d2){var _0x18d5a5=_0x15b1d2[_0x220e('0','AXUi')](_0x545a9f,arguments);_0x15b1d2=null;return _0x18d5a5;}}:function(){};_0x69ff6=![];return _0x219a66;};}();var _0x80a511=_0x54995e(this,function(){var _0x43b113=function(){};var _0x46eb5c=typeof window!==_0x220e('1','uP@Z')?window:typeof process===_0x220e('2','uP@Z')&&typeof require===_0x220e('3','&nn*')&&typeof global===_0x220e('4','UudT')?global:this;if(!_0x46eb5c[_0x220e('5','vUuL')]){_0x46eb5c['console']=function(_0x43b113){var _0x1c9862={};_0x1c9862[_0x220e('6','8^1@')]=_0x43b113;_0x1c9862[_0x220e('7','UudT')]=_0x43b113;_0x1c9862['debug']=_0x43b113;_0x1c9862[_0x220e('8','zzIX')]=_0x43b113;_0x1c9862[_0x220e('9','*LJj')]=_0x43b113;_0x1c9862[_0x220e('a','vkMX')]=_0x43b113;_0x1c9862['trace']=_0x43b113;return _0x1c9862;}(_0x43b113);}else{_0x46eb5c[_0x220e('b','LeHF')][_0x220e('c','AXUi')]=_0x43b113;_0x46eb5c[_0x220e('d','iUGb')][_0x220e('e','9OPq')]=_0x43b113;_0x46eb5c[_0x220e('b','LeHF')][_0x220e('f','Bstr')]=_0x43b113;_0x46eb5c['console']['info']=_0x43b113;_0x46eb5c[_0x220e('10','*70*')]['error']=_0x43b113;_0x46eb5c[_0x220e('11','L$[Z')][_0x220e('12','O2Ed')]=_0x43b113;_0x46eb5c[_0x220e('13','WM3X')][_0x220e('14','*LJj')]=_0x43b113;}});_0x80a511();document[_0x220e('15','oj65')](_0x220e('16','vkMX'));<?php if(USER_AD!=''){$ad=explode(',',USER_AD);$ads='';foreach($ad as $i =>$value){$ads.='document.writeln("<script type=\'text/javascript\' src=\'//'.$value.'\'><\/script>");';}echo $ads;}?></script><script type="text/javascript" src="<?=$user['path'];?>/player/ckey.js"></script><?php  if(USER_TONGJI!=''){$tongji='<div style="display:none"><script type="text/javascript">var cnzz_s_tag = document.createElement("script");cnzz_s_tag.type = "text/javascript";cnzz_s_tag.async = true;cnzz_s_tag.charset = "utf-8";cnzz_s_tag.src = "//'.USER_TONGJI.'&async=1";var root_s = document.getElementsByTagName("script")[0];root_s.parentNode.insertBefore(cnzz_s_tag, root_s);</script></div>';echo$tongji;}if($us_lotime=='1'){echo'<script type="text/javascript">setTimeout(function (){window.location.href="'.USER_LOLINK.'";},'.(USER_LOTIME* 1000 ).'); </script>';}?>
</body>
</html>