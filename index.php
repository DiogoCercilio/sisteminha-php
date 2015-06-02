<?php 
	require_once "classes/Login.php";
	session_start();
	$login = new Login();

	if( isset($_SESSION['logado']) ):
		header('Location: principal.php');
	endif;

	if( isset( $_POST['send_login'] ) ):
		$login->setUserName($_POST['username']);
		$login->setPassword($_POST['password']);
		$login->validaUsuario();
	endif;

	if( isset($_POST['remember_email']) && !empty($_POST['remember_email']) ){
		$login->rememberUserData();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
	<?php if( !isset($_GET['remember']) ):?>
		<form action="#" method="post" class="login-form">
			<h3>Login</h3>
			<input type="text" name="username" placeholder="Nome de Usuário"/>
			<input type="password" name="password" placeholder="Senha">
			<input name="send_login" type="submit" value="Entrar" class="btn btn-primary"/>
			<a href="?remember">Esqueci meu login e/ou senha</a>
		</form>
	<?php else: ?>
		<form action="#" method="post" class="login-form">
			<p>Informe seu e-mail. Nós lhe enviaremos um e-mail de confirmação para resetar sua senha.</p>
			<input type="email" name="remember_email" placeholder="E-mail"/>
			<input type="submit" value="Enviar" class="btn btn-primary"/>
			<a href="index.php">Voltar</a>
		</form>		
	<?php endif; ?>
</body>
</html>