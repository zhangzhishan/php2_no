<div class="list-div">
<base target="_self">
<form  action="<?php echo lib_functions::url('order/add_goods');?>" method="post" name="add_goods_form" >
	<input type="hidden" name="goods_id" value="<?php echo $response->goods['id'];?>">
	<input type="hidden" name="goods_sn" value="<?php echo $response->goods['goods_sn'];?>">
	<input type="hidden" name="order_id" value="<?php echo @$_REQUEST['order_id'];?>">
	<input type="hidden" name="price" id = "price" value="<?php echo $response->goods['price'];?>">

	<table cellspacing="1" cellpadding="3" >
		<tr>
			<th>Goods Name</th><td><?php echo $response->goods['goods_name'];?> </td>
			<th>Goods Number</th><td><?php echo $response->goods['goods_sn'];?></td>
		</tr>
		<tr id="goods_price_edit">
			<th>Price</th><td><?php echo $response->goods['price'];?></td>

		</tr>
	</table>
	<hr/>
	<table  cellspacing="1" cellpadding="3" >
		<tr>
			<th>storage/color</th>
			<?php foreach($response->colors as $color):?>
			<th style="color:red"><?php echo $color['color_name'];?></th>
			<?php endforeach;?>
		</tr>
		<?php foreach($response->sizes as $size):?>
		<tr>
			<th style="color:red"><?php echo $size['size_name'];?></th>
			<?php foreach($response->colors as $color):?>
			<th><input type="type" size="5" name="<?php echo 'row_'.$size['id'].'_'.$color['id'];?>" onkeyup="check_type(this)"/></th>
			<?php endforeach;?>
		</tr>	
		<?php endforeach;?>
		<tr>
			<td colspan="<?php echo count($response->sizes)+1;?>" align="center">
			<input type="submit" value="submit"/>
			<input type="button" value="close" onclick="window.close()">
			</td>
		</tr>
	</table>
</form>
</div>


<script type="text/javascript">

var Utils = new Utils();

if(!window.dialogArguments) {
	window.close();  
}else{
	var arg_obj = window.dialogArguments;
	if(arg_obj.action) {
		document.forms['add_goods_form'].action = arg_obj.action;
		document.getElementById('goods_price_edit').style.display = 'none';
	}
}

window.returnValue = true;

function check_type(obj) {
	var value = Utils.trim(obj.value);

	////
	var regex = /^\d+$/;
	if(regex.test(value)) {
		//// condition
	}else {
		obj.value = '';
	}
}

function change_price(obj) {
	var price = document.getElementById('price').value;
	
	if(!is_number(obj.value)) {
		obj.value = price;
	}

	var value = parseFloat(obj.value);
	
	value = value > price?price:value;
	obj.value = value;
	var zk = parseFloat(value/price);
	document.getElementById('zhekou').value = zk;
}

function is_number(value) {
	var regex = /^\d+(\.\d)*$/;
	return regex.test(value);
}


</script>