<?php
	// require_once "classes/Album.php";
	// require_once "classes/Login.php";

	function __autoload($classes){
		require_once "classes/{$classes}.php";
	}

	$album = new Album();
	$log = new Login();

	session_start();
	if( !isset($_SESSION['logado']) ):
		header('Location: index.php');
	endif;

	if( isset( $_GET['logout'] ) ){
		$log->logout();
	}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
	<section class="left">
		<ul>
			<li><a href="?insertNewAlbum">Inserir novo Álbum</a></li>
		</ul>		
	</section>

	<section class="right">
		<section class="top-itens">
			<a href="?logout">Logout</a>
		</section>
		<h2>Bem vindo <?= $_SESSION['user'];?></h2>
			<h4>Todos os Álbuns:</h4>
			<table>
				<?= $album->listarAlbuns(); ?>		
			</table>		
		<?php if( isset( $_GET['insertNewAlbum'] ) ): ?>
		<!-- Insere novo Álbum -->
			<div class="mask"></div>
			<div class="my-modal">
			<a href="principal.php" class="close">X</a>
			<h4>Inserir novo Álbum</h4>
			<form action="#" method="post" enctype="multipart/form-data">
				<label for="titulo">Título do Álbum</label>
				<input type="text" name="new_titulo" autofocus><br/>
				<label for="texto">Texto do Álbum</label>
				<textarea name="new_texto"></textarea>
				<label for="new_fotos">Logo do Álbum:</label>
				<input type="file" name="photo" size="25" />
				<input class="btn btn-primary" type="submit" name="submitNewAlbum" value="Inserir novo Álbum">
			</form>

			<?php 
				if( isset($_POST['submitNewAlbum']) ){
					if( isset( $_POST['new_titulo'] ) && isset( $_POST['new_texto'] ) && !empty( $_POST['new_titulo'] ) && !empty($_POST['new_texto']) ){
							
						$titulo = trim($_POST['new_titulo']);
						$texto = trim($_POST['new_texto']);

						$caminho = "assets/fotos/";
						$caminho = $caminho . basename( $_FILES['photo']['name']); 

						if(move_uploaded_file($_FILES['photo']['tmp_name'], $caminho)) {
							if( $album->insereNovoAlbum( $titulo,$texto, $caminho ) ){
								echo "<br/>Álbum inserido com Sucesso!<br/><br/><a href='index.php'>Voltar</a>";
							}else{
								echo "Houve um erro na inserção do Álbum";
							}
						} else{
							echo "Erro: Não foi possível fazer o Upload do logo do Álbum.<br>";
						}						

					}else{
						echo "Erro: Verifique os campos vazios.";
					} 
				}else{
					echo "<br><br><a href='principal.php'>Cancelar</a>";
				}
			?>
			</div>
			<!-- Fim insere novo Álbum -->
			
			<!-- Edita um Álbum existente -->
			<?php elseif( isset( $_GET['editAlbum'] ) ): ?>
				<?php
				#Editar...
				if( isset( $_GET['toEdit'] ) && !empty( $_GET['toEdit'] ) ): ?>	
					<div class="mask"></div>
					<div class="my-modal">
					<a href="principal.php" class="close">X</a>	
					<h2>Editando Álbum <?= $_GET['toEdit'] ?></h2>
					<?php $album->mostraFormToEdit( $_GET['toEdit'] ); ?>

					<?php 
						if ( isset( $_POST['edit_submit'] ) ):
							if( isset( $_FILES['edit_logo']['name'] ) && !empty($_FILES['edit_logo']['name']) && $_FILES['edit_logo']['name'] !== "" ){

								$caminho_edit = "assets/fotos/";
								$caminho_edit = $caminho_edit . basename( $_FILES['edit_logo']['name']); 

								if(move_uploaded_file($_FILES['edit_logo']['tmp_name'], $caminho_edit) || empty($_FILES['edit_logo']['name']) ) {
									if( $album->atualizaAlbum( $_GET['toEdit'],$_POST['edit_titulo'],$_POST['edit_texto'],$caminho_edit ) ){
										echo "Álbum atualizado com Sucesso!";
									}else{
										echo "Houve um erro na atualização do Álbum";
									}
								}else{
									echo "Erro: Não foi possível fazer o Upload do logo do Álbum.<br>";
								}	


							}else{
									if( $album->atualizaAlbum( $_GET['toEdit'],$_POST['edit_titulo'],$_POST['edit_texto'],"" ) ){
										echo "Álbum atualizado com Sucesso!";
									}else{
										echo "Houve um erro na atualização do Álbum";
									}
							}

						endif;?>
							</div>

						<?php

				#Excluir...
				elseif( isset( $_GET['toExclude'] ) && !empty( $_GET['toExclude'] ) ):
					echo "<script>window.onload = function(){var msg = confirm('Você tem certeza que deseja fazer isso?'); if(msg){window.location = 'classes/controllerExclude.php?toExclude=".$_GET['toExclude']."'} }</script>";
				endif;
			endif; ?>
			<!-- Fim Edita um Álbum existente -->
	</section>
<script src="assets/js/main.js"></script>
</body>
</html>

