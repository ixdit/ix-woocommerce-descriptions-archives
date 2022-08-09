<?php

namespace IXWDA;

class Register_Field
{
    public function init() {

        $tax_names = [
            'product_cat',
            'product_tag',
        ];

        foreach ( $tax_names as $tax_name ) {

            add_action("{$tax_name}_add_form_fields", 'add_description_field');
            add_action("{$tax_name}_edit_form_fields", 'edit_description_field');

            add_action("create_{$tax_name}", 'save_description_field');
            add_action("edited_{$tax_name}", 'save_description_field');

        }

    }

    public function add_description_field() {}

    public function edit_description_field() {}

    public function save_description_field() {}

}