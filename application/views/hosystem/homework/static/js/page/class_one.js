/**
 * 教师--班级
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});

require(['lib/jquery', 'modules/course_block', 'lib/handlebars'], function($, courseBlock) {
	
	var index = {
		init: function() {
			var _this = index;
			_this.randomColor();
			_this.showDeclare();
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




