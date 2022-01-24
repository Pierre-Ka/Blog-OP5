Suite : 
22 janvier-30 janvier

1 - erreurs et message erreurs
2 - Creation des classes controllers : gerer la presence des managers dans les views
3 - Renommer tous les fichiers (view : template, index dans public, var/media )
4 - verifier l'absence de connection si pas de session
5 - image_resize - toutes les images
6 - lire twig
7 - faire le design
8 - reecriture des liens

9- option : creer des classes exceptions : class EmailSendingErrorException extends RuntimeException
{ public $message = 'Impossible d\'envoyer l\'email.'; }
class NotificationSendingErrorException extends RuntimeException
{ public $message = 'Impossible d\'envoyer la notification.'; }
class ShortTextException extends RuntimeException
{ public $message = 'Le texte fourni est trop court.'; }....  puis creer les Else : 
function sendEmail(string $text): bool // Si sendEmail retourne false =>Exception
{ if (/*envoie du message échoue*/)
{ throw new EmailSendingErrorException(); } return true; } // Exception envoyée = arret du script

UrlRewritting quand RewriteEngine on : Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
Please contact the server administrator at you@example.com to inform them of the time this error occurred, and the actions you performed just before this error.
More information about this error may be available in the server error log.


Le domaine home est de visibilité public : 
Le domaine user est l'espace membre : 
Le domaine admin reservé aux admins.


									View : home.sign_in
								Homecontroller->signin();
								Homecontroller->signup();
									--				  --
ARRIVEE SUR LE SITE :			--						 --
	View : home.home		--								--
Homecontroller->home();											--
			--				--										--
					--			--										--
			--						--	View : home.single					--			
						 --    		Homecontroller->single();					--
			--																		--
							--															--
			--						View : home.post 								--
								Homecontroller->post();							--
	View : home.category													--
Homecontroller->category();												--
																View : user.home
															Usercontroller->home();
														--
													--		--		View : user.post.add		
												--				Usercontroller->createpost();	
										--	--		--
									--					--		View : user.post.edit
-								--					--		Usercontroller->editpost();										--					--			Usercontroller->managecom();		
						--							--	
					--										View : user.edit														Usercontroller->edituser();
				--									
			--									    
																			
		View : admin.home
	Admincontroller->home();
	Admincontroller->deletepost();

				--						
					--
						--					View : admin.manage_category
							--				Admincontroller->createcategory();
								--		Admincontroller->editcategory();			
							--		Admincontroller->deletecategory();
						--				
							--
								View : admin.user.manage
								Admincontroller->validuser();
								Admincontroller->deleteuser();

