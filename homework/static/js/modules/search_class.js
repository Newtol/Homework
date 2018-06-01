define(["lib/jquery", "util/request", "modules/api"], function($, request) {
	var searchClass = {		
		
		/* 班级查询 */
		searchClass: function(role) {

			$(".close-search").bind("click", function() {
				$(this).hide();
				$(".search-btn").show();
				$(".teacher-info").hide();
				$(".class-detail").hide();
			});
			$(".search-btn").bind("click", function() {
				
				if ($(".class-detail").css("display") == "none") {

					$(this).hide();
					$(".close-search").show();
					request.get(
						_api.searchClass + $(".class-code").val(),
						{},
						function(data) {

							var result = $.parseJSON(data);	
							console.log(result);						
							var searchClassTpl = Handlebars.compile($("#search-class-tpl").html());
							$(".class-detail").html(searchClassTpl(result.data));
							
							/* 加入班级 */
							$("#add-class").bind("click", function() {
								if (role == 1) {
									$(".teacher-info").show();
									
								} else if (role == 2) {
									request.post(
										_api.joinApply,
										{
											"cid": $(".class-code").val(),
											"sirorstu": "stu"
										},
										function(data) {
											var result = $.parseJSON(data);
											if (result.message == "succssfully") {
												alert("加入班级成功！");
											}
											console.log(result.message);						
											$(".class-detail").hide();
											$(".search-btn").show();
											$(".close-search").hide();
											
										}
									);
								}
								
							});

							/* 填写信息，确认加入 */
							$("#sure-add").bind("click", function() {
								
								request.post(
									_api.joinApply,
									{
										"cid": $(".class-code").val(),
										"sirorstu": "sir",
								        "course": $(".join-classname").val(),
								        "total": $(".join-totlascore").val(),
								        "addtion": $(".join-addition").val()
									},
									function(data) {
										var result = $.parseJSON(data);
										console.log(result.message);
										if (result.message == "succssfully") {
											alert("加入班级成功！");
										}										
										$(".teacher-info").hide();
										$(".class-detail").hide();
										$(".search-btn").show();
										$(".close-search").hide();
									}
								);
							});
						}
					);
					$(".class-detail").show();
				} else {
					$(".class-detail").hide();
				}
				
			});
		}
		
	};

	return searchClass.searchClass;
});
