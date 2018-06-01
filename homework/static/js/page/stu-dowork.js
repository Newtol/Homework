/**
 * 学生--查看作业，提交作业
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
 			_this.getWorkDetail();
 			$(".person").html(sessionStorage.person + "同学，您好！");
 		},

 		/* 请求作业详情 */
 		getWorkDetail: function() {
 		 	request.get(
 		 		_api.stuSelfwork + index.getId().courseId,
 				{},
 		 		function(data) {
 		 			var result = $.parseJSON(data);
 		 			console.log(result);
 		 			var detailTpl = Handlebars.compile($("#work-detail").html());
 		 			$(".detail-wraper").html(detailTpl(result.data));


 		 			$("#course-id").val(index.getId().courseId);
 		 			/* 提交或修改作业 */
 		 			$(".sub-work").bind("click", function() {
 		 				index.dowork(_api.submitWork);
 		 			});
 		 			$(".edit-work").bind("click", function() {
 		 				index.dowork(_api.editWork);
 		 			}); 
 		 			
 		 		}
 		 	);
 		},
 		

 		 /* 提交或修改作业 */
 		dowork: function(workUrl) {
 		 	
		 	var workForm = new FormData($("#work-form")[0]);
		 	
			$.ajax({
				type: "POST",				
				processData: false, 
  				contentType: false,
  				cache: false, 				
				url: workUrl,
				data: workForm,
				success: function(result) {
					console.log(result);
					var result = $.parseJSON(result);
					if (result.message == "ok") {
						alert("提交成功！");
					} else {
						alert("提交失败！");
					}
					
				}
			}); 		 	
 		 },


 		/* 取得ID */
 		getId: function() {
 			var reg = new RegExp("(^|&)"+ "courseId" + "=([^&]*)(&|$)" + "address" + "=([^&]*)(&|$)");

 			//取得以？开头的字符串，然后从第一个字符开始匹配正则
 	        var regResult = window.location.search.substring(1).match(reg);	        
	    
 	        if (regResult != null) {
	        	
 	        	//解码,得到id
 	        	
 	        	return {
 	        		courseId: decodeURI(regResult[2]),//课程号
 	        		address: decodeURI(regResult[4]) //文件地址
 	        	};
 	        } else {
 	        	return null;
 	        }
		}

		
 	};

	index.init();

	
 });




