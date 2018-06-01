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
      _this.sign();
      _this.login();
      
    },    

    /* 切换 */
    showBox: function() {
      $("#change-sign").bind("click", function() {

        $(".content h1").addClass("small");
        $(".about-us").addClass("hide-us");
        $(".main-login").addClass("hide-box");
        $(".main-sign").removeClass("hide-box");       
      });

      $("#change-login").bind("click", function() {

        $(".main-sign").addClass("hide-box");
        $(".main-login").removeClass("hide-box");
        $(".content h1").removeClass("small");
         $(".about-us").removeClass("hide-us");
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
            if (result.message == "success") {
              alert("注册成功！");
              $("#change-login").click();
            }            
          }
        );
      });
    },

    /* 登录 */
    login: function() {
      $("#login-btn").bind("click", function() {
        var role = $("#login-identy input:checked").val();
        request.post(
          _api.login,
          {
            sirstu: $("#login-identy input:checked").val(),
            username: $(".login-username").val(),
            password: $(".login-psd").val(),
          },
          function(data) {
            console.log(data);
            var result = $.parseJSON(data);
            if (role == 1) {
              window.location.href = "teacher-course.html";
              sessionStorage.person = $(".login-username").val();
            } else {
              window.location.href = "stu-index.html";
              sessionStorage.person = $(".login-username").val();
            }
                      
          }
        );
      });
    }
  };

  index.init();
});
