<?php

// echo '<pre>';
// print_r($product_data);
// echo '</pre>';

// if ($product_data->intervals):
?>

<br>
<div class="field-group">

    <input type="radio" id="one_time" name="delivery_type" value="One Time">
    <label for="one_time">One Time Delivery - $<?php echo $product_data->price; ?></label><br>
    <input type="radio" id="regular" name="delivery_type" value="Regular">
    <label for="regular">Regular Delivery - $<?php echo $product_data->price; ?> with <?php echo $product_data->discount; ?> Discount</label><br>

</div>

<br>
<div class="field-group">

    <label for="delivery_frequency">Deliver Every:</label><br>
    <select name="delivery_frequency" id="delivery_frequency">
        <option value="Every Two Weeks">Every Two Weeks</option>
        <option value="Every Four Weeks">Every Four Weeks</option>
        <?php //foreach ( $product_data->intervals as $interval): ?>
        <option value="<?php echo $interval; ?>"><?php echo $interval; ?></option>
        <?php //endforeach; ?>
    </select>

</div>
<br>

<?php //endif; ?>