<?php

/**
* 
*/
class StubClass {
	use Dlimars\LaravelSearchable\Searchable;
}

class TraitSearchableTest extends PHPUnit_Framework_TestCase {

	private $stubClass;

	public function setUp(){
		$this->stubClass = new StubClass;
	}

	public function testFail(){
		
	}

	public function getBuilderMock(){
		return $this->getMock("\Illuminate\Database\Eloquent\Builder");
	}
}