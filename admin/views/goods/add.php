<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>
<?php
echo $head->script('My97DatePicker/WdatePicker.js');
?>
<?php
echo $head->script('plugins/SWFUpload/swfupload.js');
echo $head->script('plugins/SWFUpload/js/swfupload.queue.js');
echo $head->script('plugins/SWFUpload/js/fileprogress.js');
echo $head->script('plugins/SWFUpload/js/handlers.js');
echo $head->css('swfupload/default.css');
?>
<div class="container-fluid" xmlns="http://www.w3.org/1999/html">

    <div class="row-fluid">
        <div class="span3">
            <?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."menu.php";?>
        </div>
        <div class="span9">
            <h1 class="page-title">Add Goods</h1>
            <form action='<?php echo lib_functions::url('goods/save')?>' method="post" name="theForm">

                <div class="btn-toolbar">
                    <input type="button" name="submit" class="btn" onclick="form_submit()" value="Save">
                    <i class="icon-save"></i> </input>
                    <div class="btn-group">
                    <input type="button" name="reset_form" class="btn"  onclick="form_reset()" value="Reset">
                    </div>
                </div>


                <div class="well">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">

                            <label>Goods Number:</label>
                            <input type="text" value="" name="goods_sn" class="input-xlarge" >
                            <label>Goods Name:</label>

                            <input type="text" value="" name="goods_name" class="input-xlarge">
                            <label>Goods Category:</label>
                            <select name="cat_id" id="" class="input-xlarge">
                                <option value="0">Please Select</option>
                                <?php foreach ($response->categories as $cat) { ?>
                                <option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>

                                <?php } ?>

                                </select>
                                <label for="">Goods Weight:</label>
                            <input type="text" value="" name="goods_weight" class="input-xlarge" >

                                <label for="">Price:</label>
                                <input type="text" value="" name="price" class="input-xlarge" >

                            <label>Description</label>
                            <textarea value="Smith" rows="3" class="input-xlarge" name="desc"></textarea>


                        </div>
                    </div>

                </div>
            </form>
            <div id='img-table' style="background-color:white">
                <h2>upload pictures</h2>
                <form id="form1" action="index.php" method="post" enctype="multipart/form-data">

                    <div class="fieldset flash" id="fsUploadProgress">
                        <span class="legend">Upload Queue</span>
                    </div>
                    <div id="divStatus">0 Files Uploaded</div>
                    <div>
                        <span id="spanButtonPlaceHolder"></span>
                        <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
                    </div>

                </form>
            </div>


        </div>
    </div>
</div>


<script type="text/javascript">
    var Utils  = new Utils();


    function form_submit() {
        if(!confirm('Confirm submit?')) {
            return;
        }
        var form = document.forms['theForm'].elements;
        // alert(form);
        var goods_sn = Utils.trim(form['goods_sn'].value);
        // alert(goods_sn);
        // alert('ddddddddddd')
        var goods_name = Utils.trim(form['goods_name'].value);

        var cat_id = form['cat_id'].value;

//        var brand_id = form['brand_id'].value;
//        var shop_id = form['shop_id'].value;
        var goods_weight = Utils.trim(form['goods_weight'].value);

        var desc = Utils.trim(form['desc'].value);

        var price = Utils.trim(form['price'].value);
        // alert(goods_sn)

        if(!goods_sn) {
            alert('goods number cannot be empty');
            return false;
        }
        if(!goods_name) {
            alert('goods name cannot be empty');
            return false;
        }
        if(!cat_id) {
            alert('please select categories');
            return false;
        }

        var url = '<?php echo lib_functions::url('goods/save');?>';
        // alert(url);
        $.post(url,{'goods_sn':goods_sn,'goods_name':goods_name,'cat_id':cat_id,
                'goods_weight':goods_weight,'desc':desc,'price':price},

            function(data){
                alert(data);
                window.location.href = '<?php echo lib_functions::url('goods/getList');?>';
            });
    }

    function form_reset() {
        var form = document.forms['theForm'];
//        alert(form)
//        var form = document.forms['theForm'];
        form.reset();
    }



</script>

<!--pictures upload  -->
<script type="text/javascript">
    var swfu;
    var swf_root_url = '<?php echo lib_functions::get_layout('js/plugins/SWFUpload/');?>';
    window.onload = function() {
        // alert(1)
        var settings = {

            flash_url : swf_root_url+'swfupload.swf',
            upload_url: "<?php echo lib_functions::url('goods/upload_img');?>",
            post_params: {"PHPSESSID" : "<?php echo session_id(); ?>",'id':'<?php echo $response->goods['id'];?>'},
            file_size_limit : "100 MB",
            file_types : "*.jpeg;*.png;*.gif;*.jpg",
            file_types_description : "IMG Files",
            file_upload_limit : 100,
            file_queue_limit : 0,
            custom_settings : {
                progressTarget : "fsUploadProgress",
                cancelButtonId : "btnCancel"
            },
            debug: false,

            // Button settings
            button_image_url: swf_root_url+"images/TestImageNoText_65x29.png",
            button_width: "65",
            button_height: "29",
            button_placeholder_id: "spanButtonPlaceHolder",
            button_text: '<span class="theFont">upload </span>',
            button_text_style: ".theFont { font-size: 16;}",
            button_text_left_padding: 12,
            button_text_top_padding: 3,

            // The event handler functions are defined in handlers.js
            file_queued_handler : fileQueued,
            file_queue_error_handler : fileQueueError,
            file_dialog_complete_handler : fileDialogComplete,
            upload_start_handler : uploadStart,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,
            queue_complete_handler : queueComplete	// Queue plugin event
        };

        swfu = new SWFUpload(settings);
        // alert('xxx')
    };
</script>

<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>



