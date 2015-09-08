













<div class="list-div">
<form action="<?php echo lib_functions::url('order/edit_goods');?>" method="post" name="add_goods_form" onsubmit='return submit_form();'>
	<input type='hidden' name='order_id' id='order_id' value="<?php echo $response->goods['order_id'];?>" />
	<input type='hidden' name='order_sn' id='order_sn'value="<?php echo $response->goods['order_sn'];?>" />
	<input type='hidden' name='goods_sn' id='goods_sn' value="<?php echo $response->goods['goods_sn'];?>" />
	<input type='hidden' name='goods_id' id='goods_id' value="<?php echo $response->goods['goods_id'];?>" />
	<input type='hidden' name='order_goods_id' id='order_goods_id' value="<?php echo $response->goods['id'];?>" />

	<table cellspacing="1" cellpadding="3" >
		<tr>
			<th>Goods Name</th><td><?php echo $response->goods['goods_name'];?> </td>
		</tr>
		<tr>
			<th>Goods Number</th><td><?php echo $response->goods['goods_sn'];?></td>
		</tr>
		<tr>
			<th>Price</th>
			<td><?php echo $response->goods['price'];?>
				<input type='hidden' value='<?php echo $response->goods['price'];?>' name='price' id='price'>
			</td>
		</tr>
		
		<tr>
			<th>color</th>
			<td>
				<select id="color_id" name="color_id" disabled="true">
				<?php foreach($response->colors as $color):?>
				<option value="<?php echo $color['id'];?>"<?php if($response->goods['color_id'] == $color['id']){ echo 'checked';}?>>
					<?php echo $color['name'];?>
				</option>
				<?php endforeach;?>
			</td>
		</tr>
		<tr>
			<th>storage</th>
			<td>
				<select id="size_id" name="size_id" disabled="true">
				<?php foreach($response->sizes as $size):?>
				<option value="<?php echo $size['id'];?>"<?php if($response->goods['size_id'] == $size['id']){ echo 'checked';}?>>
					<?php echo $size['name'];?>
				</option>
				<?php endforeach;?>
			</td>
		</tr>
		<tr>
			<th>number</th>
			<td><input type="text" value="<?php echo $response->goods['goods_number'];?>" name="goods_number" id="goods_number"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			<input type="button" value="submit" onclick="submit_form();"/>
			<input type="button" value="close" onclick="window.close()">
			</td>
		</tr>
	</table>
</form>
</div>

<script type='text/javascript'>
window.returnValue =  1;

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
	zk = zk.toString();
	var index = zk.indexOf('.');

	if(index>0) {
		zk = zk.substring(0,index+4);
	}
	document.getElementById('zhekou').value = zk;
}

function is_number(value) {
	var regex = /^\d+(\.\d)*$/;
	return regex.test(value);
}

function submit_form() {
	
	var params = {
		'submit':1,
		'order_goods_id':document.getElementById('order_goods_id').value,
		'price':	document.getElementById('price').value,
		'price':	document.getElementById('price').value,
		'size_id':	document.getElementById('size_id').value,
		'color_id':	document.getElementById('color_id').value,
		'goods_number':	document.getElementById('goods_number').value
	};
		
	var url = '<?php echo lib_functions::url('order/edit_goods');?>';

	$.post(url,params,function(data) {
			if(data.code==0) {
				alert('Success!');
			}else {
				alert('Save failed!！');
			}
			window.close();
	},'json');
	
	return false;
}
</script>