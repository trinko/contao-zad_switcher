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
 * Namespace
 */
namespace zad_switcher;


/**
 * Class ModuleZadSwitcher
 *
 * @copyright  Antonello Dessì 2010-2013
 * @author     Antonello Dessì
 * @package    zad_switcher
 */
class ModuleZadSwitcher extends \Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'zad_switcher_default';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$template = new \BackendTemplate('be_wildcard');
      $template->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['zad_switcher'][0]) . ' ###';
			$template->title = $this->headline;
			$template->id = $this->id;
			$template->link = $this->name;
			$template->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
      return $template->parse();
		}
		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile() {
    global $objPage;
    // get switcher data
    $switcher = \ZadSwitcherModel::findByPk($this->zad_switcher);
    if ($switcher === null || !$switcher->active) {
      // no data
      $this->Template->active = false;
      return;
    }
    // read actual style using get/post/session/cookie/default
    $key = 'sitestyle' . intval($this->zad_switcher);
    if ($switcher->uselinks && \Input::get($key)) {
      // get new style by GET
      $actual = \Input::get($key);
      // prevent indexing
      $objPage->noSearch = 1;
      $objPage->cache = 0;
    } elseif (!$switcher->uselinks && \Input::post('FORM_SUBMIT') == $key) {
      // get new style by POST
      $actual = \Input::post('id');
      // prevent indexing
      $objPage->noSearch = 1;
      $objPage->cache = 0;
    } elseif ($this->Session->get($key)) {
      // read saved style by session
      $actual = $this->Session->get($key);
    } elseif (\Input::cookie($key)) {
      // read saved style by cookies
      $actual = \Input::cookie($key);
    }
    if (!$actual) {
      // get default
      $actual = \ZadSwitcherStyleModel::defaultStyle($switcher, 0);
    }
    // add stylesheets to page HEAD
    $this->setPageHead($switcher, $actual);
	  // get custom template
		$this->strTemplate = $switcher->template;
		$this->Template = new \FrontendTemplate($this->strTemplate);
		$this->Template->setData($this->arrData);
    // page URL
    $req = \Environment::get('request');
    $search = array('/&sitestyle\d+=\d*/', '/\?sitestyle\d+=\d*$/', '/\?sitestyle\d+=\d*&/');
    $replace = array('', '', '?');
    $href = str_replace('&', '&amp;', preg_replace($search, $replace, str_replace('&amp;', '&', $req)));
    $href .= (strchr($href, '?') ? '&amp;' : '?') . $key . '=';
    // init buttons
    $items = array();
    $next = array();
    $previous = array();
    $default = array();
    // set buttons
    if (($switcher->nextenabled + $switcher->prevenabled + $switcher->defenabled) > 0) {
      // set next button
      if ($switcher->nextenabled) {
        $id = \ZadSwitcherStyleModel::nextStyle($switcher, $actual);
        $next = array(
          'id'  => $id,
          'href'  => $href . $id,
          'title' => $switcher->nexttitle,
          'label' => $switcher->nextlabel,
          'image' => $this->getImageSRC($switcher->nextimage),
          'tabindex' => $switcher->nexttab,
          'accesskey' => $switcher->nextkey
        );
      }
      // set previous button
      if ($switcher->prevenabled) {
        $id = \ZadSwitcherStyleModel::previousStyle($switcher, $actual);
        $previous = array(
          'id'  => $id,
          'href'  => $href . $id,
          'title' => $switcher->prevtitle,
          'label' => $switcher->prevlabel,
          'image' => $this->getImageSRC($switcher->previmage),
          'tabindex' => $switcher->prevtab,
          'accesskey' => $switcher->prevkey
        );
      }
      // set default button
      if ($switcher->defenabled) {
        $id = \ZadSwitcherStyleModel::defaultStyle($switcher, $actual);
        $default = array(
          'id'  => $id,
          'href'  => $href . $id,
          'title' => $switcher->deftitle,
          'label' => $switcher->deflabel,
          'image' => $this->getImageSRC($switcher->defimage),
          'tabindex' => $switcher->deftab,
          'accesskey' => $switcher->defkey
        );
      }
    } else {
      // a button for each style
      $style = \ZadSwitcherStyleModel::findBy('pid', $this->zad_switcher, array('order' => 'sorting'));
      if ($style !== null) {
        while ($style->next()) {
          $items[] = array(
            'id'  => $style->id,
            'href'  => $href . $style->id,
            'title' => $style->title,
            'label' => $style->label,
            'image' => $this->getImageSRC($style->image),
            'tabindex' => $style->tabindex,
            'accesskey' => $style->accesskey
          );
        }
      }
    }
    // set template vars
    $this->Template->active = true;
    $this->Template->uselinks = $switcher->uselinks;
    $this->Template->url = $req;
    $this->Template->key = $key;
    $this->Template->next = $next;
    $this->Template->previous = $previous;
    $this->Template->default = $default;
    $this->Template->items = $items;
	}

	/**
	 * Add stylesheets to page HEAD.
	 * @param \Model\ZadSwitcherModel
	 * @param integer
	 */
	protected function setPageHead($switcher, $actual) {
    global $objPage;
    // get stylesheet
    $style = \ZadSwitcherStyleModel::findByPk($actual);
    if ($style === null) {
      // fatal error: exit
      return;
    }
    if ($style->internal) {
      // Contao stylesheet
      $css = \StyleSheetModel::findByPk($style->styleid);
      if ($css === null) {
        // fatal error: exit
        return;
      }
      $name = TL_ASSETS_URL . 'assets/css/' . $css->name . '.css';
      // add version
      $name .= '?' . filemtime(TL_ROOT . '/' . $name);
    } else {
      // external CSS file
			$file = \FilesModel::findByPk($style->stylefile);
			if ($file === null) {
        // fatal error: exit
        return;
      }
      // name with version
      $name = $file->path . '?' . filemtime(TL_ROOT . '/' . $file->path);
    }
    // insert stylesheet at the end of the page header
    $GLOBALS['TL_HEAD'][] =
      '<link rel="stylesheet"' . (($objPage->outputFormat == 'xhtml') ? ' type="text/css"' : '') .
      ' href="' . $name . '" media="' .
      implode(',', deserialize($switcher->media)) . '"' .
      (($objPage->outputFormat == 'xhtml') ? ' />' : '>');
    // try to set session and cookie (1 year expiration)
    $key = 'sitestyle' . $switcher->id;
    $this->Session->set($key, $style->id);
    $this->setCookie($key, $style->id, time() + 31536000, '/');
  }

	/**
	 * Get image SRC by file id.
	 * @param integer
	 * @return String
	 */
	protected function getImageSRC($id) {
    $src = null;
    $file = \FilesModel::findByPk($id);
		if ($file !== null && is_file(TL_ROOT . '/' . $file->path)) {
      $src = $file->path;
    }
    // return image SRC
    return $src;
  }

}

