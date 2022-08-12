<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo '<div>';
echo esc_attr( get_term_meta( $obj->term_id, 'ix_archive_description', 1 ) );
echo '</div>';
