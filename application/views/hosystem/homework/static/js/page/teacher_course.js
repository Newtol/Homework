/**
 *首页
 *@author: su
 **/
require.config({
	baseUrl: "/homework/static/js/"
});
require(["lib/jquery", "modules/bg_random", "modules/search_class", "lib/handlebars"], 
	function($, bgRandom, searchClass) {
	
	var index = {
		init: function() {
			var _this = index;
			searchClass();
			bgRandom();
		}
	};

	index.init();

	
});




