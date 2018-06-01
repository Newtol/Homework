/**
 * 教师--评分
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});

require(["lib/jquery", "util/request", "modules/api", "lib/handlebars"], function($, request) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.computeWork();
			$(".person").html(sessionStorage.person + "老师，您好！");
		},

		/* 查看学生完成的作业 */
		computeWork: function() {
			request.get(
				_api.computeWork + index.getId().workId + "/" + index.getId().stuId,
				{},
				function(data) {
					var result = $.parseJSON(data);
					console.log(result);
					
					if (result.message == "not commit") {
						alert("该同学还没有提交作业！");
					} else {
						var correctingTpl = Handlebars.compile($("#correcting").html());
						$(".content").html(correctingTpl(result.data[0]));
						index.correcting();
					}
				}
			);
		},

		/* 评分 */
		correcting: function() {
			$("#correcting-btn").on("click", function() {
				
				request.post(
					_api.teaCorrecting,
					{
						"garde": $("#grade option:selected").val().toLowerCase(),
						"addtion": $(".addtion").val(),
						"asid": index.getId().workId,
						"sid": index.getId().stuId
					},
					function(data) {
						var result = $.parseJSON(data);
						if (result.message == "ok") {
							alert("评阅结果提交成功！");
						}
						console.log(data);
					}
				);
			});
			
		},

		/* 取得ID */
		getId: function() {
			var reg = new RegExp("(^|&)"+ "workId" +"=([^&]*)(&|$)" + "stuId" + "=([^&]*)(&|$)");

			//取得以？开头的字符串，然后从第一个字符开始匹配正则
	        var regResult = window.location.search.substring(1).match(reg);	        
	    
	        if (regResult != null) {
	        	
	        	//解码,得到id
	        	return {
	        		workId: decodeURI(regResult[2]),
	        		stuId: decodeURI(regResult[4])  
	        	};
	        } else {
	        	return null;
	        }
		}
		

	};

	index.init();

	
});




