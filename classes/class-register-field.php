<?php

namespace IXWDA;

class Register_Field {

	/**
	 * @var string[]
	 */
	private array $tax_names;

	public function __construct() {
		$this->tax_names = [
			'product_cat',
			'product_tag',
		];
	}

	public function init() {

		$this->tax_names = array_merge( $this->tax_names, $this->get_attributes() );

		foreach ( $this->tax_names as $tax_name ) {

			add_action( "{$tax_name}_add_form_fields", [ $this, 'add_description_fields' ] );
			add_action( "{$tax_name}_edit_form_fields", [ $this, 'add_description_fields' ] );

			add_action( "create_{$tax_name}", [ $this, 'ix_save_description_field' ] );
			add_action( "edited_{$tax_name}", [ $this, 'ix_save_description_field' ] );

		}

	}

	public function add_description_fields( $term ) {

		if ( isset( $term ) && is_object( $term ) ) {
			?>
            <tr class="form-field ix-archive-description-wrap">
                <th scope="row">
                    <label for="ix-archive-description">Дополнительное описание</label>
                </th>
                <td>
					<?php
					$content = esc_attr( get_term_meta( $term->term_id, 'ix_archive_description', 1 ) );
					wp_editor( $content, "ix_archive_description", [
						'textarea_name' => 'ix_archive_description',
						'textarea_rows' => 5,
						'textarea_cols' => 40,
						'editor_class'  => 'mytext_class',
					] )
					?>
                    <p>Дополнительное описание по умолчанию не отображается, однако некоторые темы могут его
                        показывать.</p>
                </td>
            </tr>
			<?php
		} else {
			?>
            <div class="form-field ix-archive-description-wrap">
                <label for="ix-archive-description">Дополнительное описание</label>
				<?php
				wp_editor( '', "ix_archive_description", [
					'textarea_name' => 'ix_archive_description',
					'textarea_rows' => 5,
					'textarea_cols' => 40,
					'editor_class'  => 'ix_archive_description',
				] )
				?>
                <p>Дополнительное описание по умолчанию не отображается, однако некоторые темы могут его показывать.</p>
            </div>

			<?php
		}
	}

	public function ix_save_description_field( $term_id ) {

		if ( empty( $_POST['ix_archive_description'] ) ) {
			delete_term_meta( $term_id, 'ix_archive_description' );
		}
		update_term_meta( $term_id, 'ix_archive_description', sanitize_textarea_field( $_POST['ix_archive_description'] ) );

	}

	public function get_attributes() {

		$raw_attribute_taxonomies = get_transient( 'description_field_atributes' );

		if ( false === $raw_attribute_taxonomies ) {

			global $wpdb;

			$raw_attribute_taxonomies = $wpdb->get_results( "
                        SELECT `attribute_name` FROM {$wpdb->prefix}woocommerce_attribute_taxonomies 
                        WHERE attribute_name != '' 
                        AND attribute_public = 1 
                        ORDER BY attribute_name ASC;
                        ", ARRAY_A );

			$raw_attribute_taxonomies = wp_list_pluck( $raw_attribute_taxonomies, 'attribute_name' );

			set_transient( 'description_field_atributes', $raw_attribute_taxonomies );
		}

		$tax_name = [];

		foreach ( $raw_attribute_taxonomies as $attribute_taxonomy ) {

			$tax_name[] = 'pa_' . $attribute_taxonomy;

		}

		return $tax_name;

	}

}