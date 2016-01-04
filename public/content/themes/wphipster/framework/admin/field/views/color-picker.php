<div id="wheel">
    <svg>
        <defs>
            <filter id="drop-shadow">
                <feGaussianBlur in="SourceAlpha" stdDeviation="3.2"></feGaussianBlur>
                <feOffset dx="0" dy="0" result="offsetblur"></feOffset>
                <feFlood flood-color="rgba(0,0,0,1)"></feFlood>
                <feComposite in2="offsetblur" operator="in"></feComposite>
                <feMerge>
                    <feMergeNode></feMergeNode>
                    <feMergeNode in="SourceGraphic"></feMergeNode>
                </feMerge>
            </filter>
        </defs>
        <g class="wheel--maing"></g>
    </svg>
</div>
<input id="<?php echo $field['id']; ?>-1" name="<?php echo $field['option_name']; ?>_1" type="hidden" value="<?php echo $field['value']; ?>"/>
<input id="<?php echo $field['id']; ?>-2" name="<?php echo $field['option_name']; ?>_2" type="hidden" value="<?php echo $field['value']; ?>"/>
