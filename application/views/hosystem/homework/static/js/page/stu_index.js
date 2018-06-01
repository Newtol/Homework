/**
 * 学生首页
 * @author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "modules/bg_random", "modules/search_class", "lib/handlebars"], 
	function($, bgRandom, searchClass) {
	
	var index = {
		init: function() {
			var _this = index;
			//_this.stuSituation();
			_this.createClass();
			bgRandom();
			searchClass();
		},

		/* 学生情况 */
		stuSituation: function() {
			$("#my-situation").bind("click", function() {
				$(this).addClass("hide");
				$(".stu-cover").css("display", "block");
				$("#close-situation").css("display", "block");
				$(".show-situation").addClass("add-bg");
				$(".stu-situation").slideDown();
			});

			$("#close-situation").bind("click", function() {
				$(".stu-situation").slideUp();
				$("#my-situation").removeClass("hide");
				$(".stu-cover").css("display", "none");
				$("#close-situation").css("display", "none");
				$(".show-situation").removeClass("add-bg");				
			});
		},

		/* 创建班级 */
		createClass: function() {
			$(".create-btn").bind("click", function() {
				if ($(".create-class").css("display") == "none") {
					$(this).addClass("long-width");
					$(".create-class").fadeIn("slow");
				} else {
					$(".create-class").fadeOut("slow");
					$(this).removeClass("long-width");
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
						console.log(data);
					}
				);
			});
		}

		
	};

	index.init();

	
});




