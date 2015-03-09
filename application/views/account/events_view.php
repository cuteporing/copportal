<div class="error_message"></div>
<?php if( isset($result_event) ): ?>
    <?php
     $btn_edit    = base_url().'account/events/edit/'.$result_event['event_id'];
     $btn_approve = base_url().'events_ajax/update_status/approved/'.$result_event['event_id'];
     $btn_denied  = base_url().'events_ajax/update_status/denied/'.$result_event['event_id'];
     $btn_revise  = base_url().'events_ajax/update_status/revise/'.$result_event['event_id'];
     $btn_delete  = base_url().'events_ajax/delete/'.$result_event['event_id'];

     switch ($result_event['status']) {
         case 'Approved'            : $status_label = 'label label-success'; break;
         case 'Denied'              : $status_label = 'label label-danger';  break;
         case 'Final confirmation'  : $status_label = 'label label-info';    break;
         case 'Pending'             : $status_label = 'label label-default'; break;
         case 'Revise'              : $status_label = 'label label-warning'; break;
         default: $status_label = 'label label-default'; break;
     }
    ?>
    <?php if( isset($show_action_btn) ):?>
        <?php if( $show_action_btn == 'restrict' ):?>
            <div class="btn-group  no-print">
                <button type="button" class="btn btn-default btn-flat"><?=$this->lang->line('lbl_action')?></button>
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only"><?=$this->lang->line('lbl_toggle_drop')?></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?=$btn_edit?>"><?=$this->lang->line('lbl_edit')?></a></li>
                </ul>
            </div><br></br>
        <?php else: ?>
            <div class="btn-group  no-print">
                <button type="button" class="btn btn-default btn-flat"><?=$this->lang->line('lbl_action')?></button>
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only"><?=$this->lang->line('lbl_toggle_drop')?></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?=$btn_edit?>"><?=$this->lang->line('lbl_edit')?></a></li>
                    <li><a href="<?=$btn_approve?>" data-ajax="edit" data-ajax-confirm-msg=""><?=$this->lang->line('lbl_approve')?></a></li>
                    <li><a href="<?=$btn_denied?>" data-ajax="edit" data-ajax-confirm-msg=""><?=$this->lang->line('lbl_denied')?></a></li>
                    <li><a href="<?=$btn_revise?>" data-ajax="edit" data-ajax-confirm-msg=""><?=$this->lang->line('lbl_for_revision')?></a></li>
                    <li class="divider"></li>
                    <li><a href="<?=$btn_delete?>" data-ajax="delete" data-del-type="redirect"><i class="fa fa-trash-o"></i> <?=$this->lang->line('lbl_delete')?></a></li>
                </ul>
            </div><br></br>
        <?php endif; ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-solid">
                <div class="box-header " style="border-bottom: 1px dashed rgb(203, 203, 203);">
                    <h3 class="box-title"><?=$result_event['title'] ?></h3>
                    <small class="<?=$status_label?>" style="float: right;padding: 1.4em .6em 1.6em;">
                        <i class="fa fa-clock-o"></i> <?=$result_event['status'] ?>
                    </small>
                </div>
                <div class="box-body">
                        <p>
                            <?=$result_event['department'] ?>
                        </p>
                        <p>
                            <small>DATE:</small>&nbsp;<?=$result_event['date'] ?><br>
                            <small>TIME:</small>&nbsp;<?=$result_event['time'] ?><br>
                            <small>VENUE:</small>&nbsp;<?=$result_event['location'] ?><br>
                        </p><br>
                        <!-- CATEGORY -->
                        <p>
                            <strong><?=$this->lang->line('lbl_CATEGORY')?></strong><br>
                            <?=$result_event['category_name'] ?>
                        </p>
                        <!-- DESCRIPTION -->
                        <p>
                            <strong><?=$this->lang->line('lbl_DESCRIPTION')?></strong><br>
                            <?php if( isset($result_desc) ): ?>
                                <?php foreach ($result_desc as $description): ?>
                                    <p><?= $description['description'] ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_description')?></small>
                            <?php endif; ?>
                        </p>
                        <!-- IN-CHARGE / PARTICIPANTS -->
                        <p>
                            <strong><?=$this->lang->line('lbl_IN_CHARGE')?></strong><br>
                            <?php if( strlen($result_event['in_charge']) > 0 ): ?>
                                <?=$result_event['in_charge'] ?>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_incharge')?></small>
                            <?php endif; ?>
                        </p>
                        <!-- BENEFICIARY -->
                        <p>
                            <strong><?=$this->lang->line('lbl_BENEFICIARY')?></strong><br>
                            <?php if( isset($result_beneficiary) ): ?>
                                <ul style="list-style-type: disc; margin-left: 1.5em;">
                                    <?php foreach ($result_beneficiary as $beneficiary): ?>
                                        <li><?= $beneficiary['beneficiary'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_beneficiary')?></small>
                            <?php endif; ?>
                        </p>
                        <!-- MATERIALS NEEDED -->
                        <p>
                            <strong><?=$this->lang->line('lbl_nMATERIALS_NEEDED')?></strong><br>
                            <?php if( strlen($result_event['materials_needed']) > 0 ): ?>
                                <?=$result_event['materials_needed'] ?>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_materials_needed')?></small>
                            <?php endif; ?>
                        </p>
                        <!-- BUDGET -->
                        <p>
                            <strong><?=$this->lang->line('lbl_BUDGET')?></strong><br>
                            <?php if( strlen($result_event['budget']) > 0 ): ?>
                                <?=$result_event['budget'] ?>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_budget_proposed')?></small>
                            <?php endif; ?>
                        </p>
                        <!-- EXPECTED OUTPUT -->
                        <p>
                            <strong><?=$this->lang->line('lbl_EXPECTED_OUTPUT')?></strong><br>
                            <?php if( strlen($result_event['expected_output']) > 0 ): ?>
                                <?=$result_event['expected_output'] ?>
                            <?php else: ?>
                                <small style="color: rgb(174, 174, 174);"><?=$this->lang->line('lbl_no_expected_output')?></small>
                            <?php endif; ?>
                        </p><hr>

                         <!-- PREPARED BY -->
                        <p class="text-center"><?=$this->lang->line('lbl_prepared_by')?></p><br>
                        <p class="text-center">
                        <?php if( isset($result_owner) ): ?>
                            <?php foreach ($result_owner as $owner): ?>
                                <strong style="text-transform:uppercase;"><?= $owner['first_name'] ?> <?= $owner['last_name'] ?></strong><br>
                                <?=$result_event['role']?>
                            <?php endforeach; ?>
                            <?php if( $result_event['role'] == 'COP Chairman' ): ?>
                                <br>
                                <small><?=$result_event['department'] ?></small>
                            <?php endif; ?>
                        <?php endif; ?>
                        </p><br><br>

                        <p class="text-center"><?=$this->lang->line('lbl_approved_by')?></p>

                        <?php $name = $owner['first_name'].' '.$owner['last_name'];?>
                        <?php if( isset($result_confirmation) ): ?>
                            <?php if( strlen($result_confirmation['cop_director']) > 0  &&
                                        $name != $result_confirmation['cop_director'] ): ?>
                            <p class="text-center">
                                <strong style="text-transform:uppercase;"><?=$result_confirmation['cop_director']?></strong><br>
                                <?=$this->lang->line('lbl_cop_director')?>
                            </p>
                            <?php endif; ?>
                            <br>

                        <?php if( strlen($result_confirmation['sps_director']) > 0 ): ?>
                            <p class="text-center">
                                <strong style="text-transform:uppercase;"><?=$result_confirmation['sps_director']?></strong><br>
                                <?=$this->lang->line('lbl_sps_director')?>
                            </p>
                            <?php endif; ?>
                            <br>
                        <?php endif; ?>

                        <button class="btn btn-default  no-print" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        <div class="col-md-4 no-print">
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title"><?=$this->lang->line('lbl_comments')?></h3>
                </div>
                <div class="box-body chat" id="chat-box">
                    <?php if( isset($result_comments) && count($result_comments) > 0 ): ?>
                         <?php foreach ($result_comments as $comments): ?>
                            <div class="item">
                                <img src="<?=base_url().$comments['img']?>" alt="user image" class="online"/>
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right">
                                            <i class="fa fa-clock-o"></i> 
                                            <?php echo common::format_date($comments['date_entered'], 'H:i'); ?>
                                        </small>
                                        <?=$comments['name'] ?>
                                    </a>
                                    <?=$comments['text'] ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="box-footer">
                    <?php echo form_open('events_ajax/comment/') ?>
                    <div class="input-group">
                        <input type="hidden" name="event_id" value="<?=$result_event['event_id']?>">
                        <input type="text" id="chat-msg-box" class="form-control" placeholder="Type message..." name="comment"/>
                        <div class="input-group-btn">
                            <button class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>

    </div>
<?php endif; ?>