$(document).ready(function () {
	$('.btn-sideBar-SubMenu').on('click', function (e) {
		e.preventDefault();
		var SubMenu = $(this).next('ul');
		var iconBtn = $(this).children('.zmdi-caret-down');
		if (SubMenu.hasClass('show-sideBar-SubMenu')) {
			iconBtn.removeClass('zmdi-hc-rotate-180');
			SubMenu.removeClass('show-sideBar-SubMenu');
		} else {
			iconBtn.addClass('zmdi-hc-rotate-180');
			SubMenu.addClass('show-sideBar-SubMenu');
		}
	});

	$('.btn-menu-dashboard').on('click', function (e) {
		e.preventDefault();
		var body = $('.dashboard-contentPage');
		var sidebar = $('.dashboard-sideBar');
		if (sidebar.css('pointer-events') == 'none') {
			body.removeClass('no-paddin-left');
			sidebar.removeClass('hide-sidebar').addClass('show-sidebar');
		} else {
			body.addClass('no-paddin-left');
			sidebar.addClass('hide-sidebar').removeClass('show-sidebar');
		}
	});

	
	$('.FormularioAjax').submit(function (e) {
		e.preventDefault();

		var form = $(this);

		var tipo = form.attr('data-form');
		var accion = form.attr('action');
		var metodo = form.attr('method');
		var respuesta = form.children('.RespuestaAjax');

		var msjError = "<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
		//Con esto hacemos un array de todos los datos que estamos enviando
		var formdata = new FormData(this);


		var textoAlerta;
		if (tipo === "insert") {
			textoAlerta = "Los datos se insertarán en la base de datos";
		} else if (tipo === "delete") {
			textoAlerta = "Los datos se eliminarán de la base de datos";
		} else if (tipo === "update") {
			textoAlerta = "Los datos, de la base de datos, serán actualizados";
		} else {
			textoAlerta = "Quieres realizar la operación solicitada";
		}


		swal({
			title: "¿Estás seguro?",
			text: textoAlerta,
			type: "question",
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(function () {
			$.ajax({
				type: metodo,
				url: accion,
				data: formdata ? formdata : form.serialize(),
				cache: false,
				contentType: false,
				processData: false,
				//esta función te muestra el % de carga a la hora de subir algún archivo
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);
							if (percentComplete < 100) {
								respuesta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: ' + percentComplete + '%;"></div></div>');
							} else {
								respuesta.html('<p class="text-center"></p>');
							}
						}
					}, false);
					return xhr;
				},
				success: function (data) {
					respuesta.html(data);
				},
				error: function () {
					respuesta.html(msjError);
				}
			});
			return false;
		});
	});

});
(function ($) {
	$(window).on("load", function () {
		$(".dashboard-sideBar-ct").mCustomScrollbar({
			theme: "light-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: {
				enable: true
			}
		});
		$(".dashboard-contentPage, .Notifications-body").mCustomScrollbar({
			theme: "dark-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: {
				enable: true
			}
		});
		$(".dashboard-contentRegistro").mCustomScrollbar({
			theme: "dark-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: {
				enable: true
			}
		});
	});
})(jQuery);