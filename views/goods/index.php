<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/head.php');?>


<?php if(empty($response->query)):?>
<div class="main">
    <?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/slider.php';?>
    <div class="content">
        <div class="cnt-main btm">
            <div class="section group">
                <?php foreach($response->goods as $list): ?>
                <div class="grid_1_of_3 images_1_of_3">
                    <?php echo lib_functions::image($list['img_url']);?>
                    <?php echo lib_functions::action('details/main/'.$list['id'],'<h3>'.$list['goods_name'].'</h3>'); ?>
                    <div class="cart-b">
                        <span class="price left"><sup><?php echo lib_functions::action('details/main/'.$list['id'], '$'.$list['price']); ?></sup><sub></sub></span>
                        <div class="btn top-right right"><?php echo lib_functions::action('order/addold/'.$list['id'],'Add to Cart', array('class' => 'addCar')); ?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>





<script type='text/javascript'>


    var Utils = new Utils();


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

<?php endif;?>

<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/foot.php');?>
