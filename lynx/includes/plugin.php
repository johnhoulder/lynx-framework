<?php

/**
 * @package lynx-framework
 * @version $Id$
 * @copyright (c) lynxphp
 * @license http://creativecommons.org/licenses/by-sa/3.0/ CC by-sa
 */

namespace lynx\Core;

/**
 * @ignore
 */
if (!defined('IN_LYNX'))
{
        exit;
}

abstract class Plugin
{
	public $config = array();

	/**
	 * Sets up the plugin - mostly includes the config
	 * and calls the construct
	 *
	 * @param string $module The name of the plugin to set up
	 */
	public function __construct($module)
	{
		$path = PATH_INDEX . '/lynx/plugins/' . $module . '/config.php';
		if (!is_readable($path))
		{
			return false;
		}
		include($path);
		$this->config = new Config($config, $module);

		if (!$this->config['hooks_disable'])
		{
			global $controller;
			$this->hooks =& $controller->hooks;
		}

		if (method_exists($this, 'lynx_construct'))
		{
			$this->lynx_construct();
		}

		return 1;
	}

	/**
	 * Give the plugin... another plugin
	 *
	 * @param string $plugin The name of the plugin to return
	 */
	public function get_plugin($plugin, $location = false)
	{
		if (!$location)
		{
			$location = $plugin;
		}

		global $controller;
		$this->$location =& $controller->load_plugin($plugin, false, true);
		return true;
	}

	/**
	 * Give the plugin a helper
	 *
	 * @param string $helper The name of the helper to return
	 */
	public function get_helper($helper, $location = false)
	{
		if (!$location)
		{
			$location = $helper;
		}

		global $controller;
		$this->$location =& $controller->load_helper($helper, false, true);
		return true;
	}
}
