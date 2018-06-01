/**
 * 数据分析
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "util/request", "modules/api", "lib/handlebars"], function($, request) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.getData();

			request.get(
				_api.analyYear,
				{},
				function(result) {}
			);
			$(".back").bind("click", function(event) {
				var event = window.event;
				event.preventDefault();
				history.go(-1);
			});
		},

		getData: function() {

			var infoData = {};

			// 加入时间
			request.get(
				_api.whenjoin,
				{},
				function(result) {
					var result = $.parseJSON(result);
					console.log(result);
					var courseListTpl = Handlebars.compile($("#join-high").html());
					$(".join-high").append(courseListTpl(result.data));
				}
			);

			// // 最高的课程
			// request.get(
			// 	_api.whichHigh,
			// 	{},
			// 	function(result) {
			// 		var result = $.parseJSON(result);
			// 		console.log(result);
			// 		var courseListTpl = Handlebars.compile($("#join-high").html());
			// 		$(".join-high").append(courseListTpl(result.data));
			// 	}
			// );

			request.get(
				_api.bestBad,
				{},
				function(result) {
					var result = $.parseJSON(result);					
					console.log(result);
					var courseListTpl = Handlebars.compile($("#year-result").html());
					$(".join-high").append(courseListTpl(result.data));
				}
			);
		}
	}
	index.init();	
});




