<?php
namespace PluginFramework\ShortCodes;
use \PHPUnit\Framework\TestCase;

class Test extends TestCase
{
	public function test_defaults() {
		$shortcodes = new ShortCodes();
		$this->assertInstanceOf('\PluginFramework\ShortCodes\ShortCodes', $shortcodes);
		$this->assertEquals(0, $shortcodes->count());
	}

	public function test_get() {
		$shortcodes = new ShortCodes();
		$this->assertInstanceOf('\PluginFramework\ShortCodes\ShortCode', $shortcodes->get('slug'));
		$this->assertEquals(1, $shortcodes->count());
	}


}