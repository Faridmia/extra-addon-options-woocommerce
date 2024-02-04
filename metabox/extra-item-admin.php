<table id="eaw-repeatable-fieldset-one">
    <tbody>
        <tr class="eaw-tr-extra-field-item-heading">
            <td class="eaw-input-td-field">
                <input type="text" placeholder="Extra Item Title" name="eaw_item_title" value="<?php if ($eaw_item_title != '') echo esc_attr($eaw_item_title); ?>" />
            </td>
        </tr>
        <?php
        if ($eaw_extra_item_group) :
            foreach ($eaw_extra_item_group as $field) {
        ?>
                <tr class="eaw-tr-extra-field-item">
                    <td class="eaw-input-td-field">
                        <input type="text" placeholder="Extra Item Label Text" name="eaw_extra_item[]" value="<?php if ($field['eaw_extra_item'] != '') echo esc_attr($field['eaw_extra_item']); ?>" />
                    </td>
                    <td class="eaw-input-td-field">
                        <input type="text" placeholder="Price" name="eaw_extra_item_price[]" value="<?php if ($field['eaw_extra_item_price'] != '') echo esc_attr($field['eaw_extra_item_price']); ?>" />
                    </td>
                    <td width="15%"><a class="button eaw-remove-row" href="#1"><?php echo esc_html__("Remove", "eaw"); ?></a></td>
                </tr>
            <?php
            }
        else :
            // show a blank one
            ?>
            <tr class="eaw-tr-extra-field-item">
                <td class="eaw-input-td-field">
                    <input type="text" placeholder="Extra Item Label Text" title="Label Text" name="eaw_extra_item[]" />
                </td>
                <td class="eaw-input-td-field">
                    <input type="text" placeholder="Price" title="Price" name="eaw_extra_item_price[]" />
                </td>
                <td><a class="button  cmb-remove-row-button button-disabled" href="#"><?php echo esc_html__("Remove", "eaw"); ?></a></td>
            </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="empty-row screen-reader-text eaw-tr-extra-field-item">
            <td class="eaw-input-td-field">
                <input type="text" placeholder="Extra Item Label Text" title="Label Text" name="eaw_extra_item[]" />
            </td>
            <td class="eaw-input-td-field">
                <input type="text" placeholder="Price" title="Price" name="eaw_extra_item_price[]" />
            </td>
            <td><a class="button eaw-remove-row" href="#"><?php echo esc_html__("Remove", "eaw"); ?></a></td>
        </tr>
    </tbody>
</table>
<p><a id="eaw-add-row" class="button" href="#"><?php echo esc_html__("Add another", "eaw"); ?> </a></p>