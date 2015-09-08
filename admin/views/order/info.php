<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>
<?php
echo $head->script('My97DatePicker/WdatePicker.js');
?>
<div class="container-fluid" xmlns="http://www.w3.org/1999/html">

    <div class="row-fluid">
        <div class="span3">
            <?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."menu.php";?>
        </div>
        <div class="span9">
            <h1 class="page-title">Order Information</h1>


                <div class="well">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Order Information</a></li>
                        <li><a href="#profile" data-toggle="tab">Receiver Information</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">
                            <label for="">Order Number: <?php echo $response->order_info['order_sn'];?></label>

                            <label for="">Buyer: <?php echo $response->order_info['user_name'];?></label>

                            <label for="">Time: <?php echo date('Y-m-d H:i',$response->order_info['add_time']);?></label>

                            <label for="">Order Status: <?php echo $response->order_info['status']==0?'Unpaid':'Paid';?></label>

                            <label for="">Card Number:  <?php echo $respnose->order_info['pay_money'];?></label>

                            <label>Goods Number: <?php echo $response->goods[0]['goods_sn'];?></label>

                            <label>Goods Name: <?php echo $response->goods[0]['goods_name'];?></label>



                            <label for="">Price: <?php echo $response->goods[0]['price'];?></label>



                        </div>
                        <div class="tab-pane fade" id="profile">
                            <label for="">Receiver:</label>
                            <input type='text' value='<?php echo $response->order_info['consignee'];?>' readOnly='readOnly' name='consignee' id='consignee' />

                            <label for="">Email:</label>
                            <input type='text' value='<?php echo $response->order_info['email'];?>' readOnly='readOnly' name='email' id='email' />

                            <label for="">Province</label>
                            <input type="text" value="<?php echo $response->order_info['province']; ?>" readonly name="province" id="province">

                            <label for="">City:</label>

                            <input type="text" value="<?php echo $response->order_info['city']; ?>" id="city" name="city" readonly>
                            <label for="">Address:</label>
                             <input type='text' name='address' id='address' value='<?php echo $response->order_info['address'];?>' readOnly />
                            <label for="">Phone:</label>
                             <input type='text' name='tel' id='tel' value='<?php echo $response->order_info['tel'];?>' title='<?php echo $response->order_info['tel'];?>' readOnly />
                            <label for="">Zipcode</label>
                            <input type='text' name='zipcode' id='zipcode' value='<?php echo $response->order_info['zipcode'];?>' title='<?php echo $response->order_info['zipcode'];?>' readOnly />


                            <div>
                                <span><label>MESSAGE</label></span>
                                <span><textarea id="bz" rows="3" cols="80" name="bz" readonly><?php echo $response->order_info['bz']; ?></textarea></span>
                            </div>

                            <a id='edit_consignee_info' class="special" href="javascript:edit_consignee_info();">Edit</a>
                            <a id="cancel_consignee_info" class="special" href="javascript:cancel_consignee_info();" style="display:none">cancel </a>
                            <a id="save_consignee_info"class="special" href="javascript:save_consignee_info();" style="display:none"> save</a>
                        </div>
                    </div>

                </div>


        </div>
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

        if(!confirm('Confirmdelete？')) {
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
        document.getElementById('save_consignee_info').style.display = '';
        document.getElementById('cancel_consignee_info').style.display = '';
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
        document.getElementById('save_consignee_info').style.display = 'none';
        document.getElementById('cancel_consignee_info').style.display = 'none';
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
            'city':document.getElementById('city').value
        };

        var url= '<?php echo lib_functions::url('order/edit_consignee_info');?>';
        var id = '<?php echo $response->order_info['id'];?>';
        params.id = id;

        $.post(url,params,function() {
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
            if(data.status == 0) {
                alert(data.msg);
                window.location.reload();
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
<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>























