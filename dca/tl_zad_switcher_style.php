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
 * Table tl_zad_switcher_style
 */
$GLOBALS['TL_DCA']['tl_zad_switcher_style'] = array(
	// Configuration
	'config' => array(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_zad_switcher',
		'enableVersioning'            => true,
		'switchToEdit'                => true,
		'onload_callback' => array(
		  array('tl_zad_switcher_style', 'checkButton')
		),
		'onsubmit_callback' => array(
			array('tl_zad_switcher_style', 'setDefault')
		),
		'ondelete_callback' => array(
			array('tl_zad_switcher_style', 'checkDefaultOnDelete')
		),
		'oncut_callback' => array(
			array('tl_zad_switcher_style', 'checkDefaultOnCut')
		),
		'sql' => array(
			'keys' => array(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),
	// Listing
	'list' => array(
		'sorting' => array(
			'mode'                        => 4,
			'fields'                      => array('sorting'),
			'headerFields'                => array('name','media','active'),
			'panelLayout'                 => 'search,limit',
			'child_record_callback'       => array('tl_zad_switcher_style', 'listStyles')
		),
		'global_operations' => array(
			'all' => array(
				'label'                     => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                      => 'act=select',
				'class'                     => 'header_edit_all',
				'attributes'                => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array(
			'edit' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['edit'],
				'href'                      => 'act=edit',
				'icon'                      => 'edit.gif'
			),
			'copy' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['copy'],
				'href'                      => 'act=paste&amp;mode=copy',
				'icon'                      => 'copy.gif'
			),
			'cut' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['cut'],
				'href'                      => 'act=paste&amp;mode=cut',
				'icon'                      => 'cut.gif',
				'button_callback'           => array('tl_zad_switcher_style', 'cutIcon')
			),
			'delete' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['delete'],
				'href'                      => 'act=delete',
				'icon'                      => 'delete.gif',
				'attributes'                => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
        'button_callback'           => array('tl_zad_switcher_style', 'deleteIcon')
			),
			'toggle' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['toggle'],
				'icon'                      => 'system/modules/zad_switcher/assets/default_.gif',
				'attributes'                => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleDefault(this,%s)"',
				'button_callback'           => array('tl_zad_switcher_style', 'toggleIcon')
			),
			'show' => array(
				'label'                     => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['show'],
				'href'                      => 'act=show',
				'icon'                      => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes' => array(
 		'__selector__'                => array('internal'),
		'default_button'              => '{title_legend},name;{button_legend},title,label,image,tabindex,accesskey;{css_legend},internal,stylefile',
		'default_nobutton'            => '{title_legend},name;{css_legend},internal,stylefile',
		'internal_button'             => '{title_legend},name;{button_legend},title,label,image,tabindex,accesskey;{css_legend},internal,styleid',
		'internal_nobutton'           => '{title_legend},name;{css_legend},internal,styleid'
	),
	// Subpalettes
	'subpalettes' => array(
	),
	// Fields
	'fields' => array
	(
		'id' => array(
			'sql'                         => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array(
			'foreignKey'                  => 'tl_zad_switcher.name',
			'sql'                         => "int(10) unsigned NOT NULL default '0'",
			'relation'                    => array('type'=>'hasOne', 'load'=>'lazy')
		),
    'sorting' => array(
			'sql'                         => "int(10) unsigned NOT NULL default '0'"
		),
    'tstamp' => array(
			'sql'                         => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['name'],
			'search'                      => true,
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'title' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['title'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'label' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['label'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                         => "varchar(255) NOT NULL default ''"
		),
		'image' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['image'],
			'exclude'                     => true,
			'inputType'                   => 'fileTree',
			'eval'                        => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'tl_class'=>'clr'),
      'sql'                         => "binary(16) NULL"
		),
		'tabindex' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['tabindex'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'sql'                         => "smallint(5) unsigned NOT NULL default '0'"
		),
		'accesskey' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['accesskey'],
			'exclude'                     => true,
			'inputType'                   => 'text',
			'eval'                        => array('maxlength'=>1, 'tl_class'=>'w50'),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'internal' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['internal'],
			'default'                     => '1',
			'inputType'                   => 'checkbox',
			'eval'                        => array('submitOnChange'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		),
		'styleid' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['styleid'],
			'inputType'                   => 'select',
			'foreignKey'                  => 'tl_style_sheet.name',
			'eval'                        => array('mandatory'=>true, 'chosen'=>true),
			'sql'                         => "int(10) unsigned NOT NULL default '0'",
			'relation'                    => array('type'=>'hasOne', 'load'=>'lazy')
		),
		'stylefile' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['stylefile'],
			'inputType'                   => 'fileTree',
			'eval'                        => array('mandatory'=>true, 'fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>'css', 'tl_class'=>'clr'),
			'sql'                         => "binary(16) NULL"
		),
		'defaultstyle' => array(
			'label'                       => &$GLOBALS['TL_LANG']['tl_zad_switcher_style']['defaultstyle'],
			'inputType'                   => 'checkbox',
			'default'                     => '',
			'eval'                        => array('doNotCopy'=>true, 'doNotShow'=>true),
			'sql'                         => "char(1) NOT NULL default ''"
		)
	)
);


/**
 * Class tl_zad_switcher_style
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright Antonello Dessì 2010-2013
 * @author    Antonello Dessì
 * @package   zad_switcher
 */
class tl_zad_switcher_style extends Backend {

	/**
	 * Check if button fields have to be displayed
	 */
	public function checkButton() {
		$buttons = $this->Database->prepare("SELECT ps.nextenabled + ps.prevenabled + ps.defenabled AS res FROM tl_zad_switcher AS ps,tl_zad_switcher_style AS s WHERE s.id=? and s.pid=ps.id")
					                    ->execute(Input::get('id'));
    if ($buttons->res > 0) {
      // standard buttons defined: hide style buttons
      $GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['default'] = &$GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['default_nobutton'];
      $GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['internal'] = &$GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['internal_nobutton'];
    } else {
      // standard buttons undefined: show style buttons
      $GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['default'] = &$GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['default_button'];
      $GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['internal'] = &$GLOBALS['TL_DCA']['tl_zad_switcher_style']['palettes']['internal_button'];
    }
  }

	/**
	 * List styles
	 * @param array
	 * @return string
	 */
	public function listStyles($row) {
    $css = '';
    if ($row['internal']) {
      // internal CSS
  		$stylesheet = $this->Database->prepare("SELECT name FROM tl_style_sheet WHERE id=?")
									                 ->execute($row['styleid']);
  		if ($stylesheet->numRows) {
        $css = '[' . $stylesheet->name . ']';
      }
    } else {
      // external CSS file
			$model = \FilesModel::findByPk($row['stylefile']);
			if ($model !== null) {
        $css = '[' . $model->path . ']';
			}
    }
    // return string to show
    return
      '<div style="float:left;">' . $row['name'] .
        ' <span style="color:#b3b3b3; padding-left:3px;">' . $css .'</span>' .
      "</div>\n";
	}

	/**
	 * Return the "toggle default" button
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
			$this->toggleDefault(Input::get('tid'), (Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}
		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['defaultstyle'] ? '' : 1);
    return $row['defaultstyle'] ?
      Controller::generateImage('system/modules/zad_switcher/assets/default.gif') . ' ' :
		  '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Controller::generateImage($icon, $label).'</a> ';
	}

	/**
	 * Toggle the default style
	 * @param integer
	 * @param boolean
	 */
	public function toggleDefault($id, $default) {
    if ($default) {
      // get pid
  		$style = $this->Database->prepare("SELECT pid from tl_zad_switcher_style WHERE id=?")
  					                  ->execute($id);
      // reset old default
  		$this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle='' WHERE pid=?")
  					         ->execute($style->pid);
  		// save the new state
  		$this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE id=?")
  					         ->execute(($default ? '1' : ''), $id);
    }
	}

	/**
	 * Return the "delete" button, avoiding deletion of default style
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function deleteIcon($row, $href, $label, $title, $icon, $attributes) {
    // get default
		$style = $this->Database->prepare("SELECT defaultstyle FROM tl_zad_switcher_style WHERE id=?")
					                  ->execute($row['id']);
    // return the button
    return $style->defaultstyle ?
      Controller::generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ' :
      '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Controller::generateImage($icon, $label).'</a> ';
  }

	/**
	 * Return the "cut" button, avoiding moving of default style
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function cutIcon($row, $href, $label, $title, $icon, $attributes) {
    // get default
		$style = $this->Database->prepare("SELECT defaultstyle FROM tl_zad_switcher_style WHERE id=?")
					                  ->execute($row['id']);
    // return the button
    return $style->defaultstyle ?
      Controller::generateImage(preg_replace('/\.gif$/i', '_.gif', $icon)) . ' ' :
      '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Controller::generateImage($icon, $label).'</a> ';
  }

	/**
	 * Set default style for first record
	 * @param \DataContainer
	 */
	public function setDefault($dc) {
		// return if there is no active record
		if (!$dc->activeRecord) {
			return;
		}
    // count styles
		$style = $this->Database->prepare("SELECT count(*) AS cnt FROM tl_zad_switcher_style WHERE pid=?")
					                  ->execute($dc->activeRecord->pid);
    if ($style->cnt == 1) {
      // set default style
  		$this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE id=?")
  					         ->execute('1', $dc->id);
    }
	}

	/**
	 * Check default style for the switcher
	 * @param \DataContainer
	 */
	public function checkDefaultOnDelete($dc) {
    // get switchers with default style to delete
		$style = $this->Database->prepare("SELECT pid,defaultstyle FROM tl_zad_switcher_style WHERE id=?")
					                  ->execute($dc->id);
    if ($style->defaultstyle) {
      // set new default style
      $this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE pid=? and defaultstyle=?")
                     ->limit(1)
					           ->execute('1', $style->pid, '');
    }
	}

	/**
	 * Check default style for the switcher
	 * @param \DataContainer
	 */
	public function checkDefaultOnCut($dc) {
    // get switchers with default style to cut
		$style = $this->Database->prepare("SELECT pid,defaultstyle FROM tl_zad_switcher_style WHERE id=?")
					                  ->execute($dc->id);
    if ($style->defaultstyle) {
      // get all switchers
      $switcher = $this->Database->execute("SELECT id FROM tl_zad_switcher");
      foreach ($switcher->fetchEach('id') as $pid) {
        $style = $this->Database->prepare("SELECT count(*) AS cnt FROM tl_zad_switcher_style WHERE pid=? and defaultstyle=?")
                                ->execute($pid, '1');
        if ($style->cnt > 1) {
          // more than 1 default
          $this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE pid=? and defaultstyle=?")
                         ->limit($style->cnt - 1)
    					           ->execute('', $pid, '1');
        } elseif ($style->cnt == 0) {
          // no default
          $this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE pid=? and defaultstyle=?")
                         ->limit(1)
  					             ->execute('1', $pid, '');
        }
      }
    }
	}

}

