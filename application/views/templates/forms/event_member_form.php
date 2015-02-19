<?php if( $result_event->status == 'open' ): ?>
	<div class="col-md-6" id="event_member_form">
	<?php echo form_open('events_ajax/member_add/'.
			str_replace('/', '', $this->uri->slash_segment(4, 'leading'))) ?>
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title"><?=$this->lang->line('lbl_add_member')?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_beneficiary_name')?></label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-search"></i></div>
								<input type="search" class="form-control" name="beneficiary" data-autocomplete data-autocomplete-id="beneficiary_name" auto-complete="off" data-link="<?=base_url()?>events_ajax/member_list/<?=$event_id?>">
								<input type="hidden" name="beneficiary_id">
							</div>
							<ul id="beneficiary_name" name="beneficiary_name" class="auto-complete-list"></ul>
							<p class="error"></p>
						</div>
						<input type="submit" class="btn btn-warning btn-block " value="Add to event">
					</div>
				</div>
			</div>
	<?php echo form_close(); ?>
	</div>
<?php endif;?>
</div>
