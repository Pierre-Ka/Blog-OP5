En + = mail() failed to connect to mailserver at 'localhost' port 25. verify your SMTP and 'smtp_port' settings in php.ini or use ini_set() in HomeCOntroller on line 39.

En + = correction de la fonction GetValidComment qui est très moche
En + = Note SymfonyInsight : 22/100 % ??

Important rdv : comment demarrer un projet avec symfony 

Important : Vous vous assurerez qu’il n’y a pas de failles de sécurité (XSS, CSRF, SQL Injection, session hijacking, upload possible de script PHP…).

NEXT - SOUTENANCE

/*
OPTION = aléatoirement le chargement d'image nouvellement ajoutée se s'éffectue pas à cause de la mise en cache de l'image ( need to force refresh )
OPTION = aléatoirement le telechargement d'image via resizeimage n'a pas le rendu escompté
OPTION = reecriture des classes controller de manière plus coherente ( postcontroller, categorycontroller, usercontroller, commentcontroller) 
*/

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

