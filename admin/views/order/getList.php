<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>
<?php echo $head->script('My97DatePicker/WdatePicker.js');?>
<div class="container-fluid">

	<div class="row-fluid">
		<div class="span3">
			<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."menu.php";?>
		</div>

		<div class="span9">
    <h1 class="page-title">Orders</h1>

    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>
				  <input type="checkbox" id="check_all" onclick ="Utils.check_all('check_all','check_id');"/>order number </th>
				<th>deal code</th>
				<th>time</th>
				<th>consignee</th>
				<th>Money</th>
				<th>orderstatus</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($response->order_list as $list):?>
                <tr>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
                        <input type="checkbox" name="check_id" value="<?php echo $list['id'];?>"/><?php echo lib_functions::action("order/info/{$list['id']}",$list['order_sn']) ;?>
                    </td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
                        <?php echo $list['deal_code'];?>
                    </td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
                        <?php echo date('Y-m-d H:i',$list['add_time']);?>
                    </td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
                        <?php echo $list['consignee'];?>
                    </td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
                        <?php echo $list['total_amount'];?>
                    </td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
						<?php echo $list['status']==0?'Unpaid':'Paid';?>

                    </td>

					<td>
						<?php echo lib_functions::action("order/info/{$list['id']}",'<i class="icon-pencil"></i>');?>
					</td>
                    <td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">

                    </td>

                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
    <ul>
                    <li><input type="button" class="button" value="Batch Mark As Paid" onclick="confirm_all(1)"/></li>
					<li><input type="button" class="button" value="Batch Mark As Unpaid" onclick="confirm_all(0)"/></li>

    </ul>
</div>
    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Delete Confirmation</h3>
        </div>
        <div class="modal-body">
            <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-danger" data-dismiss="modal">Delete</button>
        </div>
    </div>

</div>

	</div>




<script type="text/javascript">

function confirm_all(status) {
	var check_ids = document.getElementsByName('check_id');
	var id_arr = new Array();
	for(var i=0;i<check_ids.length;i++) {
		if(check_ids[i].checked) {
			id_arr.push(check_ids[i].value);
		}
	}
	if(id_arr.length==0) {
		alert('Please select item.');
		return;
	}

	if(!confirm("Confirm operation?"))　{
		return;
	}
	var url = "<?php echo lib_functions::url('order/confirm');?>";
	var msg_arr = new Array();
	for(i=0;i<id_arr.length;i++) {
		$.post(url,{'order_id':id_arr[i],'status':status},function(data){
			msg_arr.push(data.msg);
			if(msg_arr.length == id_arr.length) {
				window.location.reload();
			}
		},'json');
	}

}




</script>
<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>