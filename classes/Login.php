<?php 

require_once "DB.php";

class Login extends DB{
	private $username;
	private $password;

	public function setUserName($username){
		$this->username = $username;
	}

	public function getUserName(){
		return $this->username;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getPassword(){
		return $this->password;
	}

	public function validaUsuario(){

		$q = static::$pdo->prepare("SELECT user_name,user_pass FROM user WHERE user_name = ? AND user_pass = ? LIMIT 1");
		$q->bindParam(1, $this->username );
		$q->bindParam(2, $this->password );

		$res = $q->execute();

		if( $q->rowCount() === 1):
			$_SESSION['logado'] = true;
			$_SESSION['user'] = $this->username;

			header('Location: principal.php');
		else:
			echo "<script>alert('Erro. Usuário e/ou senha incorretos.');</script>";

		endif;
	}

	public function rememberUserData(){
		echo "enviando email de confirmação!";
	}

	public function logout(){
		unset($_SESSION['logado']);
		header('Location: index.php');
	}
}