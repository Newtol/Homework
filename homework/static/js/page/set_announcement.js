/**
 * 教师公告
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery",  "util/request", "modules/api", "lib/handlebars"], function($, request) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.changeTab();
			_this.getAnnounce();
			_this.sendAnnounce();
			$(".person").html(sessionStorage.person + "您好！");

			var flag = _this.getFlag();

			$("#self-set").attr("href", "set-information.html?flag=" + _this.getFlag());
			if (flag == "1") {
				$("#home").attr("href", "teacher-course.html");
			} else if (flag == "2") {
				$("#home").attr("href", "stu-index.html");
			}
		},
		getFlag: function() {
			var reg = new RegExp("(^|&)"+ "flag" + "=([^&]*)(&|$)");

			//取得以？开头的字符串，然后从第一个字符开始匹配正则
	        var regResult = window.location.search.substring(1).match(reg);	        
	    
	        if (regResult != null) {
	        	
	        	//解码,得到id
	        	return regResult[2];
	        } else {
	        	return null;
	        }
		},

		/* 消息列表 */
		getAnnounce: function() {
			request.get(
				_api.announceList,
				{},
				function(data) {
					
					var result = $.parseJSON(data);
					console.log(result);
					var announceTpl = Handlebars.compile($("#announce-tpl").html());
					$(".announce-list").html(announceTpl(result.data));

					var msgIds = $(".mId"),
						msgIdsLen = msgIds.length;
					$(".announce-list a").bind("click", function() {
						var index = $(".announce-list a").index(this);
						request.get(
							_api.announceDetail + msgIds.eq(index).html(),
							{},
							function(data) {

								data = $.parseJSON(data);
								console.log(data);

								$("#announce-detail p").html(data.data.content);
								$("div.conBox>div").hide();
								$("#announce-detail").show();
							}
						);

						return false;
					});
					
				}
			);
		},

		/* 发公告 */
		sendAnnounce: function() {
			$("#send-announce").bind("click", function() {
				request.post(
					_api.sendAnnounce,
					{
						"type": "class",
						"id": index.getId(),
						"content": $(".announce-content").val()
					},
					function(data) {
						console.log($.parseJSON(data));
						alert("成功！");
					}
				);
			});
		},

		/* Tab */
		changeTab: function() {
			var $title = $(".menu li");
			$title.click(function() {
				$(this).removeClass("noselected").addClass("selected")
					.siblings().removeClass("selected").addClass("noselected");
				var index = $title.index(this);
				$("div.conBox>div")
					.eq(index).show()
					.siblings().hide();
			});
			
		},
		/* 取得ID */
		getId: function() {
			var reg = new RegExp("(^|&)"+ "classId" +"=([^&]*)(&|$)");

			//取得以？开头的字符串，然后从第一个字符开始匹配正则
	        var regResult = window.location.search.substring(1).match(reg);	        
	    
	        if (regResult != null) {
	        	
	        	//解码,得到id
	        	return decodeURI(regResult[2]);  
	        } else {
	        	return null;
	        }
		},


		/* 退出账号 */
		quit: function() {
			$(".quit").bind("click", function() {
				request.post(
					_api.quit,
					{},
					function(data) {
						console.log(data);
					}
				);
			});
		}
	};

	index.init();
	
});




