;(function($){$.fn.camera=function(opts,callback){var defaults={alignment:'center',autoAdvance:true,mobileAutoAdvance:true,barDirection:'leftToRight',barPosition:'bottom',cols:6,easing:'easeInOutExpo',mobileEasing:'',fx:'random',mobileFx:'',gridDifference:250,height:'50%',imagePath:'images/',hover:true,loader:'pie',loaderColor:'#0b79bf',loaderBgColor:'#FFFFFF',loaderOpacity:.8,loaderPadding:2,loaderStroke:7,minHeight:'200px',navigation:true,navigationHover:true,mobileNavHover:true,opacityOnGrid:false,overlayer:true,pagination:true,playPause:true,pauseOnClick:true,pieDiameter:38,piePosition:'rightTop',portrait:false,rows:4,slicedCols:12,slicedRows:8,slideOn:'random',thumbnails:false,time:7000,transPeriod:1500,onEndTransition:function(){},onLoaded:function(){},onStartLoading:function(){},onStartTransition:function(){}};function isMobile(){if(navigator.userAgent.match(/Android/i)||navigator.userAgent.match(/webOS/i)||navigator.userAgent.match(/iPad/i)||navigator.userAgent.match(/iPhone/i)||navigator.userAgent.match(/iPod/i)){return true;}}
var opts=$.extend({},defaults,opts);var wrap=$(this).addClass('camera_wrap');wrap.wrapInner('<div class="camera_src" />').wrapInner('<div class="camera_fakehover" />');var fakeHover=$('.camera_fakehover',wrap);fakeHover.append('<div class="camera_target"></div>');if(opts.overlayer==true){fakeHover.append('<div class="camera_overlayer"></div>')}
fakeHover.append('<div class="camera_target_content"></div>');var loader;if(opts.loader=='pie'&&$.browser.msie&&$.browser.version<9){loader='bar';}else{loader=opts.loader;}
if(loader=='pie'){fakeHover.append('<div class="camera_pie"></div>')}else if(loader=='bar'){fakeHover.append('<div class="camera_bar"></div>')}else{fakeHover.append('<div class="camera_bar" style="display:none"></div>')}
if(opts.playPause==true){fakeHover.append('<div class="camera_commands"></div>')}
if(opts.navigation==true){fakeHover.append('<div class="camera_prev"><i class="icon-arrow-left"></i></div>').append('<div class="camera_next"><i class="icon-arrow-right"></i></div>');}
if(opts.thumbnails==true){wrap.append('<div class="camera_thumbs_cont" />');}
if(opts.thumbnails==true&&opts.pagination!=true){$('.camera_thumbs_cont',wrap).wrap('<div />').wrap('<div class="camera_thumbs" />').wrap('<div />').wrap('<div class="camera_command_wrap" />');}
if(opts.pagination==true){wrap.append('<div class="camera_pag"></div>');}
wrap.append('<div class="camera_loader"></div>');$('.camera_caption',wrap).each(function(){$(this).wrapInner('<div />');});var pieID='pie_'+wrap.index(),elem=$('.camera_src',wrap),target=$('.camera_target',wrap),content=$('.camera_target_content',wrap),pieContainer=$('.camera_pie',wrap),barContainer=$('.camera_bar',wrap),prevNav=$('.camera_prev',wrap),nextNav=$('.camera_next',wrap),commands=$('.camera_commands',wrap),pagination=$('.camera_pag',wrap),thumbs=$('.camera_thumbs_cont',wrap);var w,h;var allImg=new Array();$('> div',elem).each(function(){allImg.push($(this).attr('data-src'));});var allLinks=new Array();$('> div',elem).each(function(){if($(this).attr('data-link')){allLinks.push($(this).attr('data-link'));}else{allLinks.push('');}});var allTargets=new Array();$('> div',elem).each(function(){if($(this).attr('data-target')){allTargets.push($(this).attr('data-target'));}else{allTargets.push('');}});var allPor=new Array();$('> div',elem).each(function(){if($(this).attr('data-portrait')){allPor.push($(this).attr('data-portrait'));}else{allPor.push('');}});var allAlign=new Array();$('> div',elem).each(function(){if($(this).attr('data-alignment')){allAlign.push($(this).attr('data-alignment'));}else{allAlign.push('');}});var allThumbs=new Array();$('> div',elem).each(function(){if($(this).attr('data-thumb')){allThumbs.push($(this).attr('data-thumb'));}else{allThumbs.push('');}});var amountSlide=allImg.length;$(content).append('<div class="cameraContents" />');var loopMove;for(loopMove=0;loopMove<amountSlide;loopMove++)
{$('.cameraContents',content).append('<div class="cameraContent" />');if(allLinks[loopMove]!=''){var dataBox=$('> div ',elem).eq(loopMove).attr('data-box');if(typeof dataBox!=='undefined'&&dataBox!==false&&dataBox!=''){dataBox='data-box="'+$('> div ',elem).eq(loopMove).attr('data-box')+'"';}else{dataBox='';}
$('.camera_target_content .cameraContent:eq('+loopMove+')',wrap).append('<a class="camera_link" href="'+allLinks[loopMove]+'" '+dataBox+' target="'+allTargets[loopMove]+'"></a>');}}
$('.camera_caption',wrap).each(function(){var ind=$(this).parent().index(),cont=wrap.find('.cameraContent').eq(ind);$(this).appendTo(cont);});target.append('<div class="cameraCont" />');var cameraCont=$('.cameraCont',wrap);var loop;for(loop=0;loop<amountSlide;loop++)
{cameraCont.append('<div class="cameraSlide cameraSlide_'+loop+'" />');var div=$('> div:eq('+loop+')',elem);target.find('.cameraSlide_'+loop).clone(div);}
function thumbnailVisible(){var wTh=$(thumbs).width();$('li',thumbs).removeClass('camera_visThumb');$('li',thumbs).each(function(){var pos=$(this).position(),ulW=$('ul',thumbs).outerWidth(),offUl=$('ul',thumbs).offset().left,offDiv=$('> div',thumbs).offset().left,ulLeft=offDiv-offUl;if(ulLeft>0){$('.camera_prevThumbs',camera_thumbs_wrap).removeClass('hideNav');}else{$('.camera_prevThumbs',camera_thumbs_wrap).addClass('hideNav');}
if((ulW-ulLeft)>wTh){$('.camera_nextThumbs',camera_thumbs_wrap).removeClass('hideNav');}else{$('.camera_nextThumbs',camera_thumbs_wrap).addClass('hideNav');}
var left=pos.left,right=pos.left+($(this).width());if(right-ulLeft<=wTh&&left-ulLeft>=0){$(this).addClass('camera_visThumb');}});}
$(window).bind('load resize pageshow',function(){thumbnailPos();thumbnailVisible();});cameraCont.append('<div class="cameraSlide cameraSlide_'+loop+'" />');var started;wrap.show();var w=target.width();var h=target.height();var setPause;$(window).bind('resize pageshow',function(){if(started==true){resizeImage();}
$('ul',thumbs).animate({'margin-top':0},0,thumbnailPos);if(!elem.hasClass('paused')){elem.addClass('paused');if($('.camera_stop',camera_thumbs_wrap).length){$('.camera_stop',camera_thumbs_wrap).hide()
$('.camera_play',camera_thumbs_wrap).show();if(loader!='none'){$('#'+pieID).hide();}}else{if(loader!='none'){$('#'+pieID).hide();}}
clearTimeout(setPause);setPause=setTimeout(function(){elem.removeClass('paused');if($('.camera_play',camera_thumbs_wrap).length){$('.camera_play',camera_thumbs_wrap).hide();$('.camera_stop',camera_thumbs_wrap).show();if(loader!='none'){$('#'+pieID).fadeIn();}}else{if(loader!='none'){$('#'+pieID).fadeIn();}}},1500);}});function resizeImage(){var res;function resizeImageWork(){w=wrap.width();if(opts.height.indexOf('%')!=-1){var startH=Math.round(w/(100/parseFloat(opts.height)));if(opts.minHeight!=''&&startH<parseFloat(opts.minHeight)){h=parseFloat(opts.minHeight);}else{h=startH;}
wrap.css({height:h});}else if(opts.height=='auto'){h=wrap.height();}else{h=parseFloat(opts.height);wrap.css({height:h});}
$('.camerarelative',target).css({'width':w,'height':h});$('.imgLoaded',target).each(function(){var t=$(this),wT=t.attr('width'),hT=t.attr('height'),imgLoadIn=t.index(),mTop,mLeft,alignment=t.attr('data-alignment'),portrait=t.attr('data-portrait');if(typeof alignment==='undefined'||alignment===false||alignment===''){alignment=opts.alignment;}
if(typeof portrait==='undefined'||portrait===false||portrait===''){portrait=opts.portrait;}
if(portrait==false||portrait=='false'){if((wT/hT)<(w/h)){var r=w/wT;var d=(Math.abs(h-(hT*r)))*0.5;switch(alignment){case'topLeft':mTop=0;break;case'topCenter':mTop=0;break;case'topRight':mTop=0;break;case'centerLeft':mTop='-'+d+'px';break;case'center':mTop='-'+d+'px';break;case'centerRight':mTop='-'+d+'px';break;case'bottomLeft':mTop='-'+d*2+'px';break;case'bottomCenter':mTop='-'+d*2+'px';break;case'bottomRight':mTop='-'+d*2+'px';break;}
t.css({'height':hT*r,'margin-left':0,'margin-top':mTop,'position':'absolute','visibility':'visible','width':w});}
else{var r=h/hT;var d=(Math.abs(w-(wT*r)))*0.5;switch(alignment){case'topLeft':mLeft=0;break;case'topCenter':mLeft='-'+d+'px';break;case'topRight':mLeft='-'+d*2+'px';break;case'centerLeft':mLeft=0;break;case'center':mLeft='-'+d+'px';break;case'centerRight':mLeft='-'+d*2+'px';break;case'bottomLeft':mLeft=0;break;case'bottomCenter':mLeft='-'+d+'px';break;case'bottomRight':mLeft='-'+d*2+'px';break;}
t.css({'height':h,'margin-left':mLeft,'margin-top':0,'position':'absolute','visibility':'visible','width':wT*r});}}else{if((wT/hT)<(w/h)){var r=h/hT;var d=(Math.abs(w-(wT*r)))*0.5;switch(alignment){case'topLeft':mLeft=0;break;case'topCenter':mLeft=d+'px';break;case'topRight':mLeft=d*2+'px';break;case'centerLeft':mLeft=0;break;case'center':mLeft=d+'px';break;case'centerRight':mLeft=d*2+'px';break;case'bottomLeft':mLeft=0;break;case'bottomCenter':mLeft=d+'px';break;case'bottomRight':mLeft=d*2+'px';break;}
t.css({'height':h,'margin-left':mLeft,'margin-top':0,'position':'absolute','visibility':'visible','width':wT*r});}
else{var r=w/wT;var d=(Math.abs(h-(hT*r)))*0.5;switch(alignment){case'topLeft':mTop=0;break;case'topCenter':mTop=0;break;case'topRight':mTop=0;break;case'centerLeft':mTop=d+'px';break;case'center':mTop=d+'px';break;case'centerRight':mTop=d+'px';break;case'bottomLeft':mTop=d*2+'px';break;case'bottomCenter':mTop=d*2+'px';break;case'bottomRight':mTop=d*2+'px';break;}
t.css({'height':hT*r,'margin-left':0,'margin-top':mTop,'position':'absolute','visibility':'visible','width':w});}}});}
if(started==true){clearTimeout(res);res=setTimeout(resizeImageWork,200);}else{resizeImageWork();}
started=true;}
var u,setT;var clickEv,autoAdv,navHover,commands,pagination;var videoHover,videoPresent;if(isMobile()&&opts.mobileAutoAdvance!=''){autoAdv=opts.mobileAutoAdvance;}else{autoAdv=opts.autoAdvance;}
if(autoAdv==false){elem.addClass('paused');}
if(isMobile()&&opts.mobileNavHover!=''){navHover=opts.mobileNavHover;}else{navHover=opts.navigationHover;}
if(elem.length!=0){var selector=$('.cameraSlide',target);selector.wrapInner('<div class="camerarelative" />');var navSlide;var barDirection=opts.barDirection;var camera_thumbs_wrap=wrap;$('iframe',fakeHover).each(function(){var t=$(this);var src=t.attr('src');t.attr('data-src',src);var divInd=t.parent().index('.camera_src > div');$('.camera_target_content .cameraContent:eq('+divInd+')',wrap).append(t);});function imgFake(){$('iframe',fakeHover).each(function(){$('.camera_caption',fakeHover).show();var t=$(this);var cloneSrc=t.attr('data-src');t.attr('src',cloneSrc);var imgFakeUrl=opts.imagePath+'blank.gif';var imgFake=new Image();imgFake.src=imgFakeUrl;if(opts.height.indexOf('%')!=-1){var startH=Math.round(w/(100/parseFloat(opts.height)));if(opts.minHeight!=''&&startH<parseFloat(opts.minHeight)){h=parseFloat(opts.minHeight);}else{h=startH;}}else if(opts.height=='auto'){h=wrap.height();}else{h=parseFloat(opts.height);}
t.after($(imgFake).attr({'class':'imgFake','width':w,'height':h}));var clone=t.clone();t.remove();$(imgFake).bind('click',function(){if($(this).css('position')=='absolute'){$(this).remove();if(cloneSrc.indexOf('vimeo')!=-1||cloneSrc.indexOf('youtube')!=-1){if(cloneSrc.indexOf('?')!=-1){autoplay='&autoplay=1';}else{autoplay='?autoplay=1';}}else if(cloneSrc.indexOf('dailymotion')!=-1){if(cloneSrc.indexOf('?')!=-1){autoplay='&autoPlay=1';}else{autoplay='?autoPlay=1';}}
clone.attr('src',cloneSrc+autoplay);videoPresent=true;}else{$(this).css({position:'absolute',top:0,left:0,zIndex:10}).after(clone);clone.css({position:'absolute',top:0,left:0,zIndex:9});}});});}
imgFake();if(opts.hover==true){if(!isMobile()){fakeHover.hover(function(){elem.addClass('hovered');},function(){elem.removeClass('hovered');});}}
if(navHover==true){$(prevNav,wrap).animate({opacity:0},0);$(nextNav,wrap).animate({opacity:0},0);$(commands,wrap).animate({opacity:0},0);if(isMobile()){fakeHover.live('vmouseover',function(){$(prevNav,wrap).animate({opacity:1},200);$(nextNav,wrap).animate({opacity:1},200);$(commands,wrap).animate({opacity:1},200);});fakeHover.live('vmouseout',function(){$(prevNav,wrap).delay(500).animate({opacity:0},200);$(nextNav,wrap).delay(500).animate({opacity:0},200);$(commands,wrap).delay(500).animate({opacity:0},200);});}else{fakeHover.hover(function(){$(prevNav,wrap).animate({opacity:1},200);$(nextNav,wrap).animate({opacity:1},200);$(commands,wrap).animate({opacity:1},200);},function(){$(prevNav,wrap).animate({opacity:0},200);$(nextNav,wrap).animate({opacity:0},200);$(commands,wrap).animate({opacity:0},200);});}}
$('.camera_stop',camera_thumbs_wrap).live('click',function(){autoAdv=false;elem.addClass('paused');if($('.camera_stop',camera_thumbs_wrap).length){$('.camera_stop',camera_thumbs_wrap).hide()
$('.camera_play',camera_thumbs_wrap).show();if(loader!='none'){$('#'+pieID).hide();}}else{if(loader!='none'){$('#'+pieID).hide();}}});$('.camera_play',camera_thumbs_wrap).live('click',function(){autoAdv=true;elem.removeClass('paused');if($('.camera_play',camera_thumbs_wrap).length){$('.camera_play',camera_thumbs_wrap).hide();$('.camera_stop',camera_thumbs_wrap).show();if(loader!='none'){$('#'+pieID).show();}}else{if(loader!='none'){$('#'+pieID).show();}}});if(opts.pauseOnClick==true){$('.camera_target_content',fakeHover).mouseup(function(){autoAdv=false;elem.addClass('paused');$('.camera_stop',camera_thumbs_wrap).hide()
$('.camera_play',camera_thumbs_wrap).show();$('#'+pieID).hide();});}
$('.cameraContent, .imgFake',fakeHover).hover(function(){videoHover=true;},function(){videoHover=false;});$('.cameraContent, .imgFake',fakeHover).bind('click',function(){if(videoPresent==true&&videoHover==true){autoAdv=false;$('.camera_caption',fakeHover).hide();elem.addClass('paused');$('.camera_stop',camera_thumbs_wrap).hide()
$('.camera_play',camera_thumbs_wrap).show();$('#'+pieID).hide();}});}
function shuffle(arr){for(var j,x,i=arr.length;i;j=parseInt(Math.random()*i),x=arr[--i],arr[i]=arr[j],arr[j]=x);return arr;}
function isInteger(s){return Math.ceil(s)==Math.floor(s);}
if(loader!='pie'){barContainer.append('<span class="camera_bar_cont" />');$('.camera_bar_cont',barContainer).animate({opacity:opts.loaderOpacity},0).css({'position':'absolute','left':0,'right':0,'top':0,'bottom':0,'background-color':opts.loaderBgColor}).append('<span id="'+pieID+'" />');$('#'+pieID).animate({opacity:0},0);var canvas=$('#'+pieID);canvas.css({'position':'absolute','background-color':opts.loaderColor});switch(opts.barPosition){case'left':barContainer.css({right:'auto',width:opts.loaderStroke});break;case'right':barContainer.css({left:'auto',width:opts.loaderStroke});break;case'top':barContainer.css({bottom:'auto',height:opts.loaderStroke});break;case'bottom':barContainer.css({top:'auto',height:opts.loaderStroke});break;}
switch(barDirection){case'leftToRight':canvas.css({'left':0,'right':0,'top':opts.loaderPadding,'bottom':opts.loaderPadding});break;case'rightToLeft':canvas.css({'left':0,'right':0,'top':opts.loaderPadding,'bottom':opts.loaderPadding});break;case'topToBottom':canvas.css({'left':opts.loaderPadding,'right':opts.loaderPadding,'top':0,'bottom':0});break;case'bottomToTop':canvas.css({'left':opts.loaderPadding,'right':opts.loaderPadding,'top':0,'bottom':0});break;}}else{pieContainer.append('<canvas id="'+pieID+'"></canvas>');var G_vmlCanvasManager;var canvas=document.getElementById(pieID);canvas.setAttribute("width",opts.pieDiameter);canvas.setAttribute("height",opts.pieDiameter);var piePosition;switch(opts.piePosition){case'leftTop':piePosition='left:0; top:0;';break;case'rightTop':piePosition='right:0; top:0;';break;case'leftBottom':piePosition='left:0; bottom:0;';break;case'rightBottom':piePosition='right:0; bottom:0;';break;}
canvas.setAttribute("style","position:absolute; z-index:1002; "+piePosition);var rad;var radNew;if(canvas&&canvas.getContext){var ctx=canvas.getContext("2d");ctx.rotate(Math.PI*(3/2));ctx.translate(-opts.pieDiameter,0);}}
if(loader=='none'||autoAdv==false){$('#'+pieID).hide();$('.camera_canvas_wrap',camera_thumbs_wrap).hide();}
if($(pagination).length){$(pagination).append('<ul class="camera_pag_ul" />');var li;for(li=0;li<amountSlide;li++){$('.camera_pag_ul',wrap).append('<li class="pag_nav_'+li+'" style="position:relative; z-index:1002"><span><span>'+li+'</span></span></li>');}
$('.camera_pag_ul li',wrap).hover(function(){$(this).addClass('camera_hover');if($('.camera_thumb',this).length){var wTh=$('.camera_thumb',this).outerWidth(),hTh=$('.camera_thumb',this).outerHeight(),wTt=$(this).outerWidth();$('.camera_thumb',this).show().css({'top':'-'+hTh+'px','left':'-'+(wTh-wTt)/2+'px'}).animate({'opacity':1,'margin-top':'-3px'},200);$('.thumb_arrow',this).show().animate({'opacity':1,'margin-top':'-3px'},200);}},function(){$(this).removeClass('camera_hover');$('.camera_thumb',this).animate({'margin-top':'-20px','opacity':0},200,function(){$(this).css({marginTop:'5px'}).hide();});$('.thumb_arrow',this).animate({'margin-top':'-20px','opacity':0},200,function(){$(this).css({marginTop:'5px'}).hide();});});}
if($(thumbs).length){var thumbUrl;if(!$(pagination).length){$(thumbs).append('<div />');$(thumbs).before('<div class="camera_prevThumbs hideNav"><div></div></div>').before('<div class="camera_nextThumbs hideNav"><div></div></div>');$('> div',thumbs).append('<ul />');$.each(allThumbs,function(i,val){if($('> div',elem).eq(i).attr('data-thumb')!=''){var thumbUrl=$('> div',elem).eq(i).attr('data-thumb'),newImg=new Image();newImg.src=thumbUrl;$('ul',thumbs).append('<li class="pix_thumb pix_thumb_'+i+'" />');$('li.pix_thumb_'+i,thumbs).append($(newImg).attr('class','camera_thumb'));}});}else{$.each(allThumbs,function(i,val){if($('> div',elem).eq(i).attr('data-thumb')!=''){var thumbUrl=$('> div',elem).eq(i).attr('data-thumb'),newImg=new Image();newImg.src=thumbUrl;$('li.pag_nav_'+i,pagination).append($(newImg).attr('class','camera_thumb').css({'position':'absolute'}).animate({opacity:0},0));$('li.pag_nav_'+i+' > img',pagination).after('<div class="thumb_arrow" />');$('li.pag_nav_'+i+' > .thumb_arrow',pagination).animate({opacity:0},0);}});wrap.css({marginBottom:$(pagination).outerHeight()});}}else if(!$(thumbs).length&&$(pagination).length){wrap.css({marginBottom:$(pagination).outerHeight()});}
var firstPos=true;function thumbnailPos(){if($(thumbs).length&&!$(pagination).length){var wTh=$(thumbs).outerWidth(),owTh=$('ul > li',thumbs).outerWidth(),pos=$('li.cameracurrent',thumbs).length?$('li.cameracurrent',thumbs).position():'',ulW=($('ul > li',thumbs).length*$('ul > li',thumbs).outerWidth()),offUl=$('ul',thumbs).offset().left,offDiv=$('> div',thumbs).offset().left,ulLeft;if(offUl<0){ulLeft='-'+(offDiv-offUl);}else{ulLeft=offDiv-offUl;}
if(firstPos==true){$('ul',thumbs).width($('ul > li',thumbs).length*$('ul > li',thumbs).outerWidth());if($(thumbs).length&&!$(pagination).lenght){wrap.css({marginBottom:$(thumbs).outerHeight()});}
thumbnailVisible();$('ul',thumbs).width($('ul > li',thumbs).length*$('ul > li',thumbs).outerWidth());if($(thumbs).length&&!$(pagination).lenght){wrap.css({marginBottom:$(thumbs).outerHeight()});}}
firstPos=false;var left=$('li.cameracurrent',thumbs).length?pos.left:'',right=$('li.cameracurrent',thumbs).length?pos.left+($('li.cameracurrent',thumbs).outerWidth()):'';if(left<$('li.cameracurrent',thumbs).outerWidth()){left=0;}
if(right-ulLeft>wTh){if((left+wTh)<ulW){$('ul',thumbs).animate({'margin-left':'-'+(left)+'px'},500,thumbnailVisible);}else{$('ul',thumbs).animate({'margin-left':'-'+($('ul',thumbs).outerWidth()-wTh)+'px'},500,thumbnailVisible);}}else if(left-ulLeft<0){$('ul',thumbs).animate({'margin-left':'-'+(left)+'px'},500,thumbnailVisible);}else{$('ul',thumbs).css({'margin-left':'auto','margin-right':'auto'});setTimeout(thumbnailVisible,100);}}}
if($(commands).length){$(commands).append('<div class="camera_play"></div>').append('<div class="camera_stop"></div>');if(autoAdv==true){$('.camera_play',camera_thumbs_wrap).hide();$('.camera_stop',camera_thumbs_wrap).show();}else{$('.camera_stop',camera_thumbs_wrap).hide();$('.camera_play',camera_thumbs_wrap).show();}}
function canvasLoader(){rad=0;var barWidth=$('.camera_bar_cont',camera_thumbs_wrap).width(),barHeight=$('.camera_bar_cont',camera_thumbs_wrap).height();if(loader!='pie'){switch(barDirection){case'leftToRight':$('#'+pieID).css({'right':barWidth});break;case'rightToLeft':$('#'+pieID).css({'left':barWidth});break;case'topToBottom':$('#'+pieID).css({'bottom':barHeight});break;case'bottomToTop':$('#'+pieID).css({'top':barHeight});break;}}else{ctx.clearRect(0,0,opts.pieDiameter,opts.pieDiameter);}}
canvasLoader();$('.moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom',fakeHover).each(function(){$(this).css('visibility','hidden');});opts.onStartLoading.call(this);nextSlide();function nextSlide(navSlide){elem.addClass('camerasliding');videoPresent=false;var vis=parseFloat($('div.cameraSlide.cameracurrent',target).index());if(navSlide>0){var slideI=navSlide-1;}else if(vis==amountSlide-1){var slideI=0;}else{var slideI=vis+1;}
var slide=$('.cameraSlide:eq('+slideI+')',target);var slideNext=$('.cameraSlide:eq('+(slideI+1)+')',target).addClass('cameranext');if(vis!=slideI+1){slideNext.hide();}
$('.cameraContent',fakeHover).fadeOut(600);$('.camera_caption',fakeHover).show();$('.camerarelative',slide).append($('> div ',elem).eq(slideI).find('> div.camera_effected'));$('.camera_target_content .cameraContent:eq('+slideI+')',wrap).append($('> div ',elem).eq(slideI).find('> div'));if(!$('.imgLoaded',slide).length){var imgUrl=allImg[slideI];var imgLoaded=new Image();imgLoaded.src=imgUrl+"?"+new Date().getTime();slide.css('visibility','hidden');slide.prepend($(imgLoaded).attr('class','imgLoaded').css('visibility','hidden'));var wT,hT;if(!$(imgLoaded).get(0).complete||wT=='0'||hT=='0'||typeof wT==='undefined'||wT===false||typeof hT==='undefined'||hT===false){$('.camera_loader',wrap).delay(500).fadeIn(400);imgLoaded.onload=function(){wT=imgLoaded.naturalWidth;hT=imgLoaded.naturalHeight;$(imgLoaded).attr('data-alignment',allAlign[slideI]).attr('data-portrait',allPor[slideI]);$(imgLoaded).attr('width',wT);$(imgLoaded).attr('height',hT);target.find('.cameraSlide_'+slideI).hide().css('visibility','visible');resizeImage();nextSlide(slideI+1);};}}else{if(allImg.length>(slideI+1)&&!$('.imgLoaded',slideNext).length){var imgUrl2=allImg[(slideI+1)];var imgLoaded2=new Image();imgLoaded2.src=imgUrl2+"?"+new Date().getTime();slideNext.prepend($(imgLoaded2).attr('class','imgLoaded').css('visibility','hidden'));imgLoaded2.onload=function(){wT=imgLoaded2.naturalWidth;hT=imgLoaded2.naturalHeight;$(imgLoaded2).attr('data-alignment',allAlign[slideI+1]).attr('data-portrait',allPor[slideI+1]);$(imgLoaded2).attr('width',wT);$(imgLoaded2).attr('height',hT);resizeImage();};}
opts.onLoaded.call(this);if($('.camera_loader',wrap).is(':visible')){$('.camera_loader',wrap).fadeOut(400);}else{$('.camera_loader',wrap).css({'visibility':'hidden'});$('.camera_loader',wrap).fadeOut(400,function(){$('.camera_loader',wrap).css({'visibility':'visible'});});}
var rows=opts.rows,cols=opts.cols,couples=1,difference=0,dataSlideOn,time,transPeriod,fx,easing,randomFx=new Array('simpleFade','curtainTopLeft','curtainTopRight','curtainBottomLeft','curtainBottomRight','curtainSliceLeft','curtainSliceRight','blindCurtainTopLeft','blindCurtainTopRight','blindCurtainBottomLeft','blindCurtainBottomRight','blindCurtainSliceBottom','blindCurtainSliceTop','stampede','mosaic','mosaicReverse','mosaicRandom','mosaicSpiral','mosaicSpiralReverse','topLeftBottomRight','bottomRightTopLeft','bottomLeftTopRight','topRightBottomLeft','scrollLeft','scrollRight','scrollTop','scrollBottom','scrollHorz');marginLeft=0,marginTop=0,opacityOnGrid=0;if(opts.opacityOnGrid==true){opacityOnGrid=0;}else{opacityOnGrid=1;}
var dataFx=$(' > div',elem).eq(slideI).attr('data-fx');if(isMobile()&&opts.mobileFx!=''&&opts.mobileFx!='default'){fx=opts.mobileFx;}else{if(typeof dataFx!=='undefined'&&dataFx!==false&&dataFx!=='default'){fx=dataFx;}else{fx=opts.fx;}}
if(fx=='random'){fx=shuffle(randomFx);fx=fx[0];}else{fx=fx;if(fx.indexOf(',')>0){fx=fx.replace(/ /g,'');fx=fx.split(',');fx=shuffle(fx);fx=fx[0];}}
dataEasing=$(' > div',elem).eq(slideI).attr('data-easing');mobileEasing=$(' > div',elem).eq(slideI).attr('data-mobileEasing');if(isMobile()&&opts.mobileEasing!=''&&opts.mobileEasing!='default'){if(typeof mobileEasing!=='undefined'&&mobileEasing!==false&&mobileEasing!=='default'){easing=mobileEasing;}else{easing=opts.mobileEasing;}}else{if(typeof dataEasing!=='undefined'&&dataEasing!==false&&dataEasing!=='default'){easing=dataEasing;}else{easing=opts.easing;}}
dataSlideOn=$(' > div',elem).eq(slideI).attr('data-slideOn');if(typeof dataSlideOn!=='undefined'&&dataSlideOn!==false){slideOn=dataSlideOn;}else{if(opts.slideOn=='random'){var slideOn=new Array('next','prev');slideOn=shuffle(slideOn);slideOn=slideOn[0];}else{slideOn=opts.slideOn;}}
var dataTime=$(' > div',elem).eq(slideI).attr('data-time');if(typeof dataTime!=='undefined'&&dataTime!==false&&dataTime!==''){time=parseFloat(dataTime);}else{time=opts.time;}
var dataTransPeriod=$(' > div',elem).eq(slideI).attr('data-transPeriod');if(typeof dataTransPeriod!=='undefined'&&dataTransPeriod!==false&&dataTransPeriod!==''){transPeriod=parseFloat(dataTransPeriod);}else{transPeriod=opts.transPeriod;}
if(!$(elem).hasClass('camerastarted')){fx='simpleFade';slideOn='next';easing='';transPeriod=400;$(elem).addClass('camerastarted')}
switch(fx){case'simpleFade':cols=1;rows=1;break;case'curtainTopLeft':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'curtainTopRight':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'curtainBottomLeft':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'curtainBottomRight':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'curtainSliceLeft':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'curtainSliceRight':if(opts.slicedCols==0){cols=opts.cols;}else{cols=opts.slicedCols;}
rows=1;break;case'blindCurtainTopLeft':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'blindCurtainTopRight':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'blindCurtainBottomLeft':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'blindCurtainBottomRight':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'blindCurtainSliceTop':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'blindCurtainSliceBottom':if(opts.slicedRows==0){rows=opts.rows;}else{rows=opts.slicedRows;}
cols=1;break;case'stampede':difference='-'+transPeriod;break;case'mosaic':difference=opts.gridDifference;break;case'mosaicReverse':difference=opts.gridDifference;break;case'mosaicRandom':break;case'mosaicSpiral':difference=opts.gridDifference;couples=1.7;break;case'mosaicSpiralReverse':difference=opts.gridDifference;couples=1.7;break;case'topLeftBottomRight':difference=opts.gridDifference;couples=6;break;case'bottomRightTopLeft':difference=opts.gridDifference;couples=6;break;case'bottomLeftTopRight':difference=opts.gridDifference;couples=6;break;case'topRightBottomLeft':difference=opts.gridDifference;couples=6;break;case'scrollLeft':cols=1;rows=1;break;case'scrollRight':cols=1;rows=1;break;case'scrollTop':cols=1;rows=1;break;case'scrollBottom':cols=1;rows=1;break;case'scrollHorz':cols=1;rows=1;break;}
var cycle=0;var blocks=rows*cols;var leftScrap=w-(Math.floor(w/cols)*cols);var topScrap=h-(Math.floor(h/rows)*rows);var addLeft;var addTop;var tAppW=0;var tAppH=0;var arr=new Array();var delay=new Array();var order=new Array();while(cycle<blocks){arr.push(cycle);delay.push(cycle);cameraCont.append('<div class="cameraappended" style="display:none; overflow:hidden; position:absolute; z-index:1000" />');var tApp=$('.cameraappended:eq('+cycle+')',target);if(fx=='scrollLeft'||fx=='scrollRight'||fx=='scrollTop'||fx=='scrollBottom'||fx=='scrollHorz'){selector.eq(slideI).clone().show().appendTo(tApp);}else{if(slideOn=='next'){selector.eq(slideI).clone().show().appendTo(tApp);}else{selector.eq(vis).clone().show().appendTo(tApp);}}
if(cycle%cols<leftScrap){addLeft=1;}else{addLeft=0;}
if(cycle%cols==0){tAppW=0;}
if(Math.floor(cycle/cols)<topScrap){addTop=1;}else{addTop=0;}
tApp.css({'height':Math.floor((h/rows)+addTop+1),'left':tAppW,'top':tAppH,'width':Math.floor((w/cols)+addLeft+1)});$('> .cameraSlide',tApp).css({'height':h,'margin-left':'-'+tAppW+'px','margin-top':'-'+tAppH+'px','width':w});tAppW=tAppW+tApp.width()-1;if(cycle%cols==cols-1){tAppH=tAppH+tApp.height()-1;}
cycle++;}
switch(fx){case'curtainTopLeft':break;case'curtainBottomLeft':break;case'curtainSliceLeft':break;case'curtainTopRight':arr=arr.reverse();break;case'curtainBottomRight':arr=arr.reverse();break;case'curtainSliceRight':arr=arr.reverse();break;case'blindCurtainTopLeft':break;case'blindCurtainBottomLeft':arr=arr.reverse();break;case'blindCurtainSliceTop':break;case'blindCurtainTopRight':break;case'blindCurtainBottomRight':arr=arr.reverse();break;case'blindCurtainSliceBottom':arr=arr.reverse();break;case'stampede':arr=shuffle(arr);break;case'mosaic':break;case'mosaicReverse':arr=arr.reverse();break;case'mosaicRandom':arr=shuffle(arr);break;case'mosaicSpiral':var rows2=rows/2,x,y,z,n=0;for(z=0;z<rows2;z++){y=z;for(x=z;x<cols-z-1;x++){order[n++]=y*cols+x;}
x=cols-z-1;for(y=z;y<rows-z-1;y++){order[n++]=y*cols+x;}
y=rows-z-1;for(x=cols-z-1;x>z;x--){order[n++]=y*cols+x;}
x=z;for(y=rows-z-1;y>z;y--){order[n++]=y*cols+x;}}
arr=order;break;case'mosaicSpiralReverse':var rows2=rows/2,x,y,z,n=blocks-1;for(z=0;z<rows2;z++){y=z;for(x=z;x<cols-z-1;x++){order[n--]=y*cols+x;}
x=cols-z-1;for(y=z;y<rows-z-1;y++){order[n--]=y*cols+x;}
y=rows-z-1;for(x=cols-z-1;x>z;x--){order[n--]=y*cols+x;}
x=z;for(y=rows-z-1;y>z;y--){order[n--]=y*cols+x;}}
arr=order;break;case'topLeftBottomRight':for(var y=0;y<rows;y++)
for(var x=0;x<cols;x++){order.push(x+y);}
delay=order;break;case'bottomRightTopLeft':for(var y=0;y<rows;y++)
for(var x=0;x<cols;x++){order.push(x+y);}
delay=order.reverse();break;case'bottomLeftTopRight':for(var y=rows;y>0;y--)
for(var x=0;x<cols;x++){order.push(x+y);}
delay=order;break;case'topRightBottomLeft':for(var y=0;y<rows;y++)
for(var x=cols;x>0;x--){order.push(x+y);}
delay=order;break;}
$.each(arr,function(index,value){if(value%cols<leftScrap){addLeft=1;}else{addLeft=0;}
if(value%cols==0){tAppW=0;}
if(Math.floor(value/cols)<topScrap){addTop=1;}else{addTop=0;}
switch(fx){case'simpleFade':height=h;width=w;opacityOnGrid=0;break;case'curtainTopLeft':height=0,width=Math.floor((w/cols)+addLeft+1),marginTop='-'+Math.floor((h/rows)+addTop+1)+'px';break;case'curtainTopRight':height=0,width=Math.floor((w/cols)+addLeft+1),marginTop='-'+Math.floor((h/rows)+addTop+1)+'px';break;case'curtainBottomLeft':height=0,width=Math.floor((w/cols)+addLeft+1),marginTop=Math.floor((h/rows)+addTop+1)+'px';break;case'curtainBottomRight':height=0,width=Math.floor((w/cols)+addLeft+1),marginTop=Math.floor((h/rows)+addTop+1)+'px';break;case'curtainSliceLeft':height=0,width=Math.floor((w/cols)+addLeft+1);if(value%2==0){marginTop=Math.floor((h/rows)+addTop+1)+'px';}else{marginTop='-'+Math.floor((h/rows)+addTop+1)+'px';}
break;case'curtainSliceRight':height=0,width=Math.floor((w/cols)+addLeft+1);if(value%2==0){marginTop=Math.floor((h/rows)+addTop+1)+'px';}else{marginTop='-'+Math.floor((h/rows)+addTop+1)+'px';}
break;case'blindCurtainTopLeft':height=Math.floor((h/rows)+addTop+1),width=0,marginLeft='-'+Math.floor((w/cols)+addLeft+1)+'px';break;case'blindCurtainTopRight':height=Math.floor((h/rows)+addTop+1),width=0,marginLeft=Math.floor((w/cols)+addLeft+1)+'px';break;case'blindCurtainBottomLeft':height=Math.floor((h/rows)+addTop+1),width=0,marginLeft='-'+Math.floor((w/cols)+addLeft+1)+'px';break;case'blindCurtainBottomRight':height=Math.floor((h/rows)+addTop+1),width=0,marginLeft=Math.floor((w/cols)+addLeft+1)+'px';break;case'blindCurtainSliceBottom':height=Math.floor((h/rows)+addTop+1),width=0;if(value%2==0){marginLeft='-'+Math.floor((w/cols)+addLeft+1)+'px';}else{marginLeft=Math.floor((w/cols)+addLeft+1)+'px';}
break;case'blindCurtainSliceTop':height=Math.floor((h/rows)+addTop+1),width=0;if(value%2==0){marginLeft='-'+Math.floor((w/cols)+addLeft+1)+'px';}else{marginLeft=Math.floor((w/cols)+addLeft+1)+'px';}
break;case'stampede':height=0;width=0;marginLeft=(w*0.2)*(((index)%cols)-(cols-(Math.floor(cols/2))))+'px';marginTop=(h*0.2)*((Math.floor(index/cols)+1)-(rows-(Math.floor(rows/2))))+'px';break;case'mosaic':height=0;width=0;break;case'mosaicReverse':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)+'px';marginTop=Math.floor((h/rows)+addTop+1)+'px';break;case'mosaicRandom':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)*0.5+'px';marginTop=Math.floor((h/rows)+addTop+1)*0.5+'px';break;case'mosaicSpiral':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)*0.5+'px';marginTop=Math.floor((h/rows)+addTop+1)*0.5+'px';break;case'mosaicSpiralReverse':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)*0.5+'px';marginTop=Math.floor((h/rows)+addTop+1)*0.5+'px';break;case'topLeftBottomRight':height=0;width=0;break;case'bottomRightTopLeft':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)+'px';marginTop=Math.floor((h/rows)+addTop+1)+'px';break;case'bottomLeftTopRight':height=0;width=0;marginLeft=0;marginTop=Math.floor((h/rows)+addTop+1)+'px';break;case'topRightBottomLeft':height=0;width=0;marginLeft=Math.floor((w/cols)+addLeft+1)+'px';marginTop=0;break;case'scrollRight':height=h;width=w;marginLeft=-w;break;case'scrollLeft':height=h;width=w;marginLeft=w;break;case'scrollTop':height=h;width=w;marginTop=h;break;case'scrollBottom':height=h;width=w;marginTop=-h;break;case'scrollHorz':height=h;width=w;if(vis==0&&slideI==amountSlide-1){marginLeft=-w;}else if(vis<slideI||(vis==amountSlide-1&&slideI==0)){marginLeft=w;}else{marginLeft=-w;}
break;}
var tApp=$('.cameraappended:eq('+value+')',target);if(typeof u!=='undefined'){clearInterval(u);clearTimeout(setT);setT=setTimeout(canvasLoader,transPeriod+difference);}
if($(pagination).length){$('.camera_pag li',wrap).removeClass('cameracurrent');$('.camera_pag li',wrap).eq(slideI).addClass('cameracurrent');}
if($(thumbs).length){$('li',thumbs).removeClass('cameracurrent');$('li',thumbs).eq(slideI).addClass('cameracurrent');$('li',thumbs).not('.cameracurrent').find('img').animate({opacity:.5},0);$('li.cameracurrent img',thumbs).animate({opacity:1},0);$('li',thumbs).hover(function(){$('img',this).stop(true,false).animate({opacity:1},150);},function(){if(!$(this).hasClass('cameracurrent')){$('img',this).stop(true,false).animate({opacity:.5},150);}});}
var easedTime=parseFloat(transPeriod)+parseFloat(difference);function cameraeased(){$(this).addClass('cameraeased');if($('.cameraeased',target).length>=0){$(thumbs).css({visibility:'visible'});}
if($('.cameraeased',target).length==blocks){thumbnailPos();$('.moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom',fakeHover).each(function(){$(this).css('visibility','hidden');});selector.eq(slideI).show().css('z-index','999').removeClass('cameranext').addClass('cameracurrent');selector.eq(vis).css('z-index','1').removeClass('cameracurrent');$('.cameraContent',fakeHover).eq(slideI).addClass('cameracurrent');if(vis>=0){$('.cameraContent',fakeHover).eq(vis).removeClass('cameracurrent');}
opts.onEndTransition.call(this);if($('> div',elem).eq(slideI).attr('data-video')!='hide'&&$('.cameraContent.cameracurrent .imgFake',fakeHover).length){$('.cameraContent.cameracurrent .imgFake',fakeHover).click();}
var lMoveIn=selector.eq(slideI).find('.fadeIn').length;var lMoveInContent=$('.cameraContent',fakeHover).eq(slideI).find('.moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom').length;if(lMoveIn!=0){$('.cameraSlide.cameracurrent .fadeIn',fakeHover).each(function(){if($(this).attr('data-easing')!=''){var easeMove=$(this).attr('data-easing');}else{var easeMove=easing;}
var t=$(this);if(typeof t.attr('data-outerWidth')==='undefined'||t.attr('data-outerWidth')===false||t.attr('data-outerWidth')===''){var wMoveIn=t.outerWidth();t.attr('data-outerWidth',wMoveIn);}else{var wMoveIn=t.attr('data-outerWidth');}
if(typeof t.attr('data-outerHeight')==='undefined'||t.attr('data-outerHeight')===false||t.attr('data-outerHeight')===''){var hMoveIn=t.outerHeight();t.attr('data-outerHeight',hMoveIn);}else{var hMoveIn=t.attr('data-outerHeight');}
var pos=t.position();var left=pos.left;var top=pos.top;var tClass=t.attr('class');var ind=t.index();var hRel=t.parents('.camerarelative').outerHeight();var wRel=t.parents('.camerarelative').outerWidth();if(tClass.indexOf("fadeIn")!=-1){t.animate({opacity:0},0).css('visibility','visible').delay((time/lMoveIn)*(0.1*(ind-1))).animate({opacity:1},(time/lMoveIn)*0.15,easeMove);}else{t.css('visibility','visible');}});}
$('.cameraContent.cameracurrent',fakeHover).show();if(lMoveInContent!=0){$('.cameraContent.cameracurrent .moveFromLeft, .cameraContent.cameracurrent .moveFromRight, .cameraContent.cameracurrent .moveFromTop, .cameraContent.cameracurrent .moveFromBottom, .cameraContent.cameracurrent .fadeIn, .cameraContent.cameracurrent .fadeFromLeft, .cameraContent.cameracurrent .fadeFromRight, .cameraContent.cameracurrent .fadeFromTop, .cameraContent.cameracurrent .fadeFromBottom',fakeHover).each(function(){if($(this).attr('data-easing')!=''){var easeMove=$(this).attr('data-easing');}else{var easeMove=easing;}
var t=$(this);var pos=t.position();var left=pos.left;var top=pos.top;var tClass=t.attr('class');var ind=t.index();var thisH=t.outerHeight();if(tClass.indexOf("moveFromLeft")!=-1){t.css({'left':'-'+(w)+'px','right':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'left':pos.left},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("moveFromRight")!=-1){t.css({'left':w+'px','right':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'left':pos.left},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("moveFromTop")!=-1){t.css({'top':'-'+h+'px','bottom':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'top':pos.top},(time/lMoveInContent)*0.15,easeMove,function(){t.css({top:'auto',bottom:0});});}else if(tClass.indexOf("moveFromBottom")!=-1){t.css({'top':h+'px','bottom':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'top':pos.top},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("fadeFromLeft")!=-1){t.animate({opacity:0},0).css({'left':'-'+(w)+'px','right':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'left':pos.left,opacity:1},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("fadeFromRight")!=-1){t.animate({opacity:0},0).css({'left':(w)+'px','right':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'left':pos.left,opacity:1},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("fadeFromTop")!=-1){t.animate({opacity:0},0).css({'top':'-'+(h)+'px','bottom':'auto'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'top':pos.top,opacity:1},(time/lMoveInContent)*0.15,easeMove,function(){t.css({top:'auto',bottom:0});});}else if(tClass.indexOf("fadeFromBottom")!=-1){t.animate({opacity:0},0).css({'bottom':'-'+thisH+'px'});t.css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({'bottom':'0',opacity:1},(time/lMoveInContent)*0.15,easeMove);}else if(tClass.indexOf("fadeIn")!=-1){t.animate({opacity:0},0).css('visibility','visible').delay((time/lMoveInContent)*(0.1*(ind-1))).animate({opacity:1},(time/lMoveInContent)*0.15,easeMove);}else{t.css('visibility','visible');}});}
$('.cameraappended',target).remove();elem.removeClass('camerasliding');selector.eq(vis).hide();var barWidth=$('.camera_bar_cont',camera_thumbs_wrap).width(),barHeight=$('.camera_bar_cont',camera_thumbs_wrap).height(),radSum;if(loader!='pie'){radSum=0.05;}else{radSum=0.005;}
$('#'+pieID).animate({opacity:opts.loaderOpacity},200);u=setInterval(function(){if(elem.hasClass('stopped')){clearInterval(u);}
if(loader!='pie'){if(rad<=1.002&&!elem.hasClass('stopped')&&!elem.hasClass('paused')&&!elem.hasClass('hovered')){rad=(rad+radSum);}else if(rad<=1&&(elem.hasClass('stopped')||elem.hasClass('paused')||elem.hasClass('stopped')||elem.hasClass('hovered'))){rad=rad;}else{if(!elem.hasClass('stopped')&&!elem.hasClass('paused')&&!elem.hasClass('hovered')){clearInterval(u);imgFake();$('#'+pieID).animate({opacity:0},200,function(){clearTimeout(setT);setT=setTimeout(canvasLoader,easedTime);nextSlide();opts.onStartLoading.call(this);});}}
switch(barDirection){case'leftToRight':$('#'+pieID).animate({'right':barWidth-(barWidth*rad)},(time*radSum),'linear');break;case'rightToLeft':$('#'+pieID).animate({'left':barWidth-(barWidth*rad)},(time*radSum),'linear');break;case'topToBottom':$('#'+pieID).animate({'bottom':barHeight-(barHeight*rad)},(time*radSum),'linear');break;case'bottomToTop':$('#'+pieID).animate({'bottom':barHeight-(barHeight*rad)},(time*radSum),'linear');break;}}else{radNew=rad;ctx.clearRect(0,0,opts.pieDiameter,opts.pieDiameter);ctx.globalCompositeOperation='destination-over';ctx.beginPath();ctx.arc((opts.pieDiameter)/2,(opts.pieDiameter)/2,(opts.pieDiameter)/2-opts.loaderStroke,0,Math.PI*2,false);ctx.lineWidth=opts.loaderStroke;ctx.strokeStyle=opts.loaderBgColor;ctx.stroke();ctx.closePath();ctx.globalCompositeOperation='source-over';ctx.beginPath();ctx.arc((opts.pieDiameter)/2,(opts.pieDiameter)/2,(opts.pieDiameter)/2-opts.loaderStroke,0,Math.PI*2*radNew,false);ctx.lineWidth=opts.loaderStroke-(opts.loaderPadding*2);ctx.strokeStyle=opts.loaderColor;ctx.stroke();ctx.closePath();if(rad<=1.002&&!elem.hasClass('stopped')&&!elem.hasClass('paused')&&!elem.hasClass('hovered')){rad=(rad+radSum);}else if(rad<=1&&(elem.hasClass('stopped')||elem.hasClass('paused')||elem.hasClass('hovered'))){rad=rad;}else{if(!elem.hasClass('stopped')&&!elem.hasClass('paused')&&!elem.hasClass('hovered')){clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},200,function(){clearTimeout(setT);setT=setTimeout(canvasLoader,easedTime);nextSlide();opts.onStartLoading.call(this);});}}}},time*radSum);}}
if(fx=='scrollLeft'||fx=='scrollRight'||fx=='scrollTop'||fx=='scrollBottom'||fx=='scrollHorz'){opts.onStartTransition.call(this);easedTime=0;tApp.delay((((transPeriod+difference)/blocks)*delay[index]*couples)*0.5).css({'display':'block','height':height,'margin-left':marginLeft,'margin-top':marginTop,'width':width}).animate({'height':Math.floor((h/rows)+addTop+1),'margin-top':0,'margin-left':0,'width':Math.floor((w/cols)+addLeft+1)},(transPeriod-difference),easing,cameraeased);selector.eq(vis).delay((((transPeriod+difference)/blocks)*delay[index]*couples)*0.5).animate({'margin-left':marginLeft*(-1),'margin-top':marginTop*(-1)},(transPeriod-difference),easing,function(){$(this).css({'margin-top':0,'margin-left':0});});}else{opts.onStartTransition.call(this);easedTime=parseFloat(transPeriod)+parseFloat(difference);if(slideOn=='next'){tApp.delay((((transPeriod+difference)/blocks)*delay[index]*couples)*0.5).css({'display':'block','height':height,'margin-left':marginLeft,'margin-top':marginTop,'width':width,'opacity':opacityOnGrid}).animate({'height':Math.floor((h/rows)+addTop+1),'margin-top':0,'margin-left':0,'opacity':1,'width':Math.floor((w/cols)+addLeft+1)},(transPeriod-difference),easing,cameraeased);}else{selector.eq(slideI).show().css('z-index','999').addClass('cameracurrent');selector.eq(vis).css('z-index','1').removeClass('cameracurrent');$('.cameraContent',fakeHover).eq(slideI).addClass('cameracurrent');$('.cameraContent',fakeHover).eq(vis).removeClass('cameracurrent');tApp.delay((((transPeriod+difference)/blocks)*delay[index]*couples)*0.5).css({'display':'block','height':Math.floor((h/rows)+addTop+1),'margin-top':0,'margin-left':0,'opacity':1,'width':Math.floor((w/cols)+addLeft+1)}).animate({'height':height,'margin-left':marginLeft,'margin-top':marginTop,'width':width,'opacity':opacityOnGrid},(transPeriod-difference),easing,cameraeased);}}});}}
if($(prevNav).length){$(prevNav).click(function(){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($('.cameraSlide.cameracurrent',target).index());clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',wrap).animate({opacity:0},0);canvasLoader();if(idNum!=0){nextSlide(idNum);}else{nextSlide(amountSlide);}
opts.onStartLoading.call(this);}});}
if($(nextNav).length){$(nextNav).click(function(){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($('.cameraSlide.cameracurrent',target).index());clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},0);canvasLoader();if(idNum==amountSlide-1){nextSlide(1);}else{nextSlide(idNum+2);}
opts.onStartLoading.call(this);}});}
if(isMobile()){fakeHover.bind('swipeleft',function(event){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($('.cameraSlide.cameracurrent',target).index());clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},0);canvasLoader();if(idNum==amountSlide-1){nextSlide(1);}else{nextSlide(idNum+2);}
opts.onStartLoading.call(this);}});fakeHover.bind('swiperight',function(event){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($('.cameraSlide.cameracurrent',target).index());clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},0);canvasLoader();if(idNum!=0){nextSlide(idNum);}else{nextSlide(amountSlide);}
opts.onStartLoading.call(this);}});}
if($(pagination).length){$('.camera_pag li',wrap).click(function(){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($(this).index());var curNum=parseFloat($('.cameraSlide.cameracurrent',target).index());if(idNum!=curNum){clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},0);canvasLoader();nextSlide(idNum+1);opts.onStartLoading.call(this);}}});}
if($(thumbs).length){$('.pix_thumb img',thumbs).click(function(){if(!elem.hasClass('camerasliding')){var idNum=parseFloat($(this).parents('li').index());var curNum=parseFloat($('.cameracurrent',target).index());if(idNum!=curNum){clearInterval(u);imgFake();$('#'+pieID+', .camera_canvas_wrap',camera_thumbs_wrap).animate({opacity:0},0);$('.pix_thumb',thumbs).removeClass('cameracurrent');$(this).parents('li').addClass('cameracurrent');canvasLoader();nextSlide(idNum+1);thumbnailPos();opts.onStartLoading.call(this);}}});$('.camera_thumbs_cont .camera_prevThumbs',camera_thumbs_wrap).hover(function(){$(this).stop(true,false).animate({opacity:1},250);},function(){$(this).stop(true,false).animate({opacity:.7},250);});$('.camera_prevThumbs',camera_thumbs_wrap).click(function(){var sum=0,wTh=$(thumbs).outerWidth(),offUl=$('ul',thumbs).offset().left,offDiv=$('> div',thumbs).offset().left,ulLeft=offDiv-offUl;$('.camera_visThumb',thumbs).each(function(){var tW=$(this).outerWidth();sum=sum+tW;});if(ulLeft-sum>0){$('ul',thumbs).animate({'margin-left':'-'+(ulLeft-sum)+'px'},500,thumbnailVisible);}else{$('ul',thumbs).animate({'margin-left':0},500,thumbnailVisible);}});$('.camera_thumbs_cont .camera_nextThumbs',camera_thumbs_wrap).hover(function(){$(this).stop(true,false).animate({opacity:1},250);},function(){$(this).stop(true,false).animate({opacity:.7},250);});$('.camera_nextThumbs',camera_thumbs_wrap).click(function(){var sum=0,wTh=$(thumbs).outerWidth(),ulW=$('ul',thumbs).outerWidth(),offUl=$('ul',thumbs).offset().left,offDiv=$('> div',thumbs).offset().left,ulLeft=offDiv-offUl;$('.camera_visThumb',thumbs).each(function(){var tW=$(this).outerWidth();sum=sum+tW;});if(ulLeft+sum+sum<ulW){$('ul',thumbs).animate({'margin-left':'-'+(ulLeft+sum)+'px'},500,thumbnailVisible);}else{$('ul',thumbs).animate({'margin-left':'-'+(ulW-wTh)+'px'},500,thumbnailVisible);}});}}})(jQuery);;(function($){$.fn.cameraStop=function(){var wrap=$(this),elem=$('.camera_src',wrap),pieID='pie_'+wrap.index();elem.addClass('stopped');if($('.camera_showcommands').length){var camera_thumbs_wrap=$('.camera_thumbs_wrap',wrap);}else{var camera_thumbs_wrap=wrap;}}})(jQuery);;(function($){$.fn.cameraPause=function(){var wrap=$(this);var elem=$('.camera_src',wrap);elem.addClass('paused');}})(jQuery);;(function($){$.fn.cameraResume=function(){var wrap=$(this);var elem=$('.camera_src',wrap);if(typeof autoAdv==='undefined'||autoAdv!==true){elem.removeClass('paused');}}})(jQuery);

//	jQuery Mobile framework customized for Camera slideshow, made by
//	'jquery.mobile.define.js',
//	'jquery.ui.widget.js',
//	'jquery.mobile.widget.js',
//	'jquery.mobile.media.js',
//	'jquery.mobile.support.js',
//	'jquery.mobile.vmouse.js',
//	'jquery.mobile.event.js',
//	'jquery.mobile.core.js'
window.define=function(){Array.prototype.slice.call(arguments).pop()(window.jQuery)};define(["jquery"],function(a){(function(a,b){if(a.cleanData){var c=a.cleanData;a.cleanData=function(b){for(var d=0,e;(e=b[d])!=null;d++){a(e).triggerHandler("remove")}c(b)}}else{var d=a.fn.remove;a.fn.remove=function(b,c){return this.each(function(){if(!c){if(!b||a.filter(b,[this]).length){a("*",this).add([this]).each(function(){a(this).triggerHandler("remove")})}}return d.call(a(this),b,c)})}}a.widget=function(b,c,d){var e=b.split(".")[0],f;b=b.split(".")[1];f=e+"-"+b;if(!d){d=c;c=a.Widget}a.expr[":"][f]=function(c){return!!a.data(c,b)};a[e]=a[e]||{};a[e][b]=function(a,b){if(arguments.length){this._createWidget(a,b)}};var g=new c;g.options=a.extend(true,{},g.options);a[e][b].prototype=a.extend(true,g,{namespace:e,widgetName:b,widgetEventPrefix:a[e][b].prototype.widgetEventPrefix||b,widgetBaseClass:f},d);a.widget.bridge(b,a[e][b])};a.widget.bridge=function(c,d){a.fn[c]=function(e){var f=typeof e==="string",g=Array.prototype.slice.call(arguments,1),h=this;e=!f&&g.length?a.extend.apply(null,[true,e].concat(g)):e;if(f&&e.charAt(0)==="_"){return h}if(f){this.each(function(){var d=a.data(this,c);if(!d){throw"cannot call methods on "+c+" prior to initialization; "+"attempted to call method '"+e+"'"}if(!a.isFunction(d[e])){throw"no such method '"+e+"' for "+c+" widget instance"}var f=d[e].apply(d,g);if(f!==d&&f!==b){h=f;return false}})}else{this.each(function(){var b=a.data(this,c);if(b){b.option(e||{})._init()}else{a.data(this,c,new d(e,this))}})}return h}};a.Widget=function(a,b){if(arguments.length){this._createWidget(a,b)}};a.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",options:{disabled:false},_createWidget:function(b,c){a.data(c,this.widgetName,this);this.element=a(c);this.options=a.extend(true,{},this.options,this._getCreateOptions(),b);var d=this;this.element.bind("remove."+this.widgetName,function(){d.destroy()});this._create();this._trigger("create");this._init()},_getCreateOptions:function(){var b={};if(a.metadata){b=a.metadata.get(element)[this.widgetName]}return b},_create:function(){},_init:function(){},destroy:function(){this.element.unbind("."+this.widgetName).removeData(this.widgetName);this.widget().unbind("."+this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass+"-disabled "+"ui-state-disabled")},widget:function(){return this.element},option:function(c,d){var e=c;if(arguments.length===0){return a.extend({},this.options)}if(typeof c==="string"){if(d===b){return this.options[c]}e={};e[c]=d}this._setOptions(e);return this},_setOptions:function(b){var c=this;a.each(b,function(a,b){c._setOption(a,b)});return this},_setOption:function(a,b){this.options[a]=b;if(a==="disabled"){this.widget()[b?"addClass":"removeClass"](this.widgetBaseClass+"-disabled"+" "+"ui-state-disabled").attr("aria-disabled",b)}return this},enable:function(){return this._setOption("disabled",false)},disable:function(){return this._setOption("disabled",true)},_trigger:function(b,c,d){var e=this.options[b];c=a.Event(c);c.type=(b===this.widgetEventPrefix?b:this.widgetEventPrefix+b).toLowerCase();d=d||{};if(c.originalEvent){for(var f=a.event.props.length,g;f;){g=a.event.props[--f];c[g]=c.originalEvent[g]}}this.element.trigger(c,d);return!(a.isFunction(e)&&e.call(this.element[0],c,d)===false||c.isDefaultPrevented())}}})(jQuery)});define(["jquery","./jquery.ui.widget"],function(a){(function(a,b){a.widget("mobile.widget",{_createWidget:function(){a.Widget.prototype._createWidget.apply(this,arguments);this._trigger("init")},_getCreateOptions:function(){var c=this.element,d={};a.each(this.options,function(a){var e=c.jqmData(a.replace(/[A-Z]/g,function(a){return"-"+a.toLowerCase()}));if(e!==b){d[a]=e}});return d},enhanceWithin:function(b){var c=a.mobile.closestPageData(a(b)),d=c&&c.keepNativeSelector()||"";a(this.options.initSelector,b).not(d)[this.widgetName]()}})})(jQuery)});define(["jquery","./jquery.mobile.core"],function(a){(function(a,b){var c=a(window),d=a("html");a.mobile.media=function(){var b={},c=a("<div id='jquery-mediatest'>"),e=a("<body>").append(c);return function(a){if(!(a in b)){var f=document.createElement("style"),g="@media "+a+" { #jquery-mediatest { position:absolute; } }";f.type="text/css";if(f.styleSheet){f.styleSheet.cssText=g}else{f.appendChild(document.createTextNode(g))}d.prepend(e).prepend(f);b[a]=c.css("position")==="absolute";e.add(f).remove()}return b[a]}}()})(jQuery)});define(["jquery","./jquery.mobile.media"],function(a){(function(a,b){function m(){var b=location.protocol+"//"+location.host+location.pathname+"ui-dir/",d=a("head base"),e=null,f="",g,h;if(!d.length){d=e=a("<base>",{href:b}).appendTo("head")}else{f=d.attr("href")}g=a("<a href='testurl' />").prependTo(c);h=g[0].href;d[0].href=f||location.pathname;if(e){e.remove()}return h.indexOf(b)===0}function l(){var b="transform-3d";return k("perspective","10px","moz")||a.mobile.media("(-"+e.join("-"+b+"),(-")+"-"+b+"),("+b+")")}function k(a,b,c){var d=document.createElement("div"),f=function(a){return a.charAt(0).toUpperCase()+a.substr(1)},g=function(a){return"-"+a.charAt(0).toLowerCase()+a.substr(1)+"-"},h=function(c){var e=g(c)+a+": "+b+";",h=f(c),i=h+f(a);d.setAttribute("style",e);if(!!d.style[i]){k=true}},j=c?[c]:e,k;for(i=0;i<j.length;i++){h(j[i])}return!!k}function j(a){var c=a.charAt(0).toUpperCase()+a.substr(1),f=(a+" "+e.join(c+" ")+c).split(" ");for(var g in f){if(d[f[g]]!==b){return true}}}var c=a("<body>").prependTo("html"),d=c[0].style,e=["Webkit","Moz","O"],f="palmGetResource"in window,g=window.operamini&&{}.toString.call(window.operamini)==="[object OperaMini]",h=window.blackberry;a.extend(a.mobile,{browser:{}});a.mobile.browser.ie=function(){var a=3,b=document.createElement("div"),c=b.all||[];while(b.innerHTML="<!--[if gt IE "+ ++a+"]><br><![endif]-->",c[0]){}return a>4?a:!a}();a.extend(a.support,{orientation:"orientation"in window&&"onorientationchange"in window,touch:"ontouchend"in document,cssTransitions:"WebKitTransitionEvent"in window||k("transition","height 100ms linear"),pushState:"pushState"in history&&"replaceState"in history,mediaquery:a.mobile.media("only all"),cssPseudoElement:!!j("content"),touchOverflow:!!j("overflowScrolling"),cssTransform3d:l(),boxShadow:!!j("boxShadow")&&!h,scrollTop:("pageXOffset"in window||"scrollTop"in document.documentElement||"scrollTop"in c[0])&&!f&&!g,dynamicBaseTag:m()});c.remove();var n=function(){var a=window.navigator.userAgent;return a.indexOf("Nokia")>-1&&(a.indexOf("Symbian/3")>-1||a.indexOf("Series60/5")>-1)&&a.indexOf("AppleWebKit")>-1&&a.match(/(BrowserNG|NokiaBrowser)\/7\.[0-3]/)}();a.mobile.ajaxBlacklist=window.blackberry&&!window.WebKitPoint||g||n;if(n){a(function(){a("head link[rel='stylesheet']").attr("rel","alternate stylesheet").attr("rel","stylesheet")})}if(!a.support.boxShadow){a("html").addClass("ui-mobile-nosupport-boxshadow")}})(jQuery)});define(["jquery"],function(a){(function(a,b,c,d){function O(b){var c=b.substr(1);return{setup:function(d,f){if(!M(this)){a.data(this,e,{})}var g=a.data(this,e);g[b]=true;k[b]=(k[b]||0)+1;if(k[b]===1){t.bind(c,H)}a(this).bind(c,N);if(s){k["touchstart"]=(k["touchstart"]||0)+1;if(k["touchstart"]===1){t.bind("touchstart",I).bind("touchend",L).bind("touchmove",K).bind("scroll",J)}}},teardown:function(d,f){--k[b];if(!k[b]){t.unbind(c,H)}if(s){--k["touchstart"];if(!k["touchstart"]){t.unbind("touchstart",I).unbind("touchmove",K).unbind("touchend",L).unbind("scroll",J)}}var g=a(this),h=a.data(this,e);if(h){h[b]=false}g.unbind(c,N);if(!M(this)){g.removeData(e)}}}}function N(){}function M(b){var c=a.data(b,e),d;if(c){for(d in c){if(c[d]){return true}}}return false}function L(a){if(r){return}B();var b=y(a.target),c;G("vmouseup",a,b);if(!o){var d=G("vclick",a,b);if(d&&d.isDefaultPrevented()){c=w(a).changedTouches[0];p.push({touchID:v,x:c.clientX,y:c.clientY});q=true}}G("vmouseout",a,b);o=false;E()}function K(b){if(r){return}var c=w(b).touches[0],d=o,e=a.vmouse.moveDistanceThreshold;o=o||Math.abs(c.pageX-m)>e||Math.abs(c.pageY-n)>e,flags=y(b.target);if(o&&!d){G("vmousecancel",b,flags)}G("vmousemove",b,flags);E()}function J(a){if(r){return}if(!o){G("vmousecancel",a,y(a.target))}o=true;E()}function I(b){var c=w(b).touches,d,e;if(c&&c.length===1){d=b.target;e=y(d);if(e.hasVirtualBinding){v=u++;a.data(d,f,v);F();D();o=false;var g=w(b).touches[0];m=g.pageX;n=g.pageY;G("vmouseover",b,e);G("vmousedown",b,e)}}}function H(b){var c=a.data(b.target,f);if(!q&&(!v||v!==c)){var d=G("v"+b.type,b);if(d){if(d.isDefaultPrevented()){b.preventDefault()}if(d.isPropagationStopped()){b.stopPropagation()}if(d.isImmediatePropagationStopped()){b.stopImmediatePropagation()}}}}function G(b,c,d){var e;if(d&&d[b]||!d&&z(c.target,b)){e=x(c,b);a(c.target).trigger(e)}return e}function F(){if(l){clearTimeout(l);l=0}}function E(){F();l=setTimeout(function(){l=0;C()},a.vmouse.resetTimerDuration)}function D(){A()}function C(){v=0;p.length=0;q=false;B()}function B(){r=true}function A(){r=false}function z(b,c){var d;while(b){d=a.data(b,e);if(d&&(!c||d[c])){return b}b=b.parentNode}return null}function y(b){var c={},d,f;while(b){d=a.data(b,e);for(f in d){if(d[f]){c[f]=c.hasVirtualBinding=true}}b=b.parentNode}return c}function x(b,c){var e=b.type,f,g,i,k,l,m,n,o;b=a.Event(b);b.type=c;f=b.originalEvent;g=a.event.props;if(e.search(/mouse/)>-1){g=j}if(f){for(n=g.length,k;n;){k=g[--n];b[k]=f[k]}}if(e.search(/mouse(down|up)|click/)>-1&&!b.which){b.which=1}if(e.search(/^touch/)!==-1){i=w(f);e=i.touches;l=i.changedTouches;m=e&&e.length?e[0]:l&&l.length?l[0]:d;if(m){for(o=0,len=h.length;o<len;o++){k=h[o];b[k]=m[k]}}}return b}function w(a){while(a&&typeof a.originalEvent!=="undefined"){a=a.originalEvent}return a}var e="virtualMouseBindings",f="virtualTouchID",g="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),h="clientX clientY pageX pageY screenX screenY".split(" "),i=a.event.mouseHooks?a.event.mouseHooks.props:[],j=a.event.props.concat(i),k={},l=0,m=0,n=0,o=false,p=[],q=false,r=false,s="addEventListener"in c,t=a(c),u=1,v=0;a.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500};for(var P=0;P<g.length;P++){a.event.special[g[P]]=O(g[P])}if(s){c.addEventListener("click",function(b){var c=p.length,d=b.target,e,g,h,i,j,k;if(c){e=b.clientX;g=b.clientY;threshold=a.vmouse.clickDistanceThreshold;h=d;while(h){for(i=0;i<c;i++){j=p[i];k=0;if(h===d&&Math.abs(j.x-e)<threshold&&Math.abs(j.y-g)<threshold||a.data(h,f)===j.touchID){b.preventDefault();b.stopPropagation();return}}h=h.parentNode}}},true)}})(jQuery,window,document)});define(["jquery","./jquery.mobile.core","./jquery.mobile.media","./jquery.mobile.support","./jquery.mobile.vmouse"],function(a){(function(a,b,c){function i(b,c,d){var e=d.type;d.type=c;a.event.handle.call(b,d);d.type=e}a.each(("touchstart touchmove touchend orientationchange throttledresize "+"tap taphold swipe swipeleft swiperight scrollstart scrollstop").split(" "),function(b,c){a.fn[c]=function(a){return a?this.bind(c,a):this.trigger(c)};a.attrFn[c]=true});var d=a.support.touch,e="touchmove scroll",f=d?"touchstart":"mousedown",g=d?"touchend":"mouseup",h=d?"touchmove":"mousemove";a.event.special.scrollstart={enabled:true,setup:function(){function g(a,c){d=c;i(b,d?"scrollstart":"scrollstop",a)}var b=this,c=a(b),d,f;c.bind(e,function(b){if(!a.event.special.scrollstart.enabled){return}if(!d){g(b,true)}clearTimeout(f);f=setTimeout(function(){g(b,false)},50)})}};a.event.special.tap={setup:function(){var b=this,c=a(b);c.bind("vmousedown",function(d){function k(a){j();if(e==a.target){i(b,"tap",a)}}function j(){h();c.unbind("vclick",k).unbind("vmouseup",h);a(document).unbind("vmousecancel",j)}function h(){clearTimeout(g)}if(d.which&&d.which!==1){return false}var e=d.target,f=d.originalEvent,g;c.bind("vmouseup",h).bind("vclick",k);a(document).bind("vmousecancel",j);g=setTimeout(function(){i(b,"taphold",a.Event("taphold"))},750)})}};a.event.special.swipe={scrollSupressionThreshold:10,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:75,setup:function(){var b=this,d=a(b);d.bind(f,function(b){function j(b){if(!f){return}var c=b.originalEvent.touches?b.originalEvent.touches[0]:b;i={time:(new Date).getTime(),coords:[c.pageX,c.pageY]};if(Math.abs(f.coords[0]-i.coords[0])>a.event.special.swipe.scrollSupressionThreshold){b.preventDefault()}}var e=b.originalEvent.touches?b.originalEvent.touches[0]:b,f={time:(new Date).getTime(),coords:[e.pageX,e.pageY],origin:a(b.target)},i;d.bind(h,j).one(g,function(b){d.unbind(h,j);if(f&&i){if(i.time-f.time<a.event.special.swipe.durationThreshold&&Math.abs(f.coords[0]-i.coords[0])>a.event.special.swipe.horizontalDistanceThreshold&&Math.abs(f.coords[1]-i.coords[1])<a.event.special.swipe.verticalDistanceThreshold){f.origin.trigger("swipe").trigger(f.coords[0]>i.coords[0]?"swipeleft":"swiperight")}}f=i=c})})}};(function(a,b){function j(){var a=e();if(a!==f){f=a;c.trigger("orientationchange")}}var c=a(b),d,e,f,g,h,i={0:true,180:true};if(a.support.orientation){g=a.mobile.media("all and (orientation: landscape)");h=i[b.orientation];if(g&&h||!g&&!h){i={"-90":true,90:true}}}a.event.special.orientationchange=d={setup:function(){if(a.support.orientation&&a.mobile.orientationChangeEnabled){return false}f=e();c.bind("throttledresize",j)},teardown:function(){if(a.support.orientation&&a.mobile.orientationChangeEnabled){return false}c.unbind("throttledresize",j)},add:function(a){var b=a.handler;a.handler=function(a){a.orientation=e();return b.apply(this,arguments)}}};a.event.special.orientationchange.orientation=e=function(){var c=true,d=document.documentElement;if(a.support.orientation){c=i[b.orientation]}else{c=d&&d.clientWidth/d.clientHeight<1.1}return c?"portrait":"landscape"}})(jQuery,b);(function(){a.event.special.throttledresize={setup:function(){a(this).bind("resize",c)},teardown:function(){a(this).unbind("resize",c)}};var b=250,c=function(){f=(new Date).getTime();g=f-d;if(g>=b){d=f;a(this).trigger("throttledresize")}else{if(e){clearTimeout(e)}e=setTimeout(c,b-g)}},d=0,e,f,g})();a.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe",swiperight:"swipe"},function(b,c){a.event.special[b]={setup:function(){a(this).bind(c,a.noop)}}})})(jQuery,this)});define(["jquery","../external/requirejs/text!../version.txt","./jquery.mobile.widget"],function(a,b){(function(a,c,d){var e={};a.mobile=a.extend({},{version:b,ns:"",subPageUrlKey:"ui-page",activePageClass:"ui-page-active",activeBtnClass:"ui-btn-active",focusClass:"ui-focus",ajaxEnabled:true,hashListeningEnabled:true,linkBindingEnabled:true,defaultPageTransition:"fade",maxTransitionWidth:false,minScrollBack:10,touchOverflowEnabled:false,defaultDialogTransition:"pop",loadingMessage:"loading",pageLoadErrorMessage:"Error Loading Page",loadingMessageTextVisible:false,loadingMessageTheme:"a",pageLoadErrorMessageTheme:"e",autoInitializePage:true,pushStateEnabled:true,orientationChangeEnabled:true,gradeA:function(){return a.support.mediaquery||a.mobile.browser.ie&&a.mobile.browser.ie>=7},keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91},silentScroll:function(b){if(a.type(b)!=="number"){b=a.mobile.defaultHomeScroll}a.event.special.scrollstart.enabled=false;setTimeout(function(){c.scrollTo(0,b);a(document).trigger("silentscroll",{x:0,y:b})},20);setTimeout(function(){a.event.special.scrollstart.enabled=true},150)},nsNormalizeDict:e,nsNormalize:function(b){if(!b){return}return e[b]||(e[b]=a.camelCase(a.mobile.ns+b))},getInheritedTheme:function(a,b){var c=a[0],d="",e=/ui-(bar|body)-([a-z])\b/,f,g;while(c){var f=c.className||"";if((g=e.exec(f))&&(d=g[2])){break}c=c.parentNode}return d||b||"a"},closestPageData:function(a){return a.closest(':jqmData(role="page"), :jqmData(role="dialog")').data("page")}},a.mobile);a.fn.jqmData=function(b,c){var d;if(typeof b!="undefined"){d=this.data(b?a.mobile.nsNormalize(b):b,c)}return d};a.jqmData=function(b,c,d){var e;if(typeof c!="undefined"){e=a.data(b,c?a.mobile.nsNormalize(c):c,d)}return e};a.fn.jqmRemoveData=function(b){return this.removeData(a.mobile.nsNormalize(b))};a.jqmRemoveData=function(b,c){return a.removeData(b,a.mobile.nsNormalize(c))};a.fn.removeWithDependents=function(){a.removeWithDependents(this)};a.removeWithDependents=function(b){var c=a(b);(c.jqmData("dependents")||a()).remove();c.remove()};a.fn.addDependents=function(b){a.addDependents(a(this),b)};a.addDependents=function(b,c){var d=a(b).jqmData("dependents")||a();a(b).jqmData("dependents",a.merge(d,c))};a.fn.getEncodedText=function(){return a("<div/>").text(a(this).text()).html()};var f=a.find,g=/:jqmData\(([^)]*)\)/g;a.find=function(b,c,d,e){b=b.replace(g,"[data-"+(a.mobile.ns||"")+"$1]");return f.call(this,b,c,d,e)};a.extend(a.find,f);a.find.matches=function(b,c){return a.find(b,null,null,c)};a.find.matchesSelector=function(b,c){return a.find(c,null,null,[b]).length>0}})(jQuery,this)})


/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */
 
 
 
 /********************************************************
		HERO GALLERY
	*********************************************************/	
	$('#hero-gallery').camera({
		height: '300px',
		pagination: true,
		thumbnails: false,
		easing: 'easeInOutExpo',
		hover: true,
		navigation: true,
		navigationHover: false,
		mobileNavHover: false,
		playPause: false,
		opacityOnGrid: false,
		imagePath: '_img/',
		fx:'scrollLeft',
		transPeriod: 800,
		time: 9000,
		alignment: 'topRight',
		loader: 'none'
	});
	$(".camera_prev").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	$(".camera_next").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
);
 
 
