<?php
if (isset($_FILES['pictureChange']))
		{
			$id = $_GET['id'];
			require('controller/savePictures.php');
		}