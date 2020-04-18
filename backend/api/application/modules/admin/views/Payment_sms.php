<link href="<?php echo dirname(base_url()); ?>/LiberationSans-Bold.ttf" rel="stylesheet">
<link href="http://allfont.net/allfont.css?fonts=liberation-sans-bold" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<br>
<p><b>Namaste,</br></br>
        <?php if($type == 2){?>
            Your Order has been shipped.
        <?php }?>
        <?php if($type == 3){?>
            Your Order has been delivered.
        <?php }?>
    </b></br></br></br>
</p>

<?php if($type != 3){?>
    <span><b>Order details</b></span></b></br></br>
    <div>
        <?php if(is_array($orderDetails)){?>
            <?php if(isset($orderDetails) && count($orderDetails)>0) {?>
                <table class="order" border="1">
                    <?php foreach($orderDetails as $key=>$orderData){?>
                        <tr>
                            <td>
                                <?php echo $key ?>
                            </td>
                            <td>
                                <?php echo $orderData ?>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            <?php }?>
        <?php }?>
    </div>

    </br></br><span><b>Print Order details</b></span></b></br></br>

    <?php if(is_array($printDetails) && count($printDetails) > 0){?>
        <table class="order" border="1">
            <?php foreach($printHeadings as $heading){?>
                <th> <?php echo $heading ?></th>
            <?php }?>
            <?php foreach($printDetails as $printData){?>
                <tr>
                    <td>
                        <?php echo $printData['title'] ?>
                    </td>
                    <td>
                        <?php echo $printData['painting_medium_name'] ?>
                    </td>
                    <td>
                        <?php echo $printData['is_original'] == 1 ? "-" : $printData['inventory_cost'][0]['medium_quality_name'] ?>
                    </td>
                    <td>
                        <?php echo $printData['is_original'] == 1 ? "-" : $printData['inventory_cost'][0]['medium_size_name'] ?>
                    </td>
                    <td>
                        <?php echo $currency ?>
                    </td>
                    <td>
                        <?php echo $printData['cost'] ?>
                    </td>
                    <td>
                        <?php echo $printData['quantity'] ?>
                    </td>
                </tr>
            <?php }?>
        </table>
    <?php }?>

   <p></br></br><b>Billing/Shipping address details</b></p></br></br>

    <?php if(is_array($address)){?>
        <?php if(isset($address) && count($address)>0) {?>
            <table class="order" border="1">
                <?php foreach($address as $key=>$addressData){?>
                    <tr>
                        <td>
                            <?php echo $key ?>
                        </td>
                        <td>
                            <?php echo $addressData?>
                        </td>
                    </tr>
                <?php }?>
            </table>
        <?php }?>
    <?php }?>
<?php }?>

<?php if($type == 3){?>
    <?php if(is_array($printDetails) && count($printDetails) > 0){?>
        <table class="order" border="1">
            <?php foreach($headings as $heading){?>
                <th> <?php echo $heading ?></th>
            <?php }?>
            <?php foreach($printDetails as $printData){?>
                <?php if( $printData['is_original'] != 1){?>
                    <tr>
                        <td>
                            <?php echo $printData['title'] ?>
                        </td>
                        <td>
                            <?php echo $printData['painting_medium_name'] ?>
                        </td>
                        <td>
                            <?php echo $printData['inventory_cost'][0]['medium_quality_name'] ?>
                        </td>
                        <td>
                            <?php echo $printData['inventory_cost'][0]['medium_size_name'] ?>
                        </td>
                        <td>
                            <?php echo $printData['large_imagepath'] ?>
                        </td>
                        <td>
                            <?php echo $printData['quantity'] ?>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
        </table>
    <?php }?>
<?php }?>


</br></br><p>CUSTOMER CARE</p></br></br>
<p>https://krishnafortoday.com</p></br>
<p>Email: golok@krishnafortoday.com</p></br>
<p>Contact Info: 9845-150708</p></br>
</div>

