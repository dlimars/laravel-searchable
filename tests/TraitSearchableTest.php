<?php

/**
* 
*/

if (!function_exists('app')) {
    function app($className) {
        return new $className;
    }
}

class StubClass {
	public $searchable;
	use Dlimars\LaravelSearchable\Searchable;
}

class TraitSearchableTest extends PHPUnit_Framework_TestCase {

	public $stubClass;

	public function setUp(){
		$this->stubClass = new StubClass;
	}

	public function testNotCallOperatorsWhenSearchableIsNotDefined() {
		$search = ['name' => 'user'];
		$query = $this->getBuilderMock();
		$query->expects($this->never(0))
			  ->method("where");
		$this->stubClass->scopeSearch($query, $search);
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

	public function testCallBetweenOperator(){
		$this->stubClass->searchable = [ 'counter' => 'BETWEEN'];
		$search = ['counter' => [10, 20]];

		$query = $this->getBuilderMock();

		$query->expects($this->at(0))
			  ->method("where")
			  ->with("counter", ">=", 10);

		$query->expects($this->at(1))
			  ->method("where")
			  ->with("counter", "<=", 20);

		$this->stubClass->scopeSearch($query, $search);
	}

	public function testCallGreaterOperator(){
		$this->stubClass->searchable = [ 'counter' => 'BETWEEN'];
		$search = ['counter' => [10, null]];

		$query = $this->getBuilderMock();

		$query->expects($this->once())
			  ->method("where")
			  ->with("counter", ">=", 10);

		$this->stubClass->scopeSearch($query, $search);
	}

	public function testCallLessOperator(){
		$this->stubClass->searchable = [ 'counter' => 'BETWEEN'];
		$search = ['counter' => [null, 10]];

		$query = $this->getBuilderMock();

		$query->expects($this->once())
			  ->method("where")
			  ->with("counter", "<=", 10);

		$this->stubClass->scopeSearch($query, $search);
	}

	public function testNotCallBetweenOperatorWhenValuesIsEmptyOrNull(){
		$this->stubClass->searchable = [ 'counter' => 'BETWEEN'];

		$query = $this->getBuilderMock();

		$query->expects($this->never())
			  ->method("where");

		$search = ['counter' => [null, null]];
		$this->stubClass->scopeSearch($query, $search);

		$search = ['counter' => ['', '']];
		$this->stubClass->scopeSearch($query, $search);

		$search = ['counter' => ["abc"]];
		$this->stubClass->scopeSearch($query, $search);

		$search = ['counter' => "abc"];
		$this->stubClass->scopeSearch($query, $search);
	}

	public function getBuilderMock(){
		return $this->getMock(
            '\Illuminate\Database\Eloquent\Builder',
            ['where']
        );
	}
}