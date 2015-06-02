<?php 
require_once "DB.php";

# Métodos do Álbum
class Album extends DB{
	public $table;

	public function listarAlbuns(){
		$q = static::$pdo->query("SELECT * FROM album");
		if( !$q->rowCount() == "0"){
			while( $res = $q->fetch(PDO::FETCH_OBJ)){
				echo "<tr id='id-$res->id'><td><img src='$res->logo'/></td><td class='td-edit'><a class='edit' href='?editAlbum&toEdit=$res->id'><img src='http://4.bp.blogspot.com/-Xzl4Url1A_M/T6FbIXiMGvI/AAAAAAAAAFY/uWQazcjWfD4/s1600/editar.png'></a></td><td><a class='del-item' href='?editAlbum&toExclude=$res->id'><img src='http://www.media.today-bd.net/siteimages/delete.png'></a></td><td id='id-$res->id'>" . $res->id . "<td/>" . "<td>" . $res->titulo . "<td/>" ."<td>" . $res->texto . "<td/></tr>";
			}
		}else{
			echo "<tr><td>Nenhum Álbum encontrado<br/><br/><a href='?insertNewAlbum'>Criar um Álbum</a></td></tr>";
		}
	}

	public function insereNovoAlbum($titulo, $texto, $logo){
		$q = static::$pdo->prepare("INSERT INTO album(titulo, texto, logo) VALUES(?, ?, ?)");
		$q->bindParam(1,$titulo);
		$q->bindParam(2,$texto);
		$q->bindParam(3,$logo);
		$res = $q->execute();

		if( $res ){
			return true;
		}else{
			return false;
		}
	}

	public function excluiAlbum($id){
		$q = static::$pdo->prepare("DELETE FROM album WHERE id=?;");
		$q->bindParam(1,$id);
		$res = $q->execute();

		if( $res ){
			header("Location: http://" .$_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . "rm07" . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "index.php?editAlbum");
			return true;
		}else{
			return false;
		}
	}

	public function mostraFormToEdit($id){

		$q = static::$pdo->prepare("SELECT * FROM album WHERE id=?");
		$q->bindParam(1,$id);
		$q->execute();
		
			while( $res = $q->fetch(PDO::FETCH_OBJ)){
				echo "<script>document.querySelector('#id-$res->id').className = 'active';</script>" . 
				 "<form action='' method='post' enctype='multipart/form-data'>" . 
				 "<label for='edit_titulo'>Novo Título:</label>" . 
				 "<input type='text' name='edit_titulo' value='$res->titulo'>" . 
				 "<label for='edit_texto'>Novo Texto:</label>" . 
				 "<textarea name='edit_texto'>$res->texto</textarea>" . 
				 "<div class='preview-logo-img'>" . 
					 "<h4>Logo Atual:</h4>" . 
					 "<img src='$res->logo'>". 
				 "</div>" . 
				 "<div class='preview-logo-content'>" . 
					 "<label>Logo do Álbum:</label>" .
					 "<input class='btn btn-default' type='file' name='edit_logo' size='25' />" . 
				 "</div>" . 
				 "<input class='btn btn-primary' type='submit' name='edit_submit'>" . 
				 "</form>"; 
			}


	}

	public function atualizaAlbum($id,$titulo,$texto,$logo){

		if( !empty($logo) ){
			$q = static::$pdo->prepare("UPDATE album SET titulo=?,texto=?,logo=? WHERE id=?");
			$q->bindParam(1,$titulo);
			$q->bindParam(2,$texto);
			$q->bindParam(3,$logo);
			$q->bindParam(4,$id);			
			
		}else{
			$q = static::$pdo->prepare("UPDATE album SET titulo=?,texto=? WHERE id=?");
			$q->bindParam(1,$titulo);
			$q->bindParam(2,$texto);
			$q->bindParam(3,$id);
		}	
		
		$res = $q->execute();
		header("Location: index.php?editAlbum");

		if( $res ){
			return true;
		}else{
			return false;
		}		
	}
}	