/**
 * 管理员查看班级申请
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
 			_this.getApplyList();
 			$(".person").html(sessionStorage.person + "同学，您好！");
 		},

 		/* 请求申请列表 */
 		 getApplyList: function() {
 		 	request.get(
 		 		_api.applyList + index.getId(),
 				{},
 		 		function(data) {
 		 			var result = $.parseJSON(data);
 		 			console.log(result);

 		 			var detailTpl = Handlebars.compile($("#apply-list-tpl").html());
 		 			$(".apply-wraper").html(detailTpl(result.data));

 		 			$(".tea-agree-handle").bind("click", function() {

 		 				var courseId = index.getId(),
 		 					apid = $(this).prev().html(),
 		 					parent = $(this).parent().parent();
 		 					
 		 				request.post(
 		 					_api.agreeTea,
 		 					{
 		 						"cid": courseId,
 		 						"tid": parent.find(".id-app").html(),
 		 						"course": parent.find(".course-app").html(),
 		 						"addtion": parent.find(".addtion-app").html()
 		 					},
 		 					function(data) {
 		 						var result = $.parseJSON(data);
 		 						console.log(result);
 		 						index.getApplyList();
 		 					}
 		 				);
 		 			});

 		 			// 拒绝老师的申请
 		 			$(".tea-refuse-handle").click(function() {
 		 				var courseId = index.getId();
 		 				request.post(
 		 					_api.refuseApply,
 		 					{
 		 						"apid": $(this).prev().prev().html(),
 		 						"sirorstu": "sir",
 		 						"cid": courseId
 		 					},
 		 					function(data) {
 		 						var result = $.parseJSON(data);
 		 						console.log(result);
 		 						index.getApplyList();
 		 					}
 		 				);
 		 			});

 		 			// 拒绝同学的申请
 		 			$(".stu-refuse-handle").click(function() {
 		 				var courseId = index.getId();
 		 				
 		 				request.post(
 		 					_api.refuseApply,
 		 					{
 		 						"apid": $(this).parent().parent().find(".id-app").html(),
 		 						"sirorstu": "stu",
 		 						"cid": courseId
 		 					},
 		 					function(data) {
 		 						var result = $.parseJSON(data);
 		 						console.log(result);
 		 						index.getApplyList();
 		 					}
 		 				);
 		 			});

 		 			// 同意同学的申请
 		 			$(".stu-agree-handle").bind("click", function() {
 		 				var courseId = index.getId();
 		 				request.post(
 		 					_api.agreeStu,
 		 					{
 		 						"cid": courseId,
 		 						"sid": $(this).parent().parent().find(".id-app").html()
 		 					},
 		 					function(data) {
 		 						var result = $.parseJSON(data);
 		 						console.log(result);

 		 						index.getApplyList();
 		 					}
 		 				);
 		 			});
 		 			 			
 		 		}
 		 	);
 		 },


 		/* 取得ID */
 		getId: function() {
 			var reg = new RegExp("(^|&)"+ "courseId" + "=([^&]*)(&|$)");

 			//取得以？开头的字符串，然后从第一个字符开始匹配正则
 	        var regResult = window.location.search.substring(1).match(reg);	        
	    
 	        if (regResult != null) {
	        	
 	        	//解码,得到id
 	        	
 	        	return decodeURI(regResult[2]);
 	        } else {
 	        	return null;
 	        }
		}

		
 	};

	index.init();

	
 });




