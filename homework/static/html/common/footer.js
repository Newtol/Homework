(function(){
	"use strict"
	var footerScript = document.getElementsByTagName('script'),
		path;
	for (var i = footerScript.length; i > 0; i--) {
	    path = footerScript[i-1].getAttribute('data-js');
		if (path != null) {
			break;	
		}
	}
	var footerTpl = function() {
		/*
		<div class="common-footer">
            
        </div>
		*/
	}
	var footer = footerTpl.toString().replace(/^[^\/]+\/\*!?/, '').replace(/\*\/[^\/]+$/, '') +
				'<script src="/js/lib/r.js" data-main="/js/page/' + path + '"></script>'+
			  '</div></body></html>';
	document.write(footer);

})();