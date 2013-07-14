<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Zad_switcher
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'zad_switcher',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Models
	'zad_switcher\ZadSwitcherModel'      => 'system/modules/zad_switcher/models/ZadSwitcherModel.php',
	'zad_switcher\ZadSwitcherStyleModel' => 'system/modules/zad_switcher/models/ZadSwitcherStyleModel.php',

	// Modules
	'zad_switcher\ModuleZadSwitcher'     => 'system/modules/zad_switcher/modules/ModuleZadSwitcher.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'zad_switcher_default' => 'system/modules/zad_switcher/templates',
));
