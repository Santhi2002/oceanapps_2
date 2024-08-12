<?php 
		if($action=="show"){?>
        <!-- Modal -->
        <form name="myform" method="post">
            
            
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title"><?php echo ((isset($deletepage_heading) && $deletepage_heading)?$deletepage_heading:'');?></h4>
                </div>
                <div class="modal-body"><?php echo ((isset($deletepage_confirm) && $deletepage_confirm)?$deletepage_confirm:'');?>
                  <table cellpadding="2" cellspacing="2">
                    <tr>
                      <td><strong>Name :</strong></td>
                      <td id="result"></td>
                    </tr>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                  <button type="submit" class="btn btn-danger" name="delete" value="Delete">Delete</button>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" value="deletesection" />
          <input type="hidden" name="<?php echo $id_column;?>" id="record_id" />
          <input type="hidden" name="<?php echo (isset($parent) && $parent!='')?$parent:'';?>" id="parent_id" />
        </form>
        <!-- Modal -->
        <?php
		}
	?>