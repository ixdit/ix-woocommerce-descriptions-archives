<?php

namespace IXWDA;

class Main {

	public function init() {

		( new Requirements() )->init();
        ( new Register_Field() )->init();
        ( new Output() )->init();

	}


}

