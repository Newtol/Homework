/**
 * login
 * @author: su
 **/
require.config({
  baseUrl: "/homework/static/js/"
});

require(["lib/jquery", "util/request", "modules/api", "lib/handlebars"], function($, request) {
  
  var index = {
    init: function() {
      var _this = index;
      _this.showBox();
      _this.font();
      _this.sign();
      _this.login();
      
    },
    

    /* 切换 */
    showBox: function() {
      $("#change-sign").bind("click", function() {

        $(".main-login").addClass("hide-box");
        $(".main-sign").removeClass("hide-box");
      });

      $("#change-login").bind("click", function() {

        $(".main-sign").addClass("hide-box");
        $(".main-login").removeClass("hide-box");
      });
    },

    /* 注册 */
    sign: function() {
      $("#sign-btn").bind("click", function() {        
       
        request.post(
          _api.register,
          {
            "sirstu": $("#reg-identy input:checked").val(),
            "username": $(".reg-username").val(),
            "realname": $(".reg-realname").val(),
            "password": $(".reg-psd").val(),
            "introduce": $(".reg-intro").val(),
            "gender": $("#reg-gender input:checked").val()
          },
          function(data) {
            var result = JSON.parse(data);
            alert(result.message);
          }
        );
      });
    },

    /* 登录 */
    login: function() {
      $("#login-btn").bind("click", function() {
        
        request.post(
          _api.login,
          {
            sirstu: $("#login-identy input:checked").val(),
            username: $(".login-username").val(),
            password: $(".login-psd").val(),
          },
          function(data) {
            console.log(data);            
          }
        );
      });
    },

    font: function() {
 
      $youzikuapi.asyncLoad("http://api.youziku.com/webfont/FastJS/yzk_659F988CEE067E8F", function () { 
        $youziku.load(".login-title", "fd9c020a6b524e22aa53b43c9e442a40", "minijiancaiyun"); 
        $youziku.draw();  
      }) 
    }
   

    
  };

  index.init();

  
});
