<?php
namespace PluginFramework\Options;
use \PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
	public function test_defaults() {
		$option = new Option('test', 'name');
		$this->assertEquals('test', $option->value);
		$this->assertEquals('name', $option->label);
	}

	public function test_view() {
		$option = new Option('test', 'name');
		$selected = $option->view('test');
		$not_selected = $option->view('not-test');

		$this->assertEquals('test', $selected['value']);
		$this->assertEquals('name', $selected['label']);
		$this->assertTrue($selected['selected']);

		$this->assertEquals('test', $not_selected['value']);
		$this->assertEquals('name', $not_selected['label']);
		$this->assertFalse($not_selected['selected']);

	}
}