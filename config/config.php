<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   zad_switcher
 * @author    Antonello Dessì
 * @license   LGPL
 * @copyright Antonello Dessì 2010-2013
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

