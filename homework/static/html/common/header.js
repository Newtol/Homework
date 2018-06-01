
(function() {
	
	"use strict"
	var companyId,companyName;
	var headerCss = document.getElementsByTagName('script'),
		path, cssPath, headTitle = "";
	var temp = "/homework/static";

	// if (location.host == 'localhost:8080' || location.host == '202.202.43.7' ||
	// 	location.host == '172.22.1.159') {
	// 	temp = '/sewage/static';
	// } else {
	// 	temp = '';
	// }

	for(var i = 0; i < headerCss.length; i ++){
	    cssPath = headerCss[i].getAttribute('data-css');
		headTitle = headerCss[i].getAttribute('data-title');
		if(cssPath != null && cssPath != undefined){

			//css路径
			cssPath = '<link rel="stylesheet" href="' + temp + '/css/page/' + cssPath + '.css"/>'
			break;	
		}

	}
	var html = '<!DOCTYPE html>'+
				'<html lang="en">'+
				'<head>'+
					'<meta charset="UTF-8">'+
					'<meta name="viewPort" content="width=device-width, initial-scale=1.0">'+
					'<title>' + headTitle + '</title>'+
					'<link rel="stylesheet" href="/css/lib/bootstrap.css"/>'+
					'<link rel="stylesheet" href="/css/global.css"/>'+
					'<link rel="stylesheet" href="/css/common/header.css"/>'
					+cssPath+
					'<script>'+	
						'var MIS = {};'+
						'MIS.STATIC_ROOT = "/js"'+ '</script>'+ 
						'<script src="' + temp + '/js/lib/jquery.js"></script>' +  
						'<script src="' + temp + '/js/modules/api.js"></script>'
				'</head>'+
				'<body>';
				
    var headerTpl = function() {

		/*
			<div class="common-header" id="top">
				<div class="common-header-bar">
					<span class="greeting">欢迎光临龙跃E+平台</span>
					<ul class="common-header-aside login-or-register">
						<li class="common-header-item login">
							<a href="login.html"><span>登录</span></a>
						</li>
						<li class="common-header-item register">
							<a href="reg.html"><span>注册</span></a>
						</li>
					</ul>
					<ul class="common-header-list">
						<li class="common-header-item index">
							<a id="userPage" href="manage.html">
								<i class="user-home-pic inline-block"></i>
								<span class="index-font">用户主页</span>
							</a>
						</li>
						<li class="common-header-item index">
							<a href="#">
								<i class="contact-service-pic inline-block"></i>
								<span class="index-font">联系客服</span>
							</a>
						</li>
					</ul>
				</div>

				<div class="common-header-main clearfix">
					<div  class="pull-left logo-img">
						<a href="index.html"><img src="../../img/index2/logo.png" alt="污水处理logo"></a>
					</div>
					<div class="common-header-search pull-right">
						<select name="searchType" class="pull-left">							
							<option class="caret">查找需求</option><span class="caret"></span>
							<option>查找公司</option>
						</select>
						<input type="text" name="searchCondition" placeholder="公司名/需求名" class="pull-left search-box">
						<button id="btn-search" class="pull-left">搜索</button>
						<span class="search-tips">查询中...</span>
					</div>
				</div>
				<div class="nav-main">
					<ul>
						<li><a class="navs" href="index.html">首页</a></li>
						<li><a class="navs" href="demands.html">需求大厅</a></li>
						<li><a id="publishDemand" class="navs" href="publish.html">发布需求</a></li>
						<li><a class="navs" href="company.html">工程公司</a></li>
						<li><a class="navs" href="add.html">工程报价</a></li>
						<li><a class="navs" href="strategy.html">工程教学</a></li>
						<li><a class="navs" href="mall.html">建材商城</a></li>
					</ul>
				</div>
			</div>
		*/
	};

	var  header = html +'<div class="wrapper">'+ headerTpl.toString().replace(/^[^\/]+\/\*!?/, '').replace(/\*\/[^\/]+$/, '');
	document.write(header);

})();