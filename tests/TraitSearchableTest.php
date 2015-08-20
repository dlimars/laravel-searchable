<?php

/**
* 
*/
class StubClass {
	public $searchable;
	use Dlimars\LaravelSearchable\Searchable;
}

class TraitSearchableTest extends PHPUnit_Framework_TestCase {

	public $stubClass;

	public function setUp(){
		$this->stubClass = new StubClass;
	}

	public function testCallLikeOperator(){
		$this->stubClass->searchable = [ 'name' => 'LIKE'];
		$search = ['name' => 'user'];

		$query = $this->getBuilderMock();

		$query->expects($this->once())
			  ->method("where")
			  ->with("name", "LIKE", "%user%");

		$this->stubClass->scopeSearch($query, $search);
	}

	public function testCallLikeOperatorNTimes(){
		$this->stubClass->searchable = [ 'name' => 'LIKE'];
		$search = ['name' => 'user name'];

		$query = $this->getBuilderMock();

		$query->expects($this->at(0))
			  ->method("where")
			  ->with("name", "LIKE", "%user%");

		$query->expects($this->at(1))
			  ->method("where")
			  ->with("name", "LIKE", "%name%");

		$this->stubClass->scopeSearch($query, $search);
	}

	public function testCallMatchOperator(){
		$this->stubClass->searchable = [ 'name' => 'MATCH'];
		$search = ['name' => 'user'];

		$query = $this->getBuilderMock();

		$query->expects($this->once())
			  ->method("where")
			  ->with("name", "user");

		$this->stubClass->scopeSearch($query, $search);
	}

	public function getBuilderMock(){
		return $this->getMock("\Illuminate\Database\Eloquent\Builder",[
								'where'
							]);
	}
}