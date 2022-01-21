Suite : 
1 Journée : 22 janvier

1 - Supprimer les commentaires lors de la suppression de post

2 - Creation des classes controllers :
	- appel des post/comment/../_manager dans les controllers en fonction des besoins
	- renommer les post/comment/../_manager + les classes + les fichiers
3 - Autoloader composer + namespaces App/Entity, App/Manager, App/Controller
4 - Renommer tous les fichiers ( model : src, view : template, index dans public, var/media )
5 - bdd tous les noms au singulier

1 semaine : 30 janvier 

6 - verifier l'absence de connection si pas de session
7 - erreurs et message erreurs
8 - image_resize - toutes les images
9 - lire twig
10 - faire le design
11 - reecriture des liens




Le domaine home est de visibilité public : 
Le domaine user est l'espace membre : 
Le domaine admin reservé aux admins.


									View : home.sign_in
								Postcontroller->signin();
								Postcontroller->signup();
									--				  --
ARRIVEE SUR LE SITE :			--						 --
	View : home.home		--								--
Postcontroller->home();											--
			--				--										--
					--			--										--
			--						--	View : home.single					--			
						 --    		Postcontroller->single();					--
			--																		--
							--															--
			--						View : home.post 								--
								Postcontroller->post();							--
	View : home.category													--
Postcontroller->category();												--
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

