<?php

/**
 * Class C_NextGen_Shortcode_Manager
 *
 * NGG registers it's shortcodes using C_NextGen_Shortcode_Manager::add($tag, $callback)
 *
 * We do this for the following reason:
 *
 * NGG is used with a wide variety of third-party themes and plugins. Some of which, do things
 * a little unorthadox, and end up modifying the markup generated by the shortcode, which breaks
 * the display for our users.
 *
 * Rather than having to explain to our userbase, "you shouldn't use NGG with [plugin x]", we
 * decided to find a mechanism that would make our plugin immune from such manipulation from other
 * plugins, or at least reduce likelihood of such a thing happening.
 *
 * This is how the mechanism works:
 *
 * When you register a shortcode using C_NextGen_Shortcode_Manager::add(), we store a reference to
 * the callback internally, but add the shortcode will actually call one of the internal methods of
 * this class which outputs a placeholder (@see $_privateholder_text) instead of the markup generated
 * by the callback. It's just a simple string and something that a third-party plugin is unlikely to
 * manipulate in any way.
 *
 * We then register a filter for the_content, at high a priority of PHP_INT_MAX as an attempt to make
 * our hook be the last hook to be executed. This hook then substitutes the placeholders with the markup
 * generated by the shortcode's callback that was provided in C_NextGen_Shortcode_Manager::add()
 *
 */
class C_NextGen_Shortcode_Manager
{
	private static $_instance 	= NULL;
	private $_shortcodes 		= array();
    private $_found 			= array();
	private $_placeholder_text  = 'ngg_shortcode_%d_placeholder';

	/**
	 * Gets an instance of the class
	 * @return C_NextGen_Shortcode_Manager
	 */
	static function get_instance()
	{
		if (is_null(self::$_instance)) {
			$klass = get_class();
			self::$_instance = new $klass;
		}
		return self::$_instance;
	}

	/**
	 * Adds a shortcode
	 * @param $name
	 * @param $callback
	 */
	static function add($name, $callback)
	{
		$manager = self::get_instance();
		$manager->add_shortcode($name, $callback);
	}

	/**
	 * Removes a previously added shortcode
	 * @param $name
	 */
	static function remove($name)
	{
		$manager = self::get_instance();
		$manager->remove_shortcode($name);
	}

	/**
	 * Constructor
	 */
	private function __construct()
	{
        // For theme & plugin compatibility and to prevent the output of our shortcodes from being
        // altered we substitute our shortcodes with placeholders at the start of the the_content() filter
		// queue and then at the end of the the_content() queue, we substitute the placeholders with our
		// actual markup
		add_filter('the_content', array(&$this, 'fix_nested_shortcodes'), -1);
        add_filter('the_content', array(&$this, 'parse_content'), PHP_INT_MAX);
		add_filter('widget_text', array(&$this, 'fix_nested_shortcodes'), -1);
	}

	/**
	 * We're parsing our own shortcodes because WP can't yet handle nested shortcodes
	 * [ngg param="[slideshow]"]
	 * @param $content
	 */
	function fix_nested_shortcodes($content)
	{
		// Try to find each registered shortcode in the content
		foreach ($this->_shortcodes as $tag => $callback) {
			$shortcode_start_tag = "[{$tag}";
			$offset = 0;

			// Find each occurance of the shortcode
			while(($start_of_shortcode = strpos($content, $shortcode_start_tag, $offset)) !== FALSE) {
				$index = $start_of_shortcode + strlen($shortcode_start_tag);
				$found_attribute_assignment = FALSE;
				$current_attribute_enclosure = NULL;
				$last_found_char = '';
                $content_length = strlen($content) - 1;

				while (TRUE) {
					// Parse out the shortcode, character-by-character
					$char = $content[$index];
					if ($char == '"' || $char == "'" && $last_found_char == '=') {
						// Is this the closing quote for an already found attribute assignment?
						if ($found_attribute_assignment && $current_attribute_enclosure == $char) {
							$found_attribute_assignment = FALSE;
							$current_attribute_enclosure = NULL;
						} else {
							$found_attribute_assignment = TRUE;
							$current_attribute_enclosure = $char;
						}
					}
					else if ($char == ']') {
						// we've found a shortcode closing tag. But, we need to ensure
						// that this ] isn't within the value of a shortcode attribute
						if (!$found_attribute_assignment) {
							break; //exit loop - we've found the shortcode
						}
					}

                    $last_found_char = $char;

                    // Prevent infinite loops in our while(TRUE)
					if ($index == $content_length)
					    break;

                    $index++;
				}

				// Get the shortcode
				$shortcode = substr($content, $start_of_shortcode+1, --$index-$start_of_shortcode);
				$shortcode_replacement = str_replace(
					array('[', ']'), array('&#91;', '&#93;'), $shortcode
				);

				// Replace the shortcode with one that doesn't have nested shortcodes
				$content = str_replace(
					$shortcode,
					$shortcode_replacement,
					$content
				);

				// Calculate the offset for the next loop iteration
				$offset = $index+1+strlen($shortcode_replacement)-strlen($shortcode);
			}
		}
		reset($this->_shortcodes);

		return $content;
	}

	/**
	 * Deactivates all shortcodes
	 */
	function deactivate_all()
	{
		foreach (array_keys($this->_shortcodes) as $shortcode) {
			$this->deactivate($shortcode);
		}
	}

	/**
	 * Parses the content for shortcodes and returns the substituted content
	 * @param $content
	 * @return string
	 */
	function parse_content($content)
	{
		$regex = str_replace('%d', '(\d+)', $this->_placeholder_text);

		if ($this->is_rest_request()) ob_start();

		if (preg_match_all("/{$regex}/m", $content, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$placeholder = array_shift($match);
				$id = array_shift($match);
				$content = str_replace($placeholder, $this->execute_found_shortcode($id), $content);
			}
		}

		if ($this->is_rest_request()) ob_end_clean();

        return $content;
	}

	function execute_found_shortcode($found_id)
	{
		$retval = '';
		$details 	= $this->_found[$found_id];
		if (isset($this->_shortcodes[$details['shortcode']])) {
			$retval = call_user_func($this->_shortcodes[$details['shortcode']], $details['params'], $details['inner_content']);
		}
		else $retval =  "Invalid shortcode";

		return $retval;
	}

	/**
	 * Adds a shortcode
	 * @param $name
	 * @param $callback
	 */
	function add_shortcode($name, $callback)
	{
		$this->_shortcodes[$name] = $callback;
		add_shortcode($name, array(&$this, $name.'____wrapper'));
	}

	/**
	 * Removes a shortcode
	 * @param $name
	 */
	function remove_shortcode($name)
	{
		unset($this->_shortcodes[$name]);
		$this->deactivate($name);
	}

	/**
	 * De-activates a shortcode
	 * @param $shortcode
	 */
	function deactivate($shortcode)
	{
		if (isset($this->_shortcodes[$shortcode]))
			remove_shortcode($shortcode);
	}

	function is_rest_request()
	{
		return strpos($_SERVER['REQUEST_URI'], 'wp-json') !== FALSE;
	}

	function __call($method, $args)
	{
		$retval = '';
		$params = array_shift($args);
		$retval = $inner_content = array_shift($args);
		$parts = explode('____', $method);
		$shortcode = array_shift($parts);
		if (doing_filter('the_content') && !doing_filter('widget_text')) {
			$retval =  $this->replace_with_placeholder($shortcode, $params, $inner_content);
		}

		// For widgets, don't use placeholders
		else {
			$callback = $this->_shortcodes[$shortcode];
			$retval = call_user_func($callback, $params, $inner_content);
		}

		return $retval;

	}

	function replace_with_placeholder($shortcode, $params=array(), $inner_content='')
	{
		$id = count($this->_found);
		$this->_found[$id] = array(
			'shortcode'		=>	$shortcode,
			'params'		=>	$params,
			'inner_content'	=>	$inner_content
		);

		return sprintf($this->_placeholder_text, $id); // try to wptexturize this! ha!
	}
}