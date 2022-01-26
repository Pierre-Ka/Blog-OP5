<?php

$title = 'Interface administrateur';

ob_start(); ?>

<?php if (isset($message)): ?>
	<div class="alert alert-success">
		<?= $message; ?>
	</div>
<?php endif; ?>

<h1> Administrer les utilisateurs et les categories</h1>

<p> 
	<a href="index.php?p=admin.manage_category" class="btn btn-success">Administrer les categories</a>
</p>

<p> 
	<a href="index.php?p=admin.manage_user" class="btn btn-success">Administrer les utilisateurs</a>
</p>

<p> 
	<a href="index.php?p=user.home" class="btn btn-success">Me deconnecter de l'administration</a>
</p>

<p> 
	<a href="index.php?disconnect" class="btn btn-success">Me deconnecter completement</a>
</p>

<h1> Supprimer des articles </h1>



<table class="table">
	<thead>
		<tr>
			<td>ID</td>
			<td>Titre</td>
			<td>Categorie</td>
			<td>Dernière modification</td>
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
				<td>
					<form method="post">
						<input type="hidden" name="admin_post_delete" value="<?= $post->getId(); ?>"/>
						<button type="submit" class="btn btn-danger">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p> 
	<a href="index.php?p=admin.home&faker=category" class="btn btn-success">Generer des fausses categories</a>
</p>
<p> 
	<a href="index.php?p=admin.home&faker=comment" class="btn btn-success">Generer des faux commentaires</a>
</p>
<p> 
	<a href="index.php?p=admin.home&faker=post" class="btn btn-success">Generer des faux posts</a>
</p>
<p> 
	<a href="index.php?p=admin.home&faker=user" class="btn btn-success">Generer de faux membres</a>
</p>




<?php $content=ob_get_clean(); 
require('../template/basic/basic_template.php');