Suite : 
22 janvier-30 janvier

1 - Debugage general
2 - Changement : pour l'edition d'article il n'y a plus qu'un seul formulaire : il faut 		donc adapter le controller en fonction 

3 - erreurs et message erreurs
4 - bug : edit profil :: le mot de passe change sans qu'on le souhaite
5 - bug : la partie administrative est ouverte a tous les membres
6 - bug : il me charge l'else lorsque les id sont incorrecte (sign_in.twig)
6 - image_resize - toutes les images
7 - reecriture des liens
8 -  Validez la qualité du code via SymfonyInsight ou Codacy.

9- option - reecriture des classes controller de manière plus coherente ( postcontroller, categorycontroller, usercontroller, commentcontroller) 



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

