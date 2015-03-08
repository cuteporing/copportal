<div class="error_message"></div>
<?php if( isset($result_event) ): ?>
    <?php
     $btn_edit    = base_url().'account/events/edit/'.$result_event['event_id'];
     $btn_approve = base_url().'events_ajax/update_status/approve/'.$result_event['event_id'];
     $btn_denied  = base_url().'events_ajax/update_status/denied/'.$result_event['event_id'];
     $btn_revise  = base_url().'events_ajax/update_status/revise/'.$result_event['event_id'];
     $btn_editable= base_url().'events_ajax/update_status/editable/'.$result_event['event_id'];
     $btn_delete  = base_url().'events_ajax/delete/'.$result_event['event_id'];
    ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-flat">Action</button>
        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?=$btn_edit?>">Edit</a></li>
            <li><a href="<?=$btn_approve?>">Approve</a></li>
            <li><a href="<?=$btn_denied?>">Denied</a></li>
            <li><a href="<?=$btn_revise?>">Revise</a></li>
            <li class="divider"></li>
            <li><a href="<?=$btn_editable?>">Set as editable</a></li>
            <li class="divider"></li>
            <li><a href="<?=$btn_delete?>" data-ajax="delete" data-del-type="redirect"><i class="fa fa-trash-o"></i> Delete</a></li>
        </ul>
    </div><br></br>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-solid">
                <div class="box-header" style="border-bottom: 1px dashed rgb(203, 203, 203);">
                    <h3 class="box-title"><?=$result_event['title'] ?></h3>
                </div>
                <div class="box-body">
                        <p>
                            <small>DATE:</small>&nbsp;<?=$result_event['date'] ?><br>
                            <small>TIME:</small>&nbsp;<?=$result_event['time'] ?><br>
                            <small>VENUE:</small>&nbsp;<?=$result_event['location'] ?><br>
                        </p><br>
                        <p>
                            <strong>CATEGORY</strong><br>
                            <?=$result_event['category_name'] ?>
                        </p>
                        <p>
                            <strong>DESCRIPTION</strong><br>
                            <?php if( isset($result_desc) ): ?>
                                <?php foreach ($result_desc as $description): ?>
                                    <p><?= $description['description'] ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </p>
                        <p>
                            <strong>IN-CHARGE / PARTICIPANTS</strong><br>
                            <?=$result_event['in_charge'] ?>
                        </p>
                        <p>
                            <strong>BENEFICIARY</strong><br>
                            <?php if( isset($result_beneficiary) ): ?>
                                <ul style="list-style-type: disc; margin-left: 1.5em;">
                                    <?php foreach ($result_beneficiary as $beneficiary): ?>
                                        <li><?= $beneficiary['beneficiary'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <small>No beneficiary</small>
                            <?php endif; ?>
                        </p>
                        <p>
                            <strong>MATERIALS NEEDED</strong><br>
                            <?=$result_event['materials_needed'] ?>
                        </p>
                        <p>
                            <strong>BUDGET</strong><br>
                            <?=$result_event['budget'] ?>
                        </p>
                        <p>
                            <strong>EXPECTED OUTPUT</strong><br>
                            <?=$result_event['expected_output'] ?>
                        </p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col (left) -->
    </div>
<?php endif; ?>