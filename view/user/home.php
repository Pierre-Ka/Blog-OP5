<?php

$title = 'Interface utilisateur';

ob_start(); ?>

<h1> Administrer les articles</h1>

<p> 
	<a href="index.php?p=user.post.add" class="btn btn-success">Ajouter</a>
</p>

<p> 
	<a href="index.php?p=user.edit" class="btn btn-success">Editer mon profil</a>
</p>

<p> 
	<a href="index.php?disconnect" class="btn btn-success">Me deconnecter</a>
</p>

<p> 
	<a href="index.php?p=admin.home" class="btn btn-success">Connexion en tant qu'administrateur</a>
</p>


<table class="table">
	<thead>
		<tr>
			<td>ID</td>
			<td>Titre</td>
			<td>Categorie</td>
			<td>Dernière modification</td>
			<td>Commentaire à valider</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $post):?>
			<tr>
				<td><?= $post->getId(); ?></td>
				<td><?= $post->getTitle(); ?></td>
				<td><?= $post->getCategory(); ?></td>
				<?php 
					if (($post->getLast_update())===null)
					{
					$date=($post->getCreate_date()) . ' (creation)';
					}
					else 
					{
					$date =($post->getLast_update());
					}
				?>
				<td><?= $date ?></td>
				<td><?= $post->getCommentNotYetValid(); ?></td>
				<td><a class="btn btn-primary" href="index.php?p=user.post.edit&id=<?= $post->getId(); ?>">Editer</a>
					<form method="post">
						<input type="hidden" name="id_delete" value="<?= $post->getId(); ?>"/>
						<button type="submit" class="btn btn-danger">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>


<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');
