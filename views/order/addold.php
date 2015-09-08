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
                <input type="hidden" readonly="true" value="<?php echo $response->goods['id'] ?>" name = 'goods_id' id = 'goods_id'>
                <input type="hidden" readonly="true" value="2" name = 'goods_color' id = 'goods_color'>
                <input type="hidden" readonly="true" value="1" name = 'goods_size' id = 'goods_size'>
                <h3>Order Basic Information :</h3>
                <p>time: <?php echo date('Y-m-d H:i',time());?><input type="hidden" readonly="true" value="<?php echo date('Y-m-d H:i',time());?>"  size="18" name="add_time"></p>
                <p>Total: <?php echo $response->goods['price']; ?><input type="hidden" readonly="true"  value="<?php echo $response->goods['price']; ?>" id="pay_money" name="pay_money""></p>
            </div>
        </div>
        <div class="col span_2_of_4">
            <div class="contact-form">
                <h3>Contact Information</h3>
                <form method="post" >
                    <div>
                        <span><label>BUYER</label></span>
                        <span><input type="text" value="" class="textbox" name="buyer_name" id="buyer_name"></span>
                    </div>


                    <div>
                        <span><label>RECEIVER</label></span>
                        <span><input type="text" value="" name="consignee" id="consignee" class="textbox" /></span>
                    </div>
                    <div>
                        <span><label>Card Number</label></span>
                        <span><input type="text" value="" id="pay_money" name="pay_money" class="textbox"></span>
                    </div>
                    <div>
                        <span><label>MOBILE</label></span>
                        <span><input type="text" value="" name="tel" id="tel" class="textbox"></span>
                    </div>

                    <div>
                        <span><label>E-MAIL</label></span>
                        <span><input type="text" value="" id="email" name="email" class="textbox" /> </span>
                    </div>
                    <div>
                        <span><label>PROVINCE</label></span>
                        <span><input type="text" value="" name="province" id="province" class="textbox" /></span>
                    </div>
                    <div>
                        <span><label>CITY</label></span>
                        <span><input type="text" value="" id="city" name="city" class="textbox"></span>
                    </div>
                    <div>
                        <span><label>ADDRESS</label></span>
                        <span><input type="text" value="" name="address" id="address" class="textbox" /> </span>
                    </div>
                    <div>
                        <span><label>ZIPCODE</label></span>
                        <span><input type="text" value="" name="zipcode" id="zipcode" class="textbox"></span>
                    </div>
                    <div>
                        <span><label>MESSAGE</label></span>
                        <span><textarea rows="3" cols="80" name="bz"></textarea></span>
                    </div>
                    <div>
                        <span>
                        <input type="submit" value="Submit" id="btnSave_consignee"></span>
                    </div>
                </form>

            </div>


            </form>

        </div>
    </div>
    <div class="clear"></div>
</div>
</div>

<?php include_once(DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'/common/foot.php');?>


<script type="text/javascript">

var lylx_obj = document.getElementById('order_source');
var Utils = new Utils();

//order_source



/**
 * onsubmit
 *submit
 */
document.forms['theForm'].onsubmit = function() {
//  var tip_obj = document.getElementsByName('error_tip');
    var tip_obj = new Array();
    var obj = document.getElementsByTagName('span');
    for(var i=0;i<obj.length;i++) {
        if(obj[i].getAttribute('name') == 'error_tip') {
            tip_obj.push(obj[i]);
        }
    }

    for(var i=0;i<tip_obj.length;i++) {
    
        if(document.all) {  //ie
            tip_obj[i].removeNode(true);
        }else {  //firefox
            tip_obj[i].parentNode.removeChild(tip_obj[i]);
        }
    }

    return error_tip('select_shop')  &&error_tip('shipping_id')&& error_tip('pay_code')&&error_tip('deal_code')&& error_tip('buyer_name')&& error_tip('consignee')&& error_tip('district')&& error_tip('address')&& error_tip('mobile') && error_tip('goods_color')&& error_tip('goods_id')&& error_tip('goods_size') &&error_tip('province')&& error_tip('city');
}

function error_tip(id) {
    var value = document.getElementById(id).value;
    var value = Utils.trim(value);

    if(!value || value == 0)  {
    
        var obj = document.getElementById(id);
        var node = document.createElement('span');
        var text = document.createTextNode('cannot be empty');
        node.style.color = 'red';
        node.setAttribute('name','error_tip');
        node.appendChild(text);
        obj.parentNode.appendChild(node);
            
        return false;
    }
    return true;
    
}
</script>
