<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   zad_switcher
 * @author    Antonello Dessì
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @copyright Antonello Dessì 2010-2014
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
