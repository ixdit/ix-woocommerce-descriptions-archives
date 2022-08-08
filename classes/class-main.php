<?php

namespace IXWDA;

class Main {

	public function __construct() {

		$this->init();

	}

	public function init() {

		( new Requirements() )->init();

	}


}

