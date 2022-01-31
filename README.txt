Suite : 
28 janvier-31 janvier

First : reecriture du texte-contenu : version finale

En + = Reecriture des liens depuis le dossier racine et non plus depuis public/
En + = correction de la fonction GetValidComment qui est très moche
En + = lors de l'edition d'articles ; la categorie par défault est toujours la première et non celle définie
En + = aléatoirement le chargement d'image nouvellement ajoutée se s'éffectue pas à cause de la mise en cache de l'image ( need to force refresh )
En + = travailler sur les images

NEXT -  Validez la qualité du code via SymfonyInsight ou Codacy.
NEXT - media queries passer le site au test

OPTION - reecriture des classes controller de manière plus coherente ( postcontroller, categorycontroller, usercontroller, commentcontroller) 
OPTION - mail() failed to connect to mailserver at 'localhost' port 25. verify your SMTP and 'smtp_port' settings in php.ini or use ini_set() in HomeCOntroller on line 39.

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

