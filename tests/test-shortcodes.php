<?php
namespace PluginFramework\ShortCodes;
use \PHPUnit\Framework\TestCase;

class ShortCodesTest extends TestCase
{
	public function test_defaults() {
		$shortcodes = new Container();
		$this->assertInstanceOf( '\PluginFramework\ShortCodes\Container', $shortcodes);
		$this->assertEquals(0, $shortcodes->count());
	}

	public function test_get() {
		$shortcodes = new Container();
		$this->assertInstanceOf( '\PluginFramework\ShortCodes\Single', $shortcodes->get('slug'));
		$this->assertEquals(1, $shortcodes->count());
	}


}