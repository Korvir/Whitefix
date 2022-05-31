$(function () {
	"use strict";

	$(document).ready(function () {


		$('#start_button').click(function (event) {
			event.preventDefault();
			$('#popup').fadeIn(500).css({'display': 'block'});
		});

		$('.contact-button').click(function (event) {
			event.preventDefault();
			$('#popup').fadeIn(500).css({'display': 'block'});
		});

		$('.close').click(function (event) {
			event.preventDefault();
			$('#popup').fadeOut(500).css({'display': 'none'});
		});


		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function (event) {
			if (event.target == document.getElementById('popup')) {
				$('#popup').fadeOut(500).css({'display': 'none'});
			}
		}
		$('.phone_input').mask("+38(000)00-00-000", {placeholder: "+38(__)__-__-___"});


		$(".contact_form_submit").on("click", function (){
			let form = $(this).parents('.contact_form');

			validate(form);
		});

		function validate(form) {


			let result = form.find(".result"),
				name = form.find('.name_input').val(),
				phone = form.find('.phone_input').val();

			result.text("");

			// if(!validateEmail(email) || !name || !phone){
			if (!name || !phone || phone.length < 17) {
				if (!name) {
					result.text("Заповніть всі дані !");
					result.css("color", "#fff");
					result.css("font-weight", "800");
				}
				if (!phone || phone.length < 17) {
					result.html('');
					result.text("Не коректний номер !");
					result.css("color", "#fff");
					result.css("font-weight", "800");
				}
			} else {
				get_data(form);
			}
			return false;
		}


		function get_data(form) {


			$.ajax({
				url: jsVars.ajaxurl,
				data: {
					action: 'contactForm',
					form: form.serialize()
				},
				type: 'POST',
				beforeSend: function () {
					//
				},
				success(response) {
					if (response.success)
					{
						$('#popup_inputs').css({'display': 'none'});
						$('#popup-sucess').css({'display': 'block'});
						$('#popup_sucess').css({'display': 'block'}).fadeIn(2000);
						setTimeout('location.reload()', 3000);
					}
					else{
						form.find(".result").text(response.data.error);
					}
				},
				error: function (response) {
					console.log(response);
					form.find(".result").text(response.data.error);
				}

			});

		};

	});

});

