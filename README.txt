Suite : 
28 janvier-31 janvier

1 - Debugage general : 
4 - bug : edit profil :: le mot de passe change sans qu'on le souhaite
5 - bug : la partie administrative est ouverte a tous les membres
2 - Changement : pour l'edition d'article il n'y a plus qu'un seul formulaire : il faut 		donc adapter le controller en fonction 
3 - Trouver une solution pour generer les miniatures ( widget )

En + = Reecriture des liens depuis le dossier racine et non plus depuis public/
En + = correction de la fonction GetValidComment qui est très moche

1 fevrier  - 3 fevrier

6 - image_resize - toutes les images
3 - erreurs et message erreurs et redirection 404
8 -  Validez la qualité du code via SymfonyInsight ou Codacy.

9- option - reecriture des classes controller de manière plus coherente ( postcontroller, categorycontroller, usercontroller, commentcontroller) 

10 - option - mail() failed to connect to mailserver at 'localhost' port 25. verify your SMTP and 'smtp_port' settings in php.ini or use ini_set() in HomeCOntroller on line 39.

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

