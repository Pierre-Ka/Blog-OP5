<?php

$title = 'Manage users';

ob_start(); ?>

<?php if (isset($message)): ?>
	<div class="alert alert-success">
		<?= $message; ?>
	</div>
<?php endif; ?>

<h1> Administrer les utilisateurs</h1>

<p> 
	<a href="index.php?p=admin.home" class="btn btn-success">Interface d'administration</a>
</p>

<table class="table">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nom</td>
			<td>Email</td>
			<td>Date de création du compte</td>
			<td>Description</td>
			<td>Valider l'utilisateur</td>
			<td>Supprimer l'utilisateur</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?= $user->getId(); ?></td>
				<td><?= $user->getName(); ?></td>
				<td><?= $user->getEmail(); ?></td>
				<td><?= $user->getInscription_date(); ?></td>
				<td><?= $user->getDescription(); ?></td>
				<td>
					<?php if($user->getIs_valid()=== 0) : ?>
						<button type="submit" class="btn btn-light">
						<a href="index.php?p=admin.manage_user&valid=<?= $user->getId(); ?>">Valider</a>
					</button>

					<?php endif ; ?>
				</td>
				<td>
					<form method="post">
						<input type="hidden" name="admin_user_delete" value="<?= $user->getId(); ?>"/>
						<button type="submit" class="btn btn-danger">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>


<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');