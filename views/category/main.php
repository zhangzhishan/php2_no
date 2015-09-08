<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/head.php');?>


<div class="main">
    <?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/slider.php';?>
    <div class="content">
        <div class="cnt-main btm">
            <div class="section group">
                <?php foreach($response->goods_list as $list): ?>
                <div class="grid_1_of_3 images_1_of_3">
                    <?php echo lib_functions::image($list['img_url']);?>
                    <?php echo lib_functions::action('details/main/'.$list['id'],'<h3>'.$list['goods_name'].'</h3>'); ?>
                    <div class="cart-b">
                        <span class="price left"><sup><?php echo lib_functions::action('details/main/'.$list['id'],'$'.$list['price']); ?></sup><sub></sub></span>
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

<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/foot.php');?>