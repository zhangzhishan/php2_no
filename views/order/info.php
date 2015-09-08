<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/head.php');?>
<?php
echo $head->script('My97DatePicker/WdatePicker.js');
?>
<?php echo $head->script('utils.js')?>


<div class="main">
    <div class="section group">
        <form name="theForm" method="post" action="<?php echo lib_functions::url('order/save');?>">
            <div class="col span_1_of_2">
                <div class="company_address">
                    <h3>Order Basic Information :</h3>
                    <p>Time: <?php echo date('Y-m-d H:i',$response->order_info['add_time']);?></p>
                    <p>Total: <?php echo $response->order_goods[0]['price']; ?></p>
<!--                    --><?php //var_dump($response->order_goods[0]['price']);?>
                    <input type="hidden" value="<?php echo $response->order_goods[0]['price'];?>" id="price" />
                    <p>Order Number: <?php echo $response->order_info['order_sn'];?></p>
                    <p>Buyer: <?php echo $response->order_info['user_name'];?></p>
                </div>
            </div>
            <div class="col span_2_of_4">
                <div class="contact-form">
                    <h3>Contact Information</h3>
                    <form method="post" >
                        <div>
                            <span><label>RECEIVER</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['consignee']; ?>" name="consignee" id="consignee" class="textbox" /></span>
                        </div>
                        <div>
                            <span><label>Card Number</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['pay_money']; ?>" id="pay_money" name="pay_money" class="textbox"></span>
                        </div>
                        <div>
                            <span><label>MOBILE</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['tel']; ?>" name="tel" id="tel" class="textbox"></span>
                        </div>

                        <div>
                            <span><label>E-MAIL</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['email']; ?>" id="email" name="email" class="textbox" /> </span>
                        </div>
                        <div>
                            <span><label>PROVINCE</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['province']; ?>" name="province" id="province" class="textbox" /></span>
                        </div>
                        <div>
                            <span><label>CITY</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['city']; ?>" id="city" name="city" class="textbox"></span>
                        </div>
                        <div>
                            <span><label>ADDRESS</label></span>
                            <span><input type="text" readonly value="<?php echo $response->order_info['address']; ?>" name="address" id="address" class="textbox" /> </span>
                        </div>
                        <div>
                            <span><label>ZIPCODE</label></span>
                            <span>
                                <input type='text' name='zipcode' id='zipcode' value='<?php echo $response->order_info['zipcode'];?>' title='<?php echo $response->order_info['zipcode'];?>' readOnly />
                            </span>
                        </div>
                        <div>
                            <span><label>MESSAGE</label></span>
                            <span><textarea id="bz" rows="3" cols="80" name="bz" readonly><?php echo $response->order_info['bz']; ?></textarea></span>
                        </div>
                        <div>
                        <span>
                            <a id='edit_consignee' class="btn" href="javascript:edit_consignee_info();">edit</a>
                            <a id="cancel_consignee" class="btn" href="javascript:cancel_consignee_info();" style="display:none">cancel</a>
                            <a id="save_consignee"class="btn" href="javascript:save_consignee_info();" style="display:none">save</a>
                            <a class="btn" href="javascript:confirm_fun(1,'<?php echo $response->order_info['id'];?>');">pay</a>
                        </span>
                        </div>
                    </form>

                </div>


        </form>

    </div>
</div>
<div class="clear"></div>
</div>
</div>

<script type="text/javascript">
    var Utils = new Utils();

    function show_select_goods() {
        var obj = new Object();
        obj.order_id = '<?php echo $response->order_info['id'];?>';
        var order_sn = document.getElementById('edit_goods_sn').value;
        var returnValue = window.showModalDialog('<?php echo lib_functions::url('goods/select_goods/');?>'+obj.order_id+'?order_sn='+encodeURI(order_sn),obj,'resizable=yes;dialogWidth=700px');

        if(returnValue){
            var goods_id = returnValue;
            var url = '<?php echo lib_functions::url('goods/select_goods_one/');?>'+goods_id+'?order_id='+obj.order_id;

            var rV = window.showModalDialog(url,obj,'resizable=yes;dialogWidth=700px');

            if(rV) {
                window.location.reload();
            }

        }else {
            window.location.reload();
        }


    }

    function edit_goods(id) {
        var obj = new Object();
        var url= '<?php echo lib_functions::url('order/edit_goods/');?>';
        var returnValue =  window.showModalDialog(url+'?id='+id,obj,'resizable=yes;dialogWidth=700px');

        if(returnValue) {
            window.location.reload();
        }
    }

    function remove_goods(id) {

        if(!confirm('Confirm delete？')) {
            return;
        }

        var url= '<?php echo lib_functions::url('order/remove_goods/');?>';
        $.post(url,{'id':id},function(){
            alert('deletesuccess');
            window.location.reload();
        });

    }

    function edit_base_info() {
        document.getElementById('save_base_info').style.display = '';
        document.getElementById('cancel_base_info').style.display = '';
        document.getElementById('ship_id').disabled = false;
        document.getElementById('pay_id').disabled = false;
    }
    function cancel_base_info() {
        document.getElementById('save_base_info').style.display = 'none';
        document.getElementById('cancel_base_info').style.display = 'none';
        document.getElementById('ship_id').value = document.getElementById('ship_id').title;
        document.getElementById('ship_id').disabled = true;
        document.getElementById('pay_id').value = document.getElementById('pay_id').title;
        document.getElementById('pay_id').disabled = true;
    }

    function save_base_info() {
        var ship_id = document.getElementById('ship_id').value;
        document.getElementById('ship_id').title = document.getElementById('ship_id').value;
        var pay_id = document.getElementById('pay_id').value;
        document.getElementById('pay_id').title = document.getElementById('pay_id').value;
        var url= '<?php echo lib_functions::url('order/edit_base_info');?>';
        var id = '<?php echo $response->order_info['id'];?>';
        $.post(url,{'ship_id':ship_id,'pay_id':pay_id,'id':id},function() {
            document.getElementById('save_base_info').style.display = 'none';
            document.getElementById('cancel_base_info').style.display = 'none';
            document.getElementById('ship_id').disabled = true;
            document.getElementById('pay_id').disabled = true;
        });
    }
    function edit_consignee_info() {
        document.getElementById('save_consignee').style.display = '';
        document.getElementById('cancel_consignee').style.display = '';
        document.getElementById('consignee').readOnly = false;
        document.getElementById('email').readOnly = false;
        document.getElementById('address').readOnly = false;
        document.getElementById('tel').readOnly = false;
        document.getElementById('zipcode').readOnly = false;
        document.getElementById('bz').readOnly = false;
        document.getElementById('province').readOnly = false;
        document.getElementById('city').readOnly = false;
    }

    function cancel_consignee_info() {
        document.getElementById('save_consignee').style.display = 'none';
        document.getElementById('cancel_consignee').style.display = 'none';
        document.getElementById('consignee').value = document.getElementById('consignee').title;
        document.getElementById('email').value = document.getElementById('email').title;
        document.getElementById('address').value = document.getElementById('address').title;
        document.getElementById('tel').value = document.getElementById('tel').title;
        document.getElementById('zipcode').value = document.getElementById('zipcode').title;
        document.getElementById('bz').value = document.getElementById('bz').title;
        document.getElementById('province').value = document.getElementById('province').title;
        document.getElementById('city').value = document.getElementById('city').title;

        document.getElementById('consignee').readOnly = true;
        document.getElementById('email').readOnly = true;
        document.getElementById('address').readOnly = true;
        document.getElementById('tel').readOnly = true;
        document.getElementById('zipcode').readOnly = true;
        document.getElementById('bz').readOnly = true;
        document.getElementById('province').readOnly = true;
        document.getElementById('city').readOnly = true;
    }

    function save_consignee_info() {

        var params = {'consignee':Utils.trim(document.getElementById('consignee').value),
            'email': Utils.trim(document.getElementById('email').value),
            'address':Utils.trim(document.getElementById('address').value),
            'tel':Utils.trim(document.getElementById('tel').value),
            'zipcode':Utils.trim(document.getElementById('zipcode').value),
            'bz':Utils.trim(document.getElementById('bz').value),
            'province':document.getElementById('province').value,
            'city':document.getElementById('city').value,
            'price': document.getElementById('price').value
        };

        var url= '<?php echo lib_functions::url('order/edit_consignee_info');?>';
        var id = '<?php echo $response->order_info['id'];?>';
        params.id = id;
//        alert(params.id);

        $.post(url,params,function() {
//            alert(data.status);
            alert('Success');
            window.location.reload();
        });
    }



    function pay_function(status,order_id) {
        var url = "<?php echo lib_functions::url('order/pay_money');?>";
        $.post(url,{'order_id':order_id,'status':status},function(data){
            if(data.status == 0) {
                alert(data.msg);
                window.location.reload();
            }else {
                alert(data.msg);
            }
        },'json');
    }

    function confirm_fun(status,order_id) {
        var url = "<?php echo lib_functions::url('order/confirm');?>";
        $.post(url,{'order_id':order_id,'status':status},function(data){
//            alert(data.status);
            if(data.status == 0) {
                alert(data.msg);
                window.location = "<?php echo lib_functions::url('goods/index');?>";
//                window.location.reload();
            }else {
                alert(data.msg);


            }
        },'json');
    }

    function notice_peihuo(status,order_id) {
        var url = "<?php echo lib_functions::url('order/notice_peihuo');?>";
        $.post(url,{'order_id':order_id,'status':status},function(data){
            if(data.status == 0) {
                alert(data.msg);
                window.location.reload();
            }else {
                alert(data.msg);
            }
        },'json');

    }

    function guaqi(status,order_id) {
        var url = "<?php echo lib_functions::url('order/guaqi');?>";
        $.post(url,{'order_id':order_id,'status':status},function(data){
            if(data.status == 0) {
                alert(data.msg);
                window.location.reload();
            }else {
                alert(data.msg);
            }
        },'json');

    }
</script>
<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/foot.php');?>



