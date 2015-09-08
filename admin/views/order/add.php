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
            <h1 class="page-title">Orders</h1>
            <form name="theForm" method="post" action="<?php echo lib_functions::url('order/save');?>">
                <div class="btn-toolbar">
                    <input type="submit" value="Save" id="btnSave_consignee" class="btn btn-primary">
                    <i class="icon-save"></i> </input>
                    <div class="btn-group">
                    </div>
                </div>


                <div class="well">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">
                                <label>time</label>
                                <input type="text" class="input-xlarge" readonly="true" value="<?php echo date('Y-m-d H:i',time());?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})" name="add_time">
                                <label>Card Number:</label>
                                <input type="text" value="" id="pay_money" name="pay_money" class="input-xlarge">

                                <label>Buyer Name</label>
                                <input type="text" value=""  name="buyer_name" id="buyer_name" class="input-xlarge">
                                <label>deal code</label>
                                <input type="text" value="" size="20" name="deal_code" id="deal_code" class="input-xlarge">
                                <label>Consignee Name</label>
                                <input type="text" value="" name="consignee" id="consignee"  class="input-xlarge">
                                <label>Email</label>
                                <input type="text" value="" id="email" name="email" class="input-xlarge">
                                <label>province</label>
                                <input type="text" value="" name="province" id="province" class="input-xlarge">
                                <label>City</label>
                                <input type="text" value="" id="city" name="city" class="input-xlarge">
                                <label>Address</label>
                                <input type="text" value="" name="address" id="address" class="input-xlarge">
                                <label>Phone</label>
                                <input type="text" value="" name="tel" id="tel" class="input-xlarge">
                                <label>Zopcode</label>
                                <input type="text" value="" name="zipcode" id="zipcode" class="input-xlarge">



                                <label>notes</label>
        <textarea value="Smith" rows="3" class="input-xlarge" name="bz"></textarea>


                        </div>
                    </div>

                </div>
            </form>


        </div>
    </div>
    </div>


    <script type="text/javascript">

        var Utils = new Utils();


        function save_order() {

            var params = {
                'pay_money':Utils.trim(document.getElementById('pay_money').value),

                'consignee':Utils.trim(document.getElementById('consignee').value),
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


    </script>


    <?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>






