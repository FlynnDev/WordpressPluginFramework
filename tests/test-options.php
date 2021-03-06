<?php
namespace PluginFramework\Options;
use \PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
	public function test_defaults() {
		$options = new Container();
		$this->assertInstanceOf( '\PluginFramework\Options\Container', $options);
		$this->assertEquals(0, $options->count());
	}

	/**
	 * @depends test_defaults
	 */
	public function test_add(){
		$options = new Container();

		$options->add('test1', 'Test 1');
		$this->assertEquals(1, $options->count());
		$this->assertEquals('Test 1', $options->get('test1')->label);

		return $options;
	}

	/**
	 * @depends test_add
	 *
	 * @param Container $options
	 *
	 * @return Container
	 */
	public function test_add_again($options){
		$options->add('test2', 'Test 2');
		$this->assertEquals(2, $options->count());
		return $options;
	}

	/**
	 * @depends test_add_again
	 *
	 * @param Container $options
	 *
	 * @return Container
	 */
	public function test_overwrite($options) {
		$options->add('test1', 'Test 3');
		$this->assertEquals(2, $options->count());
		$this->assertEquals('Test 3', $options->get('test1')->label);

		return $options;
	}

	public function test_import(){
		$options = new Container();
		$this->assertEquals(0, $options->count());

		return $options;
	}

	/**
	 * @depends test_import
	 *
	 * @param Container $options
	 *
	 * @return Container
	 */
	public function test_import_array($options){


		$options->import(['test1' => 'Test 1']);
		$this->assertEquals(1, $options->count());
		$this->assertEquals('Test 1', $options->get('test1')->label);

		return $options;
	}

	/**
	 * @depends test_import_array
	 *
	 * @param Container $options
	 *
	 * @return Container
	 */
	public function test_import_option ($options){
		$options->import(new Single('test2', 'Test 2'));
		$this->assertEquals(2, $options->count());
		$this->assertEquals('Test 2', $options->get('test2')->label);
		return $options;

	}


	/**
	 * @depends test_import_option
	 *
	 * @param Container $options
	 *
	 * @return Container
	 */
	public function test_import_options ($options){
		$test3 = new Container();
		$test3->add('test3', 'Test 3');

		$options->import($test3);
		$this->assertEquals(3, $options->count());
		$this->assertEquals('Test 3', $options->get('test3')->label);

		return $options;
	}

	public function test_load_array() {
		$array = new Container( [ 'test1' => 'Test 1' ] );
		$this->assertEquals( 1, $array->count() );
		$this->assertEquals( 'Test 1', $array->get( 'test1' )->label );
	}

	public function test_load_option() {
		$single = new Container( new Single( 'test2', 'Test 2' ) );
		$this->assertEquals( 1, $single->count() );
		$this->assertEquals( 'Test 2', $single->get( 'test2' )->label );
	}

	public function test_load_options() {
		$test3 = new Container();
		$test3->add('test1', 'Test 1');

		$options = new Container($test3);
		$this->assertEquals(1, $options->count());
		$this->assertEquals('Test 1', $options->get('test1')->label);
	}
}