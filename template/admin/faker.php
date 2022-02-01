<?php

require_once '../../vendor/autoload.php';

 $fakeData = new BlogApp\Faker\FakeData() ;

/////////////////////////////////////////////////////////////////////////////
/////////// LA CREATION DE FAKE SE FAIT EN DECOMMENTANT LA LIGNE SOUHAITEE //////////////////////////////////////////////////////////////////////////////

 
/////////$fakeData->fakeComment(int $startNumber, int $endNumber, int $numberOfPost : void)
 
$message = $fakeData->fakeComment(1001, 1500);


////////////$fakeData->fakeUser(int $startNumber,int  $endNumber)
 
//$message = $fakeData->fakeUser();


/////////////$fakeData->fakePost(int $startNumber,int  $endNumber, int $lastUserId : void, int $lastCategoryId : void)

// $message = $fakeData->fakePost(1, 110);

if (!isset($message)) 
{
	$message = 'Aucun fake n\'a été généré' ; 
}

echo $message ; 
