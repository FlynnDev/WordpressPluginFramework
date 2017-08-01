<?php
namespace PluginFramework\Attributes;
use \PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
	public function test_defaults() {
		$attributes = new Container();

		$this->assertEquals(0, $attributes->count(), "Load Failed");
		$this->assertInstanceOf( '\PluginFramework\Attributes\Container', $attributes, "Init Correct");
	}

	public function test_load_att_arr() {
		$attributes = new Container([new Single('test')]);

		$this->assertEquals(1, $attributes->count(), "Load Failed");
		$this->assertInstanceOf( '\PluginFramework\Attributes\Container', $attributes, "Init Correct");
		$this->assertInstanceOf( '\PluginFramework\Attributes\Single', $attributes->get('test'), "Init Correct");
	}

	/**
	 * @depends test_defaults
	 */
	public function test_add() {
		$attributes = new Container();
		$attributes->add('test');
		$this->assertEquals(1, $attributes->count(), "Add Failed");
	}


}