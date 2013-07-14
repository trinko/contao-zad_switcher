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
 * Table tl_zad_switcher
 */
$GLOBALS['TL_DCA']['tl_zad_switcher'] = array(
	// Configuration
	'config' => array(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_zad_switcher_style'),
		'enableVersioning'            => true,
		'sql' => array(
      'keys'                        => array('id' => 'primary')
    )
	),
	// Listing
	'list' => array(
		'sorting' => array(
			'mode'                        => 1,
			'fields'                      => array('name'),
			'flag'                        => 1,
			'panelLayout'                 => 'search,limit'
		),
		'label' => array(
			'fields'                      => array('name'),
			'format'                      => '%s'
		),
		'global_operations' => array(
			'all' => array(
				'label'                     => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                      => 'act=select',
				'class'                     => 'header_edit_all',
				'attributes'                => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array(
			'edit' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['edit'],
				'href'                      => 'table=tl_zad_switcher_style',
				'icon'                      => 'edit.gif'
			),
			'editheader' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['editheader'],
				'href'                      => 'act=edit',
				'icon'                      => 'header.gif'
			),
			'copy' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['copy'],
				'href'                      => 'act=copy',
				'icon'                      => 'copy.gif'
			),
			'delete' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['delete'],
				'href'                      => 'act=delete',
				'icon'                      => 'delete.gif',
				'attributes'                => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['toggle'],
				'icon'                      => 'visible.gif',
				'attributes'                => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'           => array('tl_zad_switcher', 'toggleIcon')
			),
			'show' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher']['show'],
				'href'                      => 'act=show',
				'icon'                      => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes' => array(
		'__selector__'                => array('nextenabled','prevenabled','defenabled'),
		'default'                     => '{name_legend},name,media;{view_legend},template,uselinks,circular;{next_legend:hide},nextenabled;{prev_legend:hide},prevenabled;{def_legend:hide},defenabled;'
	),
	// Subpalettes
	'subpalettes' => array(
    'nextenabled'                 => 'nexttitle,nextlabel,nextimage,nexttab,nextkey',
    'prevenabled'                 => 'prevtitle,prevlabel,previmage,prevtab,prevkey',
    'defenabled'                  => 'deftitle,deflabel,defimage,deftab,defkey'
	),
	// Fields
	'fields' => array(
		'id' => array(
			'sql'                         => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array(
			'sql'                         => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['name'],
			'search'                      => true,
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'media' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['media'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => array('all'),
			'options'                     => array('all', 'aural', 'braille', 'embossed', 'handheld', 'print', 'projection', 'screen', 'tty', 'tv'),
			'eval'                        => array('multiple'=>true, 'mandatory'=>true, 'tl_class'=>'clr'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
    'template' => array(
    	'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['template'],
			'exclude'                     => true,
    	'inputType'                   => 'select',
    	'default'                     => 'zad_switcher_default',
    	'options_callback'            => array('tl_zad_switcher', 'getTemplates'),
    	'eval'                        => array('mandatory'=>true, 'tl_class'=>'clr'),
			'sql'                         => "varchar(255) NOT NULL default ''"
    ),
		'uselinks' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['uselinks'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '1',
			'eval'                        => array('tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'circular' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['circular'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '',
			'eval'                        => array('tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'nextenabled' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['nextenabled'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '',
			'eval'                        => array('submitOnChange'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'nexttitle' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttontitle'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'nextlabel' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonlabel'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'nextimage' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonimage'],
			'exclude'                     => true,
			'inputType'                   => 'fileTree',
			'eval'                        => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'tl_class'=>'clr'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'nexttab' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['tabindex'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'sql'                         => "smallint(5) unsigned NOT NULL default '0'"
		),
		'nextkey' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['accesskey'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'prevenabled' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['prevenabled'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '',
			'eval'                        => array('submitOnChange'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'prevtitle' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttontitle'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'prevlabel' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonlabel'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'previmage' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonimage'],
			'exclude'                     => true,
			'inputType'                   => 'fileTree',
			'eval'                        => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'tl_class'=>'clr'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'prevtab' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['tabindex'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'sql'                         => "smallint(5) unsigned NOT NULL default '0'"
		),
		'prevkey' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['accesskey'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'defenabled' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['defenabled'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '',
			'eval'                        => array('submitOnChange'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'deftitle' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttontitle'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'deflabel' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonlabel'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'defimage' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['buttonimage'],
			'exclude'                     => true,
			'inputType'                   => 'fileTree',
			'eval'                        => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'tl_class'=>'clr'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'deftab' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['tabindex'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'sql'                         => "smallint(5) unsigned NOT NULL default '0'"
		),
		'defkey' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['accesskey'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'active' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher']['active'],
			'exclude'                     => true,
			'inputType'                   => 'checkbox',
			'default'                     => '1',
			'eval'                        => array('doNotShow'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		)
	)
);


/**
 * Class tl_zad_switcher
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright Antonello Dessì 2010-2013
 * @author    Antonello Dessì
 * @package   zad_switcher
 */
class tl_zad_switcher extends Backend {

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes) {
		if (strlen(Input::get('tid'))) {
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}
		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['active'] ? '' : 1);
		if (!$row['active']) {
			$icon = 'invisible.gif';
		}
		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a style switcher
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($id, $visible) {
		// Update the database
		$this->Database->prepare("UPDATE tl_zad_switcher SET active=? WHERE id=?")
					         ->execute(($visible ? 1 : ''), $id);
	}

	/**
	 * Return all templates as array
	 * @return array
	 */
	public function getTemplates() {
		return $this->getTemplateGroup('zad_switcher_');
	}

}

