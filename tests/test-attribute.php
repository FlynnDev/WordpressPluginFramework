<?php
namespace PluginFramework\Attributes;
use \PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
	public function test_defaults() {
		$attribute = new Single('test');
		$this->assertEquals('test', $attribute->slug);
		$this->assertEquals('', $attribute->default);
		$this->assertEquals('Test', $attribute->name);
		$this->assertEquals('', $attribute->tip);
		$this->assertInstanceOf( '\PluginFramework\Options\Container', $attribute->options);
		$this->assertCount(0, $attribute->options);
		$this->assertEquals('text', $attribute->type);
		$this->assertEquals('', $attribute->get());
	}

	/**
	 * @requires test_defaults
	 */
	public function test_default() {
		$attribute = new Single('test', 'Default');
		$this->assertEquals('Default', $attribute->default);
		$this->assertEquals('Default', $attribute->get());
	}

	/**
	 * @requires test_defaults
	 */
	public function test_name() {
		$attribute = new Single('test', 'Default', 'New Name');
		$this->assertEquals('New Name', $attribute->name);
	}

	/**
	 * @requires test_defaults
	 */
	public function test_tip() {
		$attribute = new Single('test', 'Default', 'New Name', 'Tip');
		$this->assertEquals('Tip', $attribute->tip);
	}

	/**
	 * @requires test_defaults
	 */
	public function test_options() {
		$attribute = new Single('test', 'Default', 'New Name', 'Tip', 'text', [['test','Test']]);
		$this->assertEquals(1, $attribute->options->count());
	}

	/**
	 * @requires test_defaults
	 */
	public function test_type() {
		$attribute = new Single('test', 'Default', 'New Name', 'Tip', 'select', [[ 'option' => 'test', 'name' => 'test']]);
		$this->assertEquals('select', $attribute->type);
	}

	/**
	 * @requires test_defaults
	 */
	public function test_content(){
		$attribute = new Single('test', 'Default');
		$this->assertEquals('Default', $attribute->get());

		$attribute->set('Content');
		$this->assertEquals('Content', $attribute->get());
	}

}