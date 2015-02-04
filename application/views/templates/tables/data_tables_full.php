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
            <?php if( isset($action_btn) ): ?>
            <div class="btn-group">
                <?php foreach ($action_btn as $btn): ?>
                    <a href="<?= base_url().$btn['url'].$row['result_id'] ?>">
                      <button type="button" class="btn btn-<?=$btn['type'] ?>"
                        <?php if( isset($btn['data_attr']) ): ?>
                          <?php foreach ($btn['data_attr'] as $key): ?>
                            <?= $key['data_name'].'="'.$key['value'].'" ' ?>
                           <?php endforeach; ?>
                        <?php endif; ?>
                        >
                        <i class="<?= $btn['icon']?>"></i>
                      </button>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
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