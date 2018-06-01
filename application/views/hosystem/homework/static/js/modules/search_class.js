define(["lib/jquery", "util/request", "modules/api"], function($, request) {
	var searchClass = {		
		
		/* 班级查询 */
		searchClass: function() {

			$(".search-btn").bind("click", function() {
				console.log(123);
				if ($(".class-detail").css("display") == "none") {
					$(".class-detail").show();

					request.get(
						_api.searchClass + $(".class-code").val(),
						{},
						function(data) {
							var result = JSON.parse(data);
							console.log(data);
							var searchClassTpl = $("#search-class-tpl").html;
							$(".class-detail").html(searchClassTpl(data.data));
						}
					);
				} else {
					$(".class-detail").hide();
				}
				
			});
		}
		
	};

	return searchClass.searchClass;
});
