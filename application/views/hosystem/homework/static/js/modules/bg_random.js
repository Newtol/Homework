define(['lib/jquery'], function($) {
	var bgRandom = {		
		
		/* 图片随机 */
		bgRandom: function() {
			var imgs = $(".task-wraper figure img"),
				imgLen = imgs.length;
			
			for (var i = 0; i < imgLen; i ++) {
				randomNum = parseInt(Math.random() * 30 + 1, 10);
				imgs.eq(i).attr("src", "../img/" + randomNum + ".jpg");
			}
		}
		
	};

	return bgRandom.bgRandom;
});
