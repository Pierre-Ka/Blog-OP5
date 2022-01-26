<?php

$title = 'Manage categories';

ob_start(); 
?>
<h1> Administrer les categories</h1>

<p> 
	<a href="index.php?p=admin.home" class="btn btn-success">Interface d'administration</a>
</p>

<table class="table">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nom</td>
			<td>Editer</td>
			<td>Supprimer</td>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($categories as $categorie):?>
			<tr>
				<td>
					<?= $categorie->getId(); ?>
				</td>
				<td>
					<?= $categorie->getName(); ?>
				</td>

				<td>
					<form method="post" action="index.php?p=admin.manage_category&id=<?= $categorie->getId(); ?>">
						<input type="text" name="categoryEdit"/>
						<input class="btn btn-primary" type="submit"/>
					</form>

				</td>
				

				<td>

					<form method="post">
						<input type="hidden" name="admin_category_delete" value="<?= $categorie->getId(); ?>"/>
						<button type="submit" class="btn btn-danger">Supprimer la categorie</button>
					</form> 
	
				</td>
			</tr>
		<?php endforeach ; ?>
		<tr>
			<td></td>
			<td>Creer une nouvelle categorie
			<form method="post">
						<input type="text" name="categoryCreate"/>
						<input class="btn btn-primary" type="submit" value="Creer"/>
			</form></td>
			<td></td>
			<td></td>
		</tr>


	</tbody>
</table>



<?php $content=ob_get_clean(); 
require('../template/basic/basic_template.php');