													<!-- add task popup start -->
													<div class="modal fade customscroll" id="task-add" tabindex="-1" role="dialog">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLongTitle">Tasks Add</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Close Modal">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body pd-0">
																	<div class="task-list-form">
																		<ul>
																			<li>
																				<form method="post">
																					<div class="form-group row">
																						<label class="col-md-4">Task Name</label>
																						<div class="col-md-8">
																							<input type="text" name="name" class="form-control" required="">
																						</div>
																					</div>
																					<div class="form-group row">
																						<label class="col-md-4">Task Reward</label>
																						<div class="col-md-8">
																							<input type="number" name="amt" class="form-control" required="">
																						</div>
																					</div>
																					<div class="form-group row">
																						<label class="col-md-4">Task Message</label>
																						<div class="col-md-8">
																							<textarea class="form-control" name="msg" required=""></textarea>
																						</div>
																					</div>
																					<div class="form-group row">
																						<label class="col-md-4">Task Time</label>
																						<div class="col-md-8">
																							<input type="text" name="time" class="form-control" placeholder="09:00am - 09:15am" required="">
																						</div>
																					</div>
																					<div class="form-group row mb-0">
																						<label class="col-md-4">Due Date</label>
																						<div class="col-md-8">
																							<input type="text" name="date" class="form-control date-picker" required="">
																						</div>
																					</div>
																					
																					<div class="modal-footer">
																	<button type="submit" name="admin_task" class="btn btn-primary">Add</button>
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																</div>
																				</form>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- add task popup End -->