<?php
namespace PluginFramework;
use \PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
	public function test_defaults() {
		$attributes = new Attributes();

		$this->assertEquals(0, $attributes->count(), "Load Failed");
		$this->assertInstanceOf('\PluginFramework\Attributes', $attributes, "Init Correct");
	}

	public function test_load_att_arr() {
		$attributes = new Attributes([new Attribute('test')]);

		$this->assertEquals(1, $attributes->count(), "Load Failed");
		$this->assertInstanceOf('\PluginFramework\Attributes', $attributes, "Init Correct");
		$this->assertInstanceOf('\PluginFramework\Attribute', $attributes->get('test'), "Init Correct");
	}

	/**
	 * @depends test_defaults
	 */
	public function test_add() {
		$attributes = new Attributes();
		$attributes->add('test');
		$this->assertEquals(1, $attributes->count(), "Add Failed");
	}


}