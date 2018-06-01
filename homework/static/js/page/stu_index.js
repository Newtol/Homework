/**
 * 学生首页
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "util/request", "modules/bg_random", "modules/search_class", "modules/api", "lib/handlebars"], 
	function($, request, bgRandom, searchClass) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.courseList();
			_this.workList();
			_this.stuClass();
			_this.createClass();			
			searchClass(2);
			$(".person").html(sessionStorage.person + "同学，您好！");

			$(".myclass-btn").on("click", function() {
				if ($(".my-class").css("display") == "none") {
					$(".my-class").slideDown();
				} else {
					$(".my-class").slideUp();
				}
			});		
		},
		

		/* 学生课程 */
		courseList: function() {
			request.post(
				_api.stuCourseList,
				{},
				function(result) {
					var result = $.parseJSON(result);
					console.log(result.data);
					var courseListTpl = Handlebars.compile($("#course-tpl").html());
					$(".class-wraper").html(courseListTpl(result.data));
				}
			);
		},

		/* 学生作业 */
		workList: function() {
			request.get(
				_api.stuWorkList,
				{},
				function(result) {
					result = $.parseJSON(result);
					var data = result.data;
					for (var i = 0, len = data.length; i < len; i ++) {
						if (data[i].isFinish == "0") {
							data[i].isFinish = false;
						} else {
							data[i].isFinish = true;
						}
					}
					console.log(data);
					var workTpl = Handlebars.compile($("#work-tpl").html());
					$(".work-wraper").html(workTpl(data));
				}
			);
		},

		/* 学生班级 */
		stuClass: function() {
			request.post(
				_api.stuClassList,
				{},
				function(result) {
					var result = $.parseJSON(result);
					console.log(result);
					var classTpl = Handlebars.compile($("#myclass-tpl").html());
					$(".my-class").html(classTpl(result.data));
				}
			);
				
		},

		/* 创建班级 */
		createClass: function() {
			$(".create-btn").bind("click", function() {

				if ($(".create-class").css("display") == "none") {
					$(this).addClass("long-width");
					$(".create-class").fadeIn("slow");
				} else {
					$(this).removeClass("long-width");
					$(".create-class").fadeOut("slow");
					
				}
				
			});

			$(".sub-create").bind("click", function() {
				request.post(
					_api.createClass,
					{
						"name": $(".class-name").val(),
						"description": $(".class-description").val()
					},
					function(data) {
						var result = $.parseJSON(data);
						console.log(data);
						$(".create-class").fadeOut("slow");
						$(this).removeClass("long-width");
						if (result.message == "succssfully") {
							alert("班级创建成功！");
						}
						index.stuClass();
					}
				);
			});
		}		
	};

	index.init();	
});




