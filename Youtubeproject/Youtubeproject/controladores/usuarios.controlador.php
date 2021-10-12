<?php

	class ControladorUsuarios{

		static public function ctrEditarUsuario(){
			if(isset($_POST['editarUsuario'])){
				if(preg_match('/^[a-zA-Z0-9ñÑaáéÉíÍóÓúÚ ]+$/',$_POST['editarNombre'])){

						$ruta=$_POST['fotoActual'];
						if(isset($_FILES['editarFoto']['tmp_name'])&&!empty($_FILES['editarFoto']['tmp_name'])){

						list($ancho, $alto) = getimagesize($_FILES['editarFoto']['tmp_name']);
						$nuevoancho = 500;
						$nuevoalto = 500;

						//Crear directorio

						$directorio = "vistas/img/usuarios/".$_POST['editarUsuario'];
						//Si ya exiiste foto se debe eliminar

						if(!empty($_POST['fotoActual'])){
							unlink($_POST['fotoActual']);
						}else{
							mkdir($directorio,0755);
						}
						

						//De acuerdo al tipo de imagen se hace el proceso de recorte de la foto

						if($_FILES['editarFoto']['type']=="image/jpeg"){

							$aleatorio = mt_rand(100,999);
							$ruta = $directorio."/".$aleatorio.".jpg";
							$origen = imagecreatefromjpeg($_FILES['editarFoto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoancho, $nuevoalto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoancho, $nuevoalto, $ancho, $alto);
							imagejpeg($destino,$ruta);
						}
						if($_FILES['editarFoto']['type']=="image/png"){

							$aleatorio = mt_rand(100,999);
							$ruta = $directorio."/".$aleatorio.".png";
							$origen = imagecreatefrompng($_FILES['editarFoto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoancho, $nuevoalto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoancho, $nuevoalto, $ancho, $alto);
							imagepng($destino,$ruta);
						}

					}
					$tabla = "usuarios";
					if($_POST['editarPassword']!=""){
						if(preg_match('/^[a-zA-Z0-9]+$/',$_POST['editarPassword'])){
							$salt = md5($_POST['editarPassword']);
							$passwordEncriptado = crypt($_POST['editarPassword'],$salt);
						}else{
							echo"<script>
							Swal.fire({ 
								title: 'Error!',
								text: '¡No puedes usar caraceres especiales en el campo contraseña!',
								icon: 'error',
								confirmButtonText:'Ok'
								});
							</script>";
						}
						
					}else{
						$passwordEncriptado = $_POST['passwordActual'];
					}

					$datos = array("nombre"=>$_POST['editarNombre'],
									"usuario"=>$_POST['editarUsuario'],
									"password"=>$passwordEncriptado,
									"perfil"=>$_POST['editarPerfil'],
									"ruta"=>$ruta);

					$respuesta  = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
					if($respuesta=="ok"){
						echo"<script>
							Swal.fire({ 
								title: 'Success!',
								text: '¡El usuario ha sido actualizaddo correctamente!',
								icon: 'success',
								confirmButtonText:'Ok'
								}).then((result)=>{
									if(result.value){
										window.location = 'usuarios';
									}
								})
						</script>";
					}
				}else{
					echo"<script>
							Swal.fire({ 
								title: 'Error!',
								text: '¡No puedes usar caraceres especiales en el campo nombre!',
								icon: 'error',
								confirmButtonText:'Ok'
								})
						</script>";
				}
				}
		}

		

		static public function ctrCrearUsuario(){
			if(isset($_POST['nuevoUsuario'])){
				if(preg_match('/^[a-zA-Z0-9ñÑaáéÉíÍóÓúÚ ]+$/',$_POST['nuevoNombre'])&&
					preg_match('/^[a-zA-Z0-9]+$/',$_POST['nuevoUsuario'])&&
					preg_match('/^[a-zA-Z0-9]+$/',$_POST['nuevoPassword'])){

					$ruta="";
					if(isset($_FILES['nuevaFoto']['tmp_name'])){

						list($ancho, $alto) = getimagesize($_FILES['nuevaFoto']['tmp_name']);
						$nuevoancho = 500;
						$nuevoalto = 500;

						//Crear directorio

						$directorio = "vistas/img/usuarios/".$_POST['nuevoUsuario'];
						mkdir($directorio,0755);

						//De acuerdo al tipo de imagen se hace el proceso de recorte de la foto

						if($_FILES['nuevaFoto']['type']=="image/jpeg"){

							$aleatorio = mt_rand(100,999);
							$ruta = $directorio."/".$aleatorio.".jpg";
							$origen = imagecreatefromjpeg($_FILES['nuevaFoto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoancho, $nuevoalto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoancho, $nuevoalto, $ancho, $alto);
							imagejpeg($destino,$ruta);
						}
						if($_FILES['nuevaFoto']['type']=="image/png"){

							$aleatorio = mt_rand(100,999);
							$ruta = $directorio."/".$aleatorio.".png";
							$origen = imagecreatefrompng($_FILES['nuevaFoto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoancho, $nuevoalto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoancho, $nuevoalto, $ancho, $alto);
							imagepng($destino,$ruta);
						}

					}

					

					$tabla = "usuarios";
					$salt = md5($_POST['nuevoPassword']);
					$passwordEncriptado = crypt($_POST['nuevoPassword'],$salt);
					$datos = array("nombre"=>$_POST['nuevoNombre'],
									"usuario"=>$_POST['nuevoUsuario'],
									"password"=>$passwordEncriptado,
									"perfil"=>$_POST['nuevoPerfil'],
									"ruta"=>$ruta);

					$respuesta  = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
					if($respuesta=="ok"){
						echo"<script>
							Swal.fire({ 
								title: 'Success!',
								text: '¡Registro Exitoso!',
								icon: 'success',
								confirmButtonText:'Ok'
								}).then((result)=>{
									if(result.value){
										window.location = 'usuarios';
									}
								});
						</script>";
					}
				}else{
					echo"<script>
							Swal.fire({ 
								title: 'Error!',
								text: '¡No puedes usar caraceres especiales en el campo usuario ni en la contraseña!',
								icon: 'error',
								confirmButtonText:'Ok'
								});
						</script>";
				}
			}
		}


		static public function ctrIngreso(){
			if(isset($_POST['ingUsuario'])){
				if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingUsuario'])&&preg_match('/^[a-zA-Z0-9]+$/', $_POST['ingPassword'])){
					$tabla = "usuarios";
					$item = "usuario";
					$valor = $_POST['ingUsuario'];
					$salt = md5($_POST['ingPassword']);
					$passwordEncriptado = crypt($_POST['ingPassword'],$salt);
					$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
					if($respuesta['usuario']==$_POST['ingUsuario']&&$respuesta['password']==$passwordEncriptado){
								if($respuesta['estado']==1){
								$_SESSION['iniciarSesion']="ok";
								$_SESSION['nombre']=$respuesta['nombre'];
								$_SESSION['usuario']=$respuesta['usuario'];
								$_SESSION['foto']=$respuesta['foto'];
								$_SESSION['perfil']=$respuesta['perfil'];
						
								//Fecha de login
								date_default_timezone_set("America/Bogota");
								$fecha = date("y-m-d");
								$hora = date("H:i:s");
								$fechaActual = $fecha." ".$hora;
								$item1 = "ultimo_login";
								$valor1 = $fechaActual;
								$item2 = "id";
								$valor2 = $respuesta['id'];
								$actualizarLogin = ModeloUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);
								if($actualizarLogin=="ok"){
									echo '<script>
									window.location="inicio";
									</script>';
								}
								
								}else{
									echo("<div class='alert alert-danger'>Usuario inactivo, contacte al administrador del sistema</div>");
								}
					}else{
						echo("<div class='alert alert-danger'>Error al ingresar al sistema</div>");
					}
				}
			}
		}

		static public function ctrMostrarUsuarios($item,$valor){
			$tabla="usuarios";
			$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
			return $respuesta;
		}


		static public function ctrBorrarUsuario(){
			if(isset($_GET['idusuario'])){
				$tabla = "usuarios";
				$datos = $_GET['idusuario'];
				if($_GET['fotousuario']!=""){
					unlink($_GET['fotousuario']);
					rmdir("vistas/img/usuarios/".$_GET['usuario']);
				}
					$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla,$datos);
					if($respuesta=="ok"){
						echo"<script>
							Swal.fire({ 
								title: 'Success!',
								text: '¡El usuario ha sido actualizaddo correctamente!',
								icon: 'success',
								confirmButtonText:'Ok'
								}).then((result)=>{
									if(result.value){
										window.location = 'usuarios';
									}
								})
						</script>";
					}
				
			}
		}
	}