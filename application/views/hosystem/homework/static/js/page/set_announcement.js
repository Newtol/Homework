/**
 * 学生首页
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery",  "util/request", "modules/api", "lib/handlebars"], function($) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.changeTab();
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

			var announceList = $(".conBox li a");
			announceList.bind("click", function(event) {
				var event = event || window.event;
				$("div.conBox>div").hide();
				$("#announce-detail").show();

				event.preventDefault();
			});
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




