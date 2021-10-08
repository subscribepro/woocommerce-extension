<?php

// echo '<pre>';
// print_r($product_data);
// echo '</pre>';

if ( $product_data->intervals ):

    $percentage = intval( str_replace( '%', '', $product_data->discount ) );
    $discount = ($percentage / 100) * $product_data->price;

?>

<br>
<div class="field-group">

    <input type="radio" id="one_time" name="delivery_type" value="one_time">
    <label for="one_time">One Time Delivery - $<?php echo $product_data->price; ?></label><br>
    <input type="radio" id="regular" name="delivery_type" value="regular">
    <label for="regular">Regular Delivery - $<?php echo $product_data->price - $discount; ?> (<?php echo $product_data->discount; ?> Discount)</label><br>

    <input type="hidden" name="delivery_discount" value="<?php echo $product_data->discount; ?>">

</div>

<br>
<div class="field-group frequency-group" style="display: none;">

    <label for="delivery_frequency">Deliver Every:</label><br>
    <select name="delivery_frequency" id="delivery_frequency">
        <?php foreach ( $product_data->intervals as $interval ): ?>
        <option value="<?php echo $interval; ?>"><?php echo $interval; ?></option>
        <?php endforeach; ?>
    </select>

</div>
<br>

<script type="text/javascript">

    (function() {

        jQuery('input[name="delivery_type"]').change(function() {

            if ( jQuery(this).val() == 'regular' ) {
                jQuery('.frequency-group').show();
            } else {
                jQuery('.frequency-group').hide();
            }

        });

    })();

</script>

<?php endif; ?>