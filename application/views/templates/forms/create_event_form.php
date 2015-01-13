<section class="content">
	<div class="row">
		<form role="form">
			<div class="col-md-8">
					<div class="box box-warning">
						<div class="box-header">
							<h3 class="box-title"><?=$this->lang->line('lbl_create_events')?></h3>
						</div>
						<div class="box-body">
								<div class="form-group">
									<label><?=$this->lang->line('lbl_event_title')?></label>
									<input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>" >
								</div>
						</div>
					</div>

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
			</div>
			<div class="col-md-4">
					<div class="box box-primary">
						<div class="box-header">
							<h3 class="box-title"><?=$this->lang->line('lbl_event_details')?></h3>
						</div>
						<div class="box-body">
								<div class="form-group">
									<label>Event category</label>
									<select class="form-control">
										<?php foreach ($events_category as $category): ?>
											<?= '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>' ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Max no. of participants</label>
									<input type="number" class="form-control" placeholder="" name="max_participants" value="<?php echo set_value('max_participants');?>" >
								</div>
								<div class="form-group">
									<label>Location</label>
									<input type="text" class="form-control" placeholder="" name="location" value="<?php echo set_value('location');?>">
								</div>

								<div class="bootstrap-timepicker">
									<div class="bootstrap-timepicker-widget dropdown-menu">
										<table>
											<tbody>
												<tr>
													<td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td>
													<td class="separator">&nbsp;</td>
													<td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td>
													<td class="separator">&nbsp;</td>
													<td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td>
												</tr>
												<tr>
													<td><span class="bootstrap-timepicker-hour">10</span></td> 
													<td class="separator">:</td><td><span class="bootstrap-timepicker-minute">30</span></td> 
													<td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td>
												</tr>
												<tr>
													<td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
													<td class="separator"></td>
													<td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
													<td class="separator">&nbsp;</td>
													<td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- Date and time range -->
									<div class="form-group">
										<label>Date range button:</label>
										<div class="input-group">
											<button class="btn btn-default pull-right" id="daterange-btn" onclick="return false;">
												<i class="fa fa-calendar"></i> Date range picker
												<i class="fa fa-caret-down"></i>
											</button>
										</div>
									</div><!-- /.form group -->
								</div>
						</div>
					</div>

			</div>
		</form>
	</div>
</section>


