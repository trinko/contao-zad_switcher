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
 * Table tl_style_sheet
 */

// Configuration
$GLOBALS['TL_DCA']['tl_style_sheet']['config']['ondelete_callback'][] =
  array('tl_style_sheet_zad_switcher', 'deleteStylesheet');


/**
 * Class tl_style_sheet_zad_switcher
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright Antonello Dessì 2010-2013
 * @author    Antonello Dessì
 * @package   zad_switcher
 */
class tl_style_sheet_zad_switcher extends Backend {

	/**
	 * Delete references to stylesheet in style switchers
	 * @param \DataContainer
	 */
	public function deleteStylesheet($dc) {
    // get switchers with default style to delete
		$style = $this->Database->prepare("SELECT DISTINCT pid FROM tl_zad_switcher_style WHERE styleid=? and internal=? and defaultstyle=?")
					        ->execute($dc->id, 1, 1);
    while ($row = $style->fetchRow()) {
      // set new default style
      $this->Database->prepare("UPDATE tl_zad_switcher_style SET defaultstyle=? WHERE pid=? and defaultstyle=?")
                     ->limit(1)
					           ->execute(1, $row[0], '');
    }
    // delete all references to stylesheet
		$this->Database->prepare("DELETE FROM tl_zad_switcher_style WHERE styleid=? and internal=?")
					         ->execute($dc->id, 1);
	}

}

