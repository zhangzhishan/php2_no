<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/head.php');?>

<script>
    $(function(){
        $('#products').slides({
            preload: true,
            preloadImage: 'img/loading.gif',
            effect: 'slide, fade',
            crossfade: true,
            slideSpeed: 350,
            fadeSpeed: 500,
            generateNextPrev: true,
            generatePagination: false
        });
    });
</script>

<div class="main">
    <div class="details">
        <div class="product-details">
            <div class="images_3_of_2">
                <div id="container">
                    <div id="products_example">
                        <div id="products">
                            <div class="slides_container">
                                <?php echo lib_functions::image($response->goods['img_url']); ?>

                            </div>
                            <ul class="pagination">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="desc span_3_of_2">
                <h2><?php echo $response->goods['goods_name'] ?> </h2>
                <p>.</p>
                <div class="price">
                    <p>Price: <span>$<?php echo $response->goods['price'] ?></span></p>
                </div>
<!--                <div class="share-desc">-->
                    <div class="button"><span>
                            <?php echo lib_functions::action('order/addold/'.$response->goods['id'],'Buy Now!'); ?>
                           </span></div>
                    <div class="clear"></div>
<!--                </div>-->
            </div>
            <div class="clear"></div>
        </div>
        <div class="product_desc">
            <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                <ul class="resp-tabs-list">
                    <li class="resp-tab-item resp-tab-active" aria-controls="tab_item-0" role="tab">Product Details</li>
                    <div class="clear"></div>
                </ul>
                <div class="resp-tabs-container">
                    <h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span class="resp-arrow"></span>Product Details</h2><div class="product-desc resp-tab-content resp-tab-content-active" style="display:block" aria-labelledby="tab_item-0">
                        <p><?php echo $response->goods['describle'] ?>.</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#horizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true   // 100% fit in a container
                });
            });
        </script>

    </div>
    <div class="clear"></div>
</div>
    <?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/slider.php');?>
    <div class="clear"></div>
</div>
</div>

<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/foot.php');?>

