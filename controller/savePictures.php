<?php
	if (isset($_FILES['pictureChange']) AND $_FILES['pictureChange']['error'] == 0)
	{
        if ($_FILES['pictureChange']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['pictureChange']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                	move_uploaded_file($_FILES['pictureChange']['tmp_name'], 'assets/media/photo/IMG' . $id.'.'.$extension_upload);
                	/*$pictureChange = $_FILES['pictureChange'];
                	$source = imagecreatefromjpeg($pictureChange); // La photo est la source
					$destination = imagecreatetruecolor(450, 450); // On crée la miniature vide

					// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
					$largeur_source = imagesx($source);
					$hauteur_source = imagesy($source);
					$largeur_destination = imagesx($destination);
					$hauteur_destination = imagesy($destination);

					// On crée la miniature
					imagecopyresampled($destination, $source, 22, 22, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

						// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
						imagejpeg($destination, 'IMG' . $id);

                        // On peut valider le fichier et le stocker définitivement
                         move_uploaded_file('IMG' . $id, 'assets/media/photo/IMG' . $id.'.'.$extension_upload);*/
                        move_uploaded_file($_FILES['pictureChange']['tmp_name'], 'assets/media/photo/IMG' . $id.'.'.$extension_upload);

                        //ON VA NOTER DANS LA BDD LE NOM DE L'IMAGE
                       /*
                        $req = $bdd->prepare('UPDATE users SET picture = :picture WHERE id = :id');
						$req->execute(array(													      'id' => $id,															  'picture' => 'IMG' . $ID
								)) ;*/
                //}
        }
    }
}
