
<?php if( is_array($result_msg) ): ?>
	<div class="row">
		<div class="col-md-12">
			<?php if( $result_msg['status']=='success' ): ?>
				<div class="alert alert-success alert-dismissable">
					<i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?=$result_msg['msg']?>
				</div>
			<?php else: ?>
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?=$result_msg['msg']?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<?php echo form_open('account/events/create') ?>
	<div class="row">
			<!-- LEFT COLUMN -->
			<div class="col-md-8">
					<!-- EVENT TITLE -->
					<div class="box box-warning">
						<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_create_events')?></h3></div>
						<div class="box-body">
								<div class="form-group">
									<label><?=$this->lang->line('lbl_event_title')?></label>
									<input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>" maxlength="150">
									<?=form_error('title', '<p class="error">', '</p>') ?>
								</div>
						</div>
					</div>
					<!-- EVENT DESCRIPTION -->
					<div class='box'>
							<div class='box-header'>
								<h3 class='box-title'><small><?=$this->lang->line('lbl_event_description')?></small></h3>
								<div class="pull-right box-tools">
										<button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" onclick="return false;"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class='box-body pad'>
								<textarea class="textarea" name="description" value="<?php echo set_value('description');?>" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<input type="submit" class="btn btn-success btn-block " value="Save">
						</div>
					</div>
			</div>
			<!-- RIGHT COLUMN -->
			<div class="col-md-4">
					<!-- EVENT DETAILS -->
					<!-- ********************************
								* EVENT CATEGORY
								* MAX NO. OF PARTICIPANTS
								* LOCATION
								* DATE
							 *********************************
					-->
					<div class="box box-primary">
						<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_event_details')?></h3></div>
						<div class="box-body">
								<div class="form-group">
									<label><?=$this->lang->line('lbl_event_category')?></label>
									<select class="form-control" name="category">
										<?php foreach ($events_category as $category): ?>
											<?= create_tag('option', $category['category_name'], array('value'=>$category['category_id'])) ?>
										<?php endforeach ?>
									</select>
								</div>

								<div class="form-group">
									<label><?=$this->lang->line('lbl_location')?></label>
									<input type="text" class="form-control" placeholder="" name="location" value="<?php echo set_value('location');?>">
									<?=form_error('location', '<p class="error">', '</p>') ?>
								</div>

								<div class="form-group">
									<label><?=$this->lang->line('lbl_max_participants')?></label>
									<input type="text" class="form-control" placeholder="" name="max_participants" value="0">
								</div>

								<div class="form-group">
									<label>Event date</label>
									<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
										<input type="text" class="form-control pull-right" name="event_date" id="reservation">
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">01</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">45</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
											<div class="form-group">
												<label>Start time</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
													<input type="text" class="form-control timepicker" name="time_start">
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">01</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">45</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
											<div class="form-group">
												<label>End time</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
													<input type="text" class="form-control timepicker" name="time_end">
												</div>
											</div>
										</div>
									</div>
								</div>

						</div>
					</div>

					<div class="box box-success collapsed-box">
						<div class="box-header">
							<h3 class="box-title"><?=$this->lang->line('lbl_payment_details')?></h3>
							<div class="pull-right box-tools">
									<button class="btn btn-success btn-sm" data-widget='collapse' data-toggle="tooltip" onclick="return false;">FREE <i class="fa fa-check"></i></button>
							</div>
						</div>

						<div class="box-body" style="display: none;">
							<div class="form-group">
									<label>Amount</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="0" name="amount" style="text-align: right;">
										<div class="input-group-addon">.00</div>
									</div>
							</div>

						</div>
					</div>

			</div>
	</div>
<?php echo form_close(); ?>



