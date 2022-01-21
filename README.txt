Suite : 
22 janvier-30 janvier

1 - Supprimer les commentaires lors de la suppression de post
2 - bdd tous les noms au singulier
3 - Creation des classes controllers : gerer la presence des managers dans les views
4 - Renommer tous les fichiers (view : template, index dans public, var/media )

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

