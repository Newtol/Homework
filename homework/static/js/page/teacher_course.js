/**
 *首页
 *@author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "util/request", "modules/search_class", "lib/handlebars"], 
	function($, request, searchClass) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.classList();
			_this.workList();
			searchClass(1);
			$(".person").html(sessionStorage.person + "老师，您好！");
		},

		/* 老师班级 */
		classList: function() {
			request.post(
				_api.teaClassList,
				{},
				function(data) {
					var result = $.parseJSON(data);
					console.log(result.data);
					var classListTpl = Handlebars.compile($("#class-List").html());					
					$(".class-wraper").html(classListTpl(result.data));
				}
			);
		},

		/* 老师作业 */
		workList: function() {
			request.post(
				_api.teaWorkList,
				{},
				function(data) {
					var result = $.parseJSON(data);
					console.log(result);
					var workListTpl = Handlebars.compile($("#work-tpl").html());
					$(".work-wraper").html(workListTpl(result.data));
				}
			);
		}
	};

	index.init();
});




