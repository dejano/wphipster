<?php
foreach ($field['options'] as $key => $value) {
    $selected = '';
    if ($field['value'] == $key) {
        $selected = 'checked="checked"';
    }
    echo "<input type=\"radio\" name=\"{$field['option_name']}\" value=\"$key\" $selected>$value</input>";
}

?>
<p><?php echo $field['description']; ?></p>