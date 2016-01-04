<select name="<?php echo $field['option_name']; ?>">
    <?php
    foreach ($field['options'] as $key => $value) {
        $selected = '';
        if ($field['value'] == $key) {
            $selected = 'selected="selected"';
        }
        echo "<option value=\"$key\" $selected>$value</option>";
    }

    ?>
</select>
<p><?php echo $field['description']; ?></p>