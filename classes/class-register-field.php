<?php

namespace IXWDA;

class Register_Field {

	public function __construct() {
	}

	public function init() {

		$tax_names = [
			'product_cat',
			'product_tag',
		];

		foreach ( $tax_names as $tax_name ) {

			add_action( "{$tax_name}_add_form_fields", [ $this, 'ix_add_description_field' ] );
			add_action( "{$tax_name}_edit_form_fields", [ $this, 'ix_edit_description_field' ] );

			add_action( "create_{$tax_name}", [ $this, 'ix_save_description_field' ] );
			add_action( "edited_{$tax_name}", [ $this, 'ix_save_description_field' ] );

		}

	}

	public function ix_add_description_field( $taxonomy ) {
		?>
        <div class="form-field ix-archive-description-wrap">
            <label for="ix-archive-description">Дополнительное описание</label>
            <textarea name="ix_archive_description" id="ix-archive-description" rows="5" cols="40"></textarea>
            <p>Дополнительное описание по умолчанию не отображается, однако некоторые темы могут его показывать.</p>
        </div>

		<?php
	}

	public function ix_edit_description_field( $term ) {
		?>
        <tr class="form-field ix-archive-description-wrap">
            <th scope="row">
                <label for="ix-archive-description">Дополнительное описание</label>
            </th>
            <td>
                <textarea
                        name="ix_archive_description"
                        id="ix-archive-description"
                        rows="5"
                        cols="50"><?php echo esc_attr( get_term_meta( $term->term_id, 'ix_archive_description', 1 ) ) ?></textarea>
                <p>Дополнительное описание по умолчанию не отображается, однако некоторые темы могут его показывать.</p>
            </td>
        </tr>
		<?php
	}

	public function ix_save_description_field( $term_id ) {

		if ( empty( $_POST['ix_archive_description'] ) ) {
			delete_term_meta( $term_id, 'ix_archive_description' );
		}
		update_term_meta( $term_id, 'ix_archive_description', sanitize_textarea_field( $_POST['ix_archive_description'] ) );

	}

}