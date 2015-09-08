<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>
<?php echo $head->script('My97DatePicker/WdatePicker.js');?>
<div class="container-fluid">

	<div class="row-fluid">
		<div class="span3">
			<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."menu.php";?>
		</div>

		<div class="span9">
    <h1 class="page-title">Goods List</h1>
    <div class="btn-toolbar">
        <button class="btn btn-primary" onclick="window.location.href='<?php echo lib_functions::url('goods/add')?>'"/><i class="icon-plus"></i> New Goods</button>
        <div class="btn-group">
        </div>
    </div>
    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>goods number</th>
		<th>goods name</th>
		<th>categories</th>
		<th>price</th>
		<th>operation </th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($response->goods as $goods):?>
                    <tr>
                        <td align="center" onmouseover="show_img('<?php echo $goods['img_url'];?>',event,this)" onmouseout="remove_img(this)"><?php echo $goods['goods_sn'];?> </td>
                        <td align="center"><?php echo $goods['goods_name'];?> </td>
                        <td align="center"><?php echo $goods['cat_name'];?> </td>
                        <td align="center"><?php echo $goods['price'];?> </td>
                        <td align="center">
                            <?php echo lib_functions::action('goods/edit/'.$goods['id'],'<i class="icon-pencil"></i>');?>
                            <?php echo lib_functions::action('goods/delete/'.$goods['id'],'<i class="icon-remove"></i>',array('onclick'=>"return remove_goods({$goods['id']});", 'data-toggle'=>'modal'));?>
                    </tr>

                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>


</div>

	</div>



    <script type='text/javascript'>
        function remove_goods(id) {
            if(!confirm('Confirm delete？')) {
                return false;
            }
            var url = '<?php echo lib_functions::url('goods/delete/');?>'+id;
            HTTP.post(url,{},function(data) {
                if(data.status==0) {
                    alert(data.msg);
                    window.location.reload();
                }else {
                    alert(data.msg);
                    window.location.reload();
                }
            },'json');

            return false;
        }

        var Utils = new Utils();

        function query() {

            var ele = document.forms['searchForm'].elements;
            page.filter = {};

            page.filter.goods_key = Utils.trim(ele['goods_key'].value);
            page.filter.brand_id = ele['brand_id'].value;
            page.filter.cat_id = ele['cat_id'].value;
            // page.filter.is_sale = ele['is_sale'].value;
            page.filter.query = 1;

            page.reload();

            return false;
        }

        function show_img(img_url,event,obj) {
            if(img_url == '' ) {
                return;
            }
            var childs = obj.childNodes;
            for(var i=0;i<childs.length;i++) {
                if(childs[i].nodeName == 'DIV' && childs[i].className=='img') {
                    obj.removeChild(childs[i]);
                }
            }

            event = window.event?window.event:event;
            var px = event.clientX;
            var py = event.clientY;
            var url = '<?php echo lib_functions::image_src();?>'+img_url;
            var img = document.createElement('img');
            var div = document.createElement('div');
            img.setAttribute('src',url);
            img.style.width=100;
            img.style.height=100;
            div.style.position = 'absolute';
            div.style.zIndex = 1;
            div.style.left = px;
            div.style.top = py;
            div.className = 'img';
            div.appendChild(img);
            obj.appendChild(div);
            return;
        }

        function remove_img(obj) {
            var childs = obj.childNodes;
            for(var i=0;i<childs.length;i++) {
                if(childs[i].nodeName == 'DIV' && childs[i].className=='img') {
                    obj.removeChild(childs[i]);
                }
            }
        }
    </script>


<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>


