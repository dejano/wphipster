<!--{% for error in errors  %}-->
<!--    <p class="error danger">{{ error.message }}</p>-->
<!--{% endfor %}-->
<input id="<?php echo $field['id']; ?>" name="<?php echo $field['option_name']; ?>" type="text" value="<?php echo $field['value']; ?>"/>
<p><?php echo $field['description']; ?></p>