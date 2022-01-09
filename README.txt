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
													--				View : user.post.add		
												--				Usercontroller->createpost();	
										--	--	
									--							View : user.post.edit
-								--							Usercontroller->editpost();										--								Usercontroller->managecom();		
						--								
					--										View : user.edit														Usercontroller->edituser();
				--									
			--									    
																			
		View : admin.home
	Admincontroller->home();

				--						
					--
						--					View : admin.category.add
							--				Admincontroller->createcategory();
								--						
										View : admin.category.edit
										Admincontroller->editcategory();
														
									View? : admin.category.delete
									Admincontroller->deletecategory();

								View : admin.user.manage
								Admincontroller->validuser();
								Admincontroller->deleteuser();

							View : admin.post
							Admincontroller->deleteCom();
							Admincontroller->deletepost();