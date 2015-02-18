
<?php if( isset($result) ): ?>
	<?php echo form_open('events_ajax/edit/') ?>
	<input  type="text" class="form-control hide" name="event_id" value="<?php if(isset($result)){ echo $result->event_id; } ?>">
	<textarea class="hide" id="description_mirror" name="description_mirror">
		<?php if( isset($result_desc) && count($result_desc) > 0 ): ?>
			<?php foreach ($result_desc as $description): ?>
				<?=$description->description ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</textarea>
<?php else: ?>
	<?php echo form_open('events_ajax/create') ?>
<?php endif; ?>
<div class="row">
	<div class="error_message"></div>
	<!-- LEFT COLUMN -->
	<div class="col-md-8">
		<!-- EVENT TITLE -->
		<div class="box box-warning">
			<div class="box-header">
				<h3 class="box-title">
					<?php if( isset($result) ): ?>
						<?=$this->lang->line('lbl_edit_events')?>
					<?php else: ?>
						<?=$this->lang->line('lbl_create_events')?>
					<?php endif; ?>
				</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label><?=$this->lang->line('lbl_event_title')?></label>
					<input type="text" class="form-control" name="title" value="<?php if(isset($result)){ echo $result->title; } ?>" maxlength="150">
					<p class="error"></p>
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
				<textarea class="textarea" id="description" name="description" value="" placeholder="Place some text here" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<input type="submit" class="btn btn-success btn-block " value="Save">
			</div>
		</div>
	</div><!--//END col-md-8 -->
	<!-- RIGHT COLUMN -->
	<div class="col-md-4">
		<!-- EVENT DETAILS -->
		<!-- ********************************
					* EVENT CATEGORY
					* MAX NO. OF PARTICIPANTS
					* LOCATION
					* DATE
					* TIME
				 *********************************
		-->
		<?php if( isset($result) ): ?>
		<div class="box box-success">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_event_status')?></h3></div>
			<div class="box-body">
				<div class="form-group">
					<label>
						<input type="radio" name="status" class="minimal" value="close" <?php if( $result->status == "close"){ echo 'checked'; } ?>/>
						Close
					</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>
						<input type="radio" name="status" class="minimal" value="open" <?php if( $result->status == "open"){ echo 'checked'; } ?>/>
						Open
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="box box-primary">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_event_details')?></h3></div>
			<div class="box-body">
				<div class="form-group">
					<label><?=$this->lang->line('lbl_event_category')?></label>
					<select class="form-control" name="category">
						<?php foreach ($events_category as $category): ?>
							<?php if( isset( $selected ) && $category['category_id'] == $selected_id ): ?>
								<?= create_tag('option', $category['category_name'], array('value'=>$category['category_id'], 'selected'=>'selected')) ?>
							<?php else: ?>
								<?= create_tag('option', $category['category_name'], array('value'=>$category['category_id'])) ?>
							<?php endif; ?>
						<?php endforeach ?>
					</select>
				</div>

				<div class="form-group">
					<label><?=$this->lang->line('lbl_location')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
						<input type="text" class="form-control" name="location" value="<?php if(isset($result)){ echo $result->location; } ?>">
					</div>
					<p class="error"></p>
				</div>

				<div class="form-group">
					<label><?=$this->lang->line('lbl_event_date')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
						<input type="text" class="form-control pull-right"  name="event_date" id="reservation" value="<?php if(isset($result)){ echo $result->date_start.' - '.$result->date_end; } ?>">
					</div>
					<p class="error"></p>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">01</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">45</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
							<div class="form-group">
								<label><?=$this->lang->line('lbl_start_time')?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									<input type="text" class="form-control timepicker" name="time_start">
								</div>
								<p class="error"></p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">01</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">45</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
							<div class="form-group">
								<label><?=$this->lang->line('lbl_end_time')?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
									<input type="text" class="form-control timepicker" name="time_end">
								</div><!--//END input-group -->
								<p class="error"></p>
							</div><!--//END form-group -->
						</div><!--//END bootstrap-timepicker -->
					</div><!--//END col-md-6 -->
				</div><!--//END row -->
			</div><!--//END box-body -->
		</div><!--//END box-primary -->
	</div><!--//END col-md-4 -->
</div>
<?php echo form_close(); ?>



