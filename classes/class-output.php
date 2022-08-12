<?php

namespace IXWDA;

class Output {

	public function init() {

		add_action( 'woocommerce_after_shop_loop', [ $this, 'output' ] );

	}

	public function output() {

		$obj = get_queried_object();

		if ( empty($obj->term_id ) ) {
			return;
		}

		include IXWDA_PLUGIN_DIR . '/view/html-output-tpl.php';

	}

}