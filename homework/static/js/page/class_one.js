
require.config({
	baseUrl: "/homework/static/js/"
});

require(["lib/jquery", "util/request", "modules/api", "lib/handlebars"], 
	function($, request) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.getStu();
			
			_this.showDeclare();
			_this.declareWork();
			$(".person").html(sessionStorage.person + "您好！");
			$(".send-announce").attr("href", "set-announcement.html?classId=" + index.getId().classId);
			$(".work-id").html(index.getId().workId);
			$("#class-name").html(index.getId().className);
		},

		/* 请求班级学生 */
		getStu: function() {
			
			request.get(
				_api.getStu + index.getId().classId,
				{},
				function(data) {
					var result = $.parseJSON(data);
					console.log(result);
					var dataLen = result.data.length,
						data = result.data,
						courseId = index.getId().classId;
					for (var i = 0; i < dataLen; i ++) {
						data[i].jid = courseId;
					}
					var stuListTpl = Handlebars.compile($("#stu-list").html());
					$(".stu-info-list").html(stuListTpl(data));

					index.randomColor();
				}
			);
		},

		/* 发布作业 */
		declareWork: function() {
			$(".jid").attr("value", index.getId().jid);
			$("#declare-form").on("submit", function() {
		 		
				var declareForm = new FormData($("#declare-form")[0]);
				$.ajax({
					type: "POST",				
					processData: false, 
	  				contentType: false, 				
					url: _api.declareWork,
					data: declareForm,
					success: function(result) {
						var result = $.parseJSON(result);
						$(".cover").hide();
						$(".declare-box").hide();
						if (result.message == 'ok') {
							alert("发布成功! ");
						}
						console.log(result);
					}
				});

				return false;
			});
		},

		/* 取得ID */
		getId: function() {
			var reg = new RegExp("(^|&)"+ "workId" + "=([^&]*)(&|$)" + "classId" + "=([^&]*)(&|$)" + "jid" + "=([^&]*)(&|$)" + "className" + "=([^&]*)(&|$)");

			//取得以？开头的字符串，然后从第一个字符开始匹配正则
	        var regResult = window.location.search.substring(1).match(reg);	   
	        if (regResult != null) {
	        	
	        	//解码,得到id
	        	return {
	        		workId: decodeURI(regResult[2]),
	        		classId: decodeURI(regResult[4]),
	        		jid: decodeURI(regResult[6]),
	        		className: decodeURI(regResult[8])
	        	} 
	        } else {
	        	return null;
	        }
		},

		/* 颜色随机 */
		randomColor: function() {
			var stuList = $(".stu-list ul>li"),
				stuListLen = stuList.length,
				randomNum = 0;
			for (var i = 0; i < stuListLen; i ++) {
				randomNum = parseInt(Math.random() * 4 + 1, 10);
				stuList.eq(i).addClass("color" + randomNum);

			}
			
		},

		/* 发布作业 */
		showDeclare: function() {
			$(".declare-work").bind("click", function() {
				$(".declare-box").removeClass("hide-declare");
				$(".cover").fadeIn();
			});
			$(".declare-close").bind("click", function() {
				$(".declare-box").addClass("hide-declare");
				$(".cover").fadeOut();
			});
		}

	};

	index.init();

});




