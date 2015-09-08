<?php if($response->fullpage):?>
<div class="list-div">
	<form action = '' name="searchForm" onsubmit="return search_form();">
		goods number<input type="text" name="goods_sn"/>&nbsp;&nbsp;goods name<input type="text" name="goods_name"/>&nbsp;&nbsp;
		categories<select name="cat_id">
		<option value="">All</option>
		<?php foreach($response->categories as $cat):?>
		<option value="<?php echo $cat['id']?>"><?php echo $cat['name'];?></option>
		<?php endforeach;?>
		</select>
		&nbsp;&nbsp;brand
		<select name="brand_id">
		<option value="">All</option>
		<?php foreach($response->brands as $brand):?>
		<option value="<?php echo $brand['id'];?>"><?php echo $brand['name']?></option>
		<?php endforeach;?>
		</select>
		&nbsp;&nbsp;<input type="submit" value="search" name="search"  />
	</form>
</div>
<div id="select_goods_div"  class="list-div">
<?php endif;?>


<table cellspacing="1" cellpadding="3" >
	<tr>
		<th>goods number</th>
		<th>goods name</th>
		<th>categories</th>
		<th>brand</th>
		<th>price</th>
		<th>在售</th>
		<th> stock </th>
		<th>operation </th>
	</tr>
	<?php foreach($response->goods as $goods):?>
	<tr>
		<td align="center"><?php echo $goods['goods_sn'];?> </td>
		<td align="center"><?php echo $goods['goods_name'];?> </td>
		<td align="center"><?php echo $goods['cat_name'];?> </td>
		<td align="center"><?php echo $goods['brand_name'];?> </td>
		<td align="center"><?php echo $goods['price'];?> </td>
		<!-- <td align="center"><?php echo $goods['is_sale'] == 1? lib_functions::image('shop/yes.gif'):lib_functions::image('shop/no.gif');?> </td> -->
		<td align="center"></td>
		<td align="center">
		<a href="javascript:javascript:select_goods_one(<?php echo $goods['id'] ?>)"> add</a>
		</td>
	</tr>
	<?php endforeach;?>
	<tr>
		<td colspan="8" align="right">
			共<?php echo count($response->goods);?>条 &nbsp;&nbsp;
		</td>
	</tr>
 </table>

<?php if($response->fullpage):?>
</div>

<script type="text/javascript">
var Utils = new Utils();


function search_form() {
	var eles = document.forms.searchForm.elements;
	var goods_sn = Utils.trim(eles['goods_sn'].value);
	var goods_name = Utils.trim(eles['goods_name'].value);
	var cat_id = eles['cat_id'].value;
	var brand_id = eles['brand_id'].value;
	var url = "<?php echo lib_functions::url('goods/select_goods')?>";

	$.post(url,{'goods_sn':goods_sn,'goods_name':goods_name,
				'cat_id':cat_id,'brand_id':brand_id,'act':'query'},
		function(data) {
			document.getElementById('select_goods_div').innerHTML = data;

	});

	return false;

}

var order_id =  window.dialogArguments.order_id;
var obj = new Object();
obj.order_id = order_id;

function select_goods_one(goods_id) {
	
	window.returnValue = goods_id;
	window.opener = null;
	window.close();
	return false;
	
}

</script>

<?php endif;?>