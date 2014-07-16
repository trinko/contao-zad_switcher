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
 * Table tl_module
 */

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['zad_switcher'] = '{title_legend},name,headline,type;{config_legend},zad_switcher;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['zad_switcher'] = array(
  'label'                        => &$GLOBALS['TL_LANG']['tl_module']['zad_switcher'],
  'exclude'                      => true,
  'inputType'                    => 'select',
  'foreignKey'                   => 'tl_zad_switcher.name',
  'eval'                         => array('mandatory'=>true, 'tl_class'=>'clr'),
	'sql'                          => "int(10) unsigned NOT NULL default '0'",
	'relation'                     => array('type'=>'hasOne', 'load'=>'lazy')
);

