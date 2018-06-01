/**
 * 教师--查看学生平时成绩作业
 * @author: su
 **/
 require.config({
 	baseUrl: "/homework/static/js/"
 });

 require(["lib/jquery", "util/request", "modules/api", "lib/handlebars"], 
 	function($, request) {
	
 	var index = {
 		init: function() {
 			var _this = index;
 			_this.getStuDetail();
 			$(".person").html(sessionStorage.person + "，您好！");
 		},

 		/* 请求详情 */
 		 getStuDetail: function() {
 		 	request.get(
 		 		_api.stuWorkDetail + index.getId().jid + "/" + index.getId().sid,
 				{},
 		 		function(data) {
 		 			var result = JSON.parse(data);
 		 			console.log(result);
					
 		 			var detailTpl = Handlebars.compile($("#detail-tpl").html());
 		 			$(".detail-wraper").html(detailTpl(result.data));
 		 		}
 		 	);
 		 },


 		/* 取得ID */
 		getId: function() {
 			var reg = new RegExp("(^|&)"+ "jid" + "=([^&]*)(&|$)" + "sid" + "=([^&]*)(&|$)");

 			//取得以？开头的字符串，然后从第一个字符开始匹配正则
 	        var regResult = window.location.search.substring(1).match(reg);	        
	    
 	        if (regResult != null) {
	        	
 	        	//解码,得到id
 	        	return {
 	        		jid: decodeURI(regResult[2]),
 	        		sid: decodeURI(regResult[4])
 	        	}
 	        } else {
 	        	return null;
 	        }
		}

		
 	};

	index.init();

	
 });




