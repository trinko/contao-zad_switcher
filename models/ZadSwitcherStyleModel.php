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
 * Namespace
 */
namespace zad_switcher;

/**
 * Class ZadSwitcherStyleModel
 *
 * @copyright  Antonello Dessì 2010-2014
 * @author     Antonello Dessì
 * @package    zad_switcher
 */
class ZadSwitcherStyleModel extends \Model {

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_zad_switcher_style';

	/**
	 * Return next style for this switcher
	 *
	 * @param \Model\ZadSwitcherModel $switcher  The switcher data model
	 * @param int $actual  The actual style id
	 *
	 * @return int  The new style id
	 */
	public static function nextStyle($switcher, $actual) {
    // actual style
    $actual_style = static::findByPk($actual);
    if ($actual_style === null) {
      // fatal error: exit
      return $actual;
    }
	  // get next style
		$t = static::$strTable;
    $cond = array(
      "$t.pid=" . intval($switcher->id),
      "$t.sorting > " . $actual_style->sorting);
    $opt = array('limit' => 1, 'order' => 'sorting');
    $new_style = static::findBy($cond, null, $opt);
    if ($new_style === null && $switcher->circular) {
      // get first
      $cond = array(
        "$t.pid=" . intval($switcher->id));
      $new_style = static::findBy($cond, null, $opt);
    }
    return ($new_style !== null) ? $new_style->id : $actual;
  }

	/**
	 * Return previous style for this switcher
	 *
	 * @param \Model\ZadSwitcherModel $switcher  The switcher data model
	 * @param int $actual  The actual style id
	 *
	 * @return int  The new style id
	 */
	public static function previousStyle($switcher, $actual) {
    // actual style
    $actual_style = static::findByPk($actual);
    if ($actual_style === null) {
      // fatal error: exit
      return $actual;
    }
	  // get previous style
		$t = static::$strTable;
    $cond = array(
      "$t.pid=" . intval($switcher->id),
      "$t.sorting < " . $actual_style->sorting);
    $opt = array('limit' => 1, 'order' => 'sorting DESC');
    $new_style = static::findBy($cond, null, $opt);
    if ($new_style === null && $switcher->circular) {
      // get last
      $cond = array(
        "$t.pid=" . intval($switcher->id));
      $new_style = static::findBy($cond, null, $opt);
    }
    return ($new_style !== null) ? $new_style->id : $actual;
  }

	/**
	 * Return default style for this switcher
	 *
	 * @param \Model\ZadSwitcherModel $switcher  The switcher data model
	 * @param int $actual  The actual style id
	 *
	 * @return int  The new style id
	 */
	public static function defaultStyle($switcher, $actual) {
	  // get default style
		$t = static::$strTable;
    $cond = array(
      "$t.pid=" . intval($switcher->id),
      "$t.defaultstyle='1'");
    $opt = array('limit' => 1);
    $new_style = static::findBy($cond, null, $opt);
    return ($new_style !== null) ? $new_style->id : $actual;
  }

}

