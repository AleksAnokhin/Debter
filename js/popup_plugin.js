// JavaScript Document
$(document).ready(function () {
	(function ($) {
		$.fn.popUpPlugIn = function (obj) {
			if (obj == undefined || arguments.length == 0) {
				obj = {};
			}
			if (obj.width == undefined) {
				obj.width = 510;
			}
			this.on("click", {
				width: obj.width
			}, fPopUp);
			let overLay = $("<div id='overlay'></div>")
				.css({
					position: "fixed",
					opacity: 0.1,
					backgroundColor: 'lightgray',
					display: "none",
					zIndex: 5,
					top: 0,
					left: 0,
					width: "100%",
					height: "100%"
				});
			let modal = $("<div id='modal' class='col-md-3'>"
			+ "<h4>Форма авторизации<i id='exit' class='fas fa-times'></i>"
			+ "</h4><form method='post' action='index.php?route=auth/check'>"
  			+ "<div class='form-group row'><label for='login' class='col-sm-2 col-form-label'>Логин</label>"
    		+ "<div class='col-sm-10'><input type='text' name='login' class='form-control' id='login' placeholder='Логин'></div></div>"
  			+ "<div class='form-group row'><label for='password' class='col-sm-2 col-form-label'>Пароль</label>"
    		+ "<div class='col-sm-10'><input type='password' name='password' class='form-control' id='password' placeholder='Пароль'>"
    		+ "</div></div><button type='submit' class='btn btn-primary'>Войти</button></form></div>");
			modal.css({
				backgroundColor: "black",
				display: "none",
				color:"white",
				borderRadius:5  + "px",
				opacity: 0,
				position: "fixed",
				zIndex : 10,
				padding: 20 + "px"
			
			});
			modal.find(".fas").css({float : "right",cursor: "pointer"});
			modal.find("#exit").on("click", fClose);
			
			function fPopUp(e){
			$("body").append(overLay).append(modal);
				let ww = $(window).width();
			let wh = $(window).height();
			let mw = modal.width() + 40;
			let mh = modal.height() + 40;
			let x = (ww - mw) / 2;
			let y = (wh - mh) / 4;
			modal.css({left: x + "px", top: y + "px"});
			overLay.css({display: "block"}).animate({opacity : 0.5}, 200, function(){
				modal.css({display :"block"}).animate({opacity : 1}, 200)
			});
			}
			
			function fClose(){
				modal.animate({opacity: 0}, 500, function(){
					modal.css({display: "none"}).detach();
					overLay.animate({opacity: 0}, 500, function(){
						$(this).css({display: "none"}).detach();
					});
				})
			}
		}
	})(jQuery);
})
