

									View : home.sign_in
								Postcontroller->signin();
								Postcontroller->signup();
									--				  --
								--						 --
	View : home.home		--								--
Postcontroller->home();											--
			--				--										--
					--			--										--
			--						--	View : home.single					--			
						 --    		Postcontroller->single();						--
			--																		--
							--															--
			--						View : home.post 								--
								Postcontroller->post();						--
	View : home.category													--
Postcontroller->category();												--
																View : user.home
															Usercontroller->home();
														--
													--							View : user.post.create		
												--							Usercontroller->createpost();
																				View : user.post.edit
											--								Usercontroller->editpost();
																				View : user.com.edit
										--									Usercontroller->validcom();
																				View : user.edit
									--									    Usercontroller->edituser();
								--											
								View : admin.home
							Admincontroller->home();

														View : admin.category.create
													Admincontroller->createCategory();
														View : admin.category.edit
													Admincontroller->editCategory();
														View? : admin.category.delete
													Admincontroller->deleteCategory();

														View : admin.user.manage
													Admincontroller->validUser();
													Admincontroller->deleteUser();

														View : admin.post
													Admincontroller->deleteCom();
													Admincontroller->deletepost();