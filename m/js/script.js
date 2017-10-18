$('.banner').unslider({fluid:false,dots:false,speed:100,keys:true,delay:false});

var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++)
{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}

window.onorientationchange=function(){window.location.reload();};
jQuery(function($){var windowWidth=$(window).width();$(window).resize(function(){if(windowWidth!=$(window).width()){location.reload();}});});