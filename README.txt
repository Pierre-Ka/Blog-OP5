Suite : 
22 janvier-30 janvier

1 - erreurs et message erreurs
2 - bug : edit profil :: le mot de passe change sans qu'on le souhaite
3 - bug : la partie administrative est ouverte a tous les membres
3 - Renommer tous les fichiers (view : template, index dans public, var/media )
5 - image_resize - toutes les images
6 - lire twig
7 - faire le design
8 - reecriture des liens

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

