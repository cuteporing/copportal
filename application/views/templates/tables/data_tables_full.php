<div class="error_message"></div>

<div class="box">
	<div class="box-header">
	<h3 class="box-title"><?=$table_name ?></h3>
</div><!-- /.box-header -->

<div class="box-body table-responsive">
  <table id="displayData" class="table table-bordered table-striped">
    <thead>
      <tr>
        <?php foreach ($field_label as $label): ?>
          <?php if( $label == '&nbsp;' ): ?>
            <th width="200"><?= $label ?></th>
          <?php else: ?>
            <th><?= $label ?></th>
          <?php endif; ?>
        <?php endforeach ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($result as $row): ?>
        <tr>
        <?php for( $i=0; $i<count($fieldname); $i++ ): ?>
          <?php if( array_key_exists($fieldname[$i], $row) ): ?>
          <td><?=$row[$fieldname[$i]]?></td>
          <?php endif ?>
        <?php endfor ?>
        <?php if( in_array('action', $fieldname) ): ?>
          <td>
            <div class="btn-group">
              <a href="<?=base_url().$btn_edit.$row['result_id']?>" title="Edit"><button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button></a>
              <a href="<?=base_url().$btn_delete.$row['result_id']?>" title="Delete"><button type="button" class="btn btn-danger" data-ajax="delete" data-del-type="table"><i class="fa fa-trash-o"></i></button></a>
            </div>
          </td>
        <?php endif ?>
        </tr>
      <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
          <?php foreach ($field_label as $label): ?>
            <th><?= $label ?></th>
          <?php endforeach ?>
        </tr>
    </tfoot>
  </table>
</div><!-- /.box-body -->


</div><!-- /.box -->