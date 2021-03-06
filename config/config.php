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
 * BACK END MODULES
 */
$GLOBALS['BE_MOD']['content']['zad_switcher'] = array(
  'tables'		   =>	array('tl_zad_switcher', 'tl_zad_switcher_style'),
  'icon'			   =>	'system/modules/zad_switcher/assets/icon.png'
);


/**
 * FRONT END MODULES
 */
$GLOBALS['FE_MOD']['application']['zad_switcher'] = 'ModuleZadSwitcher';

