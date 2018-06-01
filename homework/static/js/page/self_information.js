/**
 *首页
 *@author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "util/request", "lib/handlebars", "modules/api"], 
	function($, request) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.quit();
			_this.showInfo();

			_this.editInfo();
			$(".cancel-btn").bind("click", function() {
				history.go(-1);
			});
		},

		/* 退出当前账号 */
		quit: function() {

			$(".quit").bind("click", function(event) {
				var event = event || window.event;
				event.preventDefault();
				request.post(
					_api.quit,
					{},
					function(data) {
						var result = $.parseJSON(data);
						console.log(result);
						window.location.href = "login.html";
					}
				);
			});
		},

		/* 当前信息展示*/
		showInfo: function() {

			request.get(
				_api.showInfo + index.getId(),
				{},
				function(data) {
					var result = $.parseJSON(data);
					console.log(result);
					$(".name").val(result.data.name);
					$(".realname").val(result.data.realname);
					$(".gender").val(result.data.gender);
					$(".selfintro").val(result.data.selfintro);
				}
			);
		},

		/* 修改信息 */
		editInfo: function() {
			$(".save-btn").bind("click", function() {
				console.log(index.getId());
				request.post(
					_api.editInfo,
					{
						"flag": index.getId(),
						"realname": $(".realname").val(),
						"gender": $(".gender").val(),
						"selfintro": $(".selfintro").val(),
						"name": $(".name").val()
					},
					function(data) {
						console.log(data);
						alert("修改成功！");
						index.showInfo();
					}
				);
			});
		},

		getId: function() {
			var reg = new RegExp("(^|&)"+ "flag" + "=([^&]*)(&|$)");

			//取得以？开头的字符串，然后从第一个字符开始匹配正则
	        var regResult = window.location.search.substring(1).match(reg);	        
	    
	        if (regResult != null) {
	        	
	        	//解码,得到id
	        	return regResult[2];
	        } else {
	        	return null;
	        }
		}

		
	};

	index.init();

	
});




