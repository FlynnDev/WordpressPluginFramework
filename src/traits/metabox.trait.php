<?php
namespace PluginFramework;
trait MetaBox {

	public $metabox_prefix = false;
	protected $metaboxes = [];

	/**
	 * Set MetaBox Prefix
	 *
	 * Set the prefix that comes before all metabox names.
	 *
	 * Set to blank to remove the prefix
	 *
	 * Note: Don't add the underscore, we do that for you
	 *
	 * Note: We will clean the string for you: Lowercase it and replace spaces with underscores
	 *
	 * @param string $prefix Prefix
	 */
	public function setMetaBoxPrefix($prefix, $force = false) {
		if( $this->metabox_prefix === false || $force) $this->metabox_prefix = $this->sterilize($prefix);
	}

	public function getMetaBoxPrefix() {
		return $this->metabox_prefix == "" ? "" : $this->sterilize($this->metabox_prefix) . '_';
	}

	/**
	 * Generate MetaBox Name
	 *
	 * @param string ...$param Name Chunks
	 * @return string
	 */
	public function metabox_pre($param){
		$args = func_get_args();
		$pieces = [];

		foreach($args as $arg) if(!empty($arg)) $pieces[] = $this->sterilize($arg);

		return $this->getMetaBoxPrefix() . implode('_', $pieces);
	}

	/**
	 * Add Metabox
	 *
	 * A method must exist at "metabox_{name}" or "{post_type}_metabox_{name}"
	 *
	 * @param string $name Shortcode Name - Method "shortcode_{$name}" must exist
	 * @param callback $func Function
	 */
	public function addMetaBox($name, $func) {
		$this->metaboxes[$name] = $func;
	}

	/**
	 * Add Metaboxes
	 *
	 * A method must exist at "shortcode_{name}"
	 *
	 * @param string[] $names Shortcode Names
	 */
	public function addMetaBoxes($names = []) {
		foreach($names as $name => $func) $this->addMetaBox($name, $func);
	}

	/**
	 * Initializes MetaBoxes
	 */

	protected function init_metaboxes(){

		$metabox_methods = preg_grep('/^(.+_)?metabox_/', get_class_methods($this));

		// Method method
		foreach($metabox_methods as $method) {
			str_replace( 'metabox_', '', $method );
			if(stristr('_metabox_',$method) !== false) list($post_type, $name) = explode("_metabox_", $method);
			else {
				$post_type = 'post';
				$name = str_replace( 'metabox_', '', $method );
			}
			$name = $this->metabox_pre( $name );

			add_metabox(
				$name,
				$this->pre_to_title($name),
				[ &$this, $method ],
				$post_type,
				'normal',
				'high'
			);

		}

	}


}