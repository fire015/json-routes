<?php namespace Fire015\JsonRoutesTests;

use Illuminate\Routing\Controller;

class TestController extends Controller {

	public function showIndex() {
		return 'testing';
	}

	public function showUser($id) {
		return $id;
	}
}