<?php if(empty($response->query)):?>
<?php 
echo $head->script('My97DatePicker/WdatePicker.js');
?>
<h1>Notification pick order list</h1>
<div class="form-div">
	<form name="searchForm" action="<?php echo lib_functions::url('stock/query');?>" onsubmit="return query();">
		order number<input type="text" name="order_sn" />
		deal code<input type="text" name="deal_code" />
		shop <select name='shop_id'>
			<option value=''>All</option>
			<?php foreach($response->shops as $h):?>
			<option value='<?php echo $h['id'];?>'><?php echo $h['name'];?></option>
			<?php endforeach;?>
			</select>
		consignee<input type="text" name="consignee" />
		status<select name='status'>
				<option value="">All</option>
				<option value="0">Unconfirmed</option>
				<option value="1">confirmed</option>
				<option value="2">Notification pick </option>
			</select>
		Paystatus<select name='pay_status'>
				<option value="">All</option>
				<option value="0">Unpaid</option>
				<option value="1">paid</option>
			</select>
		<br/>
		ship company<select name='ship_id'>
				<option value="">All</option>
				<?php foreach($response->ships as $h):?>
					<option value='<?php echo $h['id'];?>'><?php echo $h['name'];?></option>
					<?php endforeach;?>
				</select>
		card number<select name='pay_id'>
				<option value="">All</option>
				<?php foreach($response->payments as $h):?>
					<option value='<?php echo $h['id'];?>'><?php echo $h['name'];?></option>
					<?php endforeach;?>
				</select>
		time<input type="text" name="start_add_time" class="required" readOnly='readOnly' value="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})"/>
		~<input type="text" name="end_add_time" class="required" readOnly='readOnly' value="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})"/>
		<input type="submit" name="submit" value="search" class='button'/>
	</form>
</div>


<div id="listDiv" class="list-div">
<?php endif;?>
	<table cellspacing="1" cellpadding="3">
		  <tr>
				<th>
				  <input type="checkbox" id="check_all" onclick ="Utils.check_all('check_all','check_id');"/>order number </th>
				<th>deal code</th>
				<th>time</th>
				<th>consignee</th>
				<th>shop </th>
				<th>Money</th>
				<th>orderstatus</th>
				<th>pay</th>
				<th>notes</th>
				<th>operation </th>
		  </tr>
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
					<?php echo $list['shop_name'];?>
				</td>
				<td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
					<?php echo $list['total_amount'];?>
				</td>
				<td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
					<?php 
					switch($list['status']){
						case 0:
							echo 'Unconfirmed';break;
						case 1:
							echo 'confirmed';break;
						case 2:
							echo 'Notification pick ';break;
						case 3:
							echo 'Shipped';break;
					}
					?>
				</td>
				<td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
					<?php echo $list['pay_status']==0?'Unpaid':'paid';?>
				</td>
				<td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);" title="<?php echo $list['bz'];?>">
					<?php echo substr_replace($list['bz'],'...',15);?>
				</td>
				<td nowrap="nowrap" align="center" valign="top" style="background-color: rgb(255, 255, 255);">
					<?php echo lib_functions::action("order/info/{$list['id']}",'view');?>
				</td>
				
		  </tr>
		  <?php endforeach;?>
		  <tr>
				<td align='right' colspan='10'>
				<?php  include(DS.'/views/page/page.php');?>
				</td>
		  </tr>
		  <tr>
				<td colspan="10" align="left">
					<input type="button" class="button" value="create  pick goods oreder " onclick="make_psend()"/>
				</td>
		  </tr>
	  </table>
<?php if(empty($response->query)):?>		
</div>
<script type="text/javascript">
var Utils = new Utils();
page.query = '<?php echo lib_functions::url('order/torange')?>';

function query() {
	
	var ele = document.forms['searchForm'].elements;
	page.filter = {};
	
	page.filter.order_sn = Utils.trim(ele['order_sn'].value);
	page.filter.deal_code = Utils.trim(ele['deal_code'].value);
	page.filter.consignee = Utils.trim(ele['consignee'].value);
	page.filter.shop_id = ele['shop_id'].value;
	page.filter.status = ele['status'].value;
	page.filter.pay_status = ele['pay_status'].value;
	page.filter.ship_id = ele['ship_id'].value;
	page.filter.pay_id = ele['pay_id'].value;
	page.filter.start_add_time = ele['start_add_time'].value;
	page.filter.end_add_time = ele['end_add_time'].value;
	page.filter.query = 1;
	
	page.reload();

	return false;
}

function make_psend() {
	var ids_obj = document.getElementsByName('check_id');
	var id_arr = new Array();
	for(var i=0;i<ids_obj.length;i++) {
		if(ids_obj[i].checked) {
			id_arr.push(ids_obj[i].value);
		}
	}
	if(id_arr.length == 0) {
		alert('please select');
		return;
	}
	if(!confirm('confirmed operation ？')) {
		return;
	}
	var url = '<?php echo lib_functions::url('psend/create');?>';
	HTTP.post(url,{'ids':id_arr},function(data){
		if(data.status == 0) {
			alert(data.msg);
			window.location.reload();
		}else {
			alert(data.msg);
		}
	},'json');

}
</script>
<?php endif;?>