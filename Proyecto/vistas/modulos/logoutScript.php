<script>
$(document).ready(function(){
    $('.btn-exit-system').on('click', function (e) {
            e.preventDefault();
            //con esto recuperamos el token que están en el boton de cerrar sesión
            var token=$(this).attr('href');
            swal({
                title: '¿Seguro que quieres cerrar sesión?',
                text: "La sesión se cerrará",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#03A9F4',
                cancelButtonColor: '#F44336',
                confirmButtonText: '<i class="zmdi zmdi-run"></i> ¡Sí, quiero salir!',
                cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> ¡No, cancelar!'
            }).then(function () {
                $.ajax({
                    url:'<?php echo SERVERURL; ?>ajax/loginAjax.php?token='+token,
                    success:function(data){
                        if(data=="true"){
                            window.location.href="<?php echo SERVERURL; ?>login/";
                        }else{
                            swal(
                                "Hubo un error",
                                "No se ha podido cerrar la sesión",
                                "error"
                            );
                        }
                    }
                });
            });
        });
    });

</script>
