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
 * Class ModuleZadSwitcher
 *
 * @copyright  Antonello Dessì 2010-2014
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
	 *
	 * @return string  The html text for the module
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
    $actual = null;
    $key = 'zsS_' . intval($this->zad_switcher);
    if ($switcher->uselinks && \Input::get($key)) {
      // get new style by GET
      $actual = \Input::get($key);
      // prevent indexing
      $objPage->noSearch = 1;
      $objPage->cache = 0;
    } elseif (!$switcher->uselinks && \Input::post($key)) {
      // get new style by POST
      $actual = \Input::post($key);
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
    // add stylesheet to page HEAD
    $this->setPageHead($switcher, $actual, $key);
	  // get custom template
		$this->strTemplate = $switcher->template;
		$this->Template = new \FrontendTemplate($this->strTemplate);
		$this->Template->setData($this->arrData);
    // page URL
    $href = '';
    $href_query = '';
    $href_req = '';
    $this->createBaseUrl($key, $href, $href_query, $href_req);
    // init buttons
    $items = array();
    $next = array();
    $previous = array();
    $default = array();
    // set buttons
    if ($switcher->nextenabled || $switcher->prevenabled || $switcher->defenabled) {
      // set next button
      if ($switcher->nextenabled) {
        $id = \ZadSwitcherStyleModel::nextStyle($switcher, $actual);
        $next = array(
          'id'  => $id,
          'href'  => $href . $id . $href_query,
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
          'href'  => $href . $id . $href_query,
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
          'href'  => $href . $id . $href_query,
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
            'href'  => $href . $style->id . $href_query,
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
    $this->Template->url = $href_req;
    $this->Template->key = $key;
    $this->Template->next = $next;
    $this->Template->previous = $previous;
    $this->Template->default = $default;
    $this->Template->items = $items;
	}

	/**
	 * Add stylesheets to page HEAD.
	 *
	 * @param \Model\ZadSwitcherModel $switcher  The switcher data model
	 * @param int $actual  The actual style id
	 * @param string $key  The parameter name for setting styles
	 */
	protected function setPageHead($switcher, $actual, $key) {
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
    $this->Session->set($key, $style->id);
    $this->setCookie($key, $style->id, time() + 31536000, '/');
  }

	/**
	 * Get image SRC by file id.
	 *
	 * @param int $id  The id of the image
	 *
	 * @return string  The file path of the image
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

  /**
	 * Create a base URL and remove module parameters
	 *
	 * @param string $key  The parameter name for setting styles
	 * @param string $baseurl  Return the base URL
	 * @param string $queryurl  Return query string without module parameters
	 * @param string $requesturl  Return current url without module parameters
	 */
	protected function createBaseUrl($key, &$baseurl, &$queryurl, &$requesturl) {
    $base = explode('?', \Environment::get('request'));
    $q = '';
    // clean base url
    $base[0] = preg_replace('|/zsS_\d+/\d+|', '', $base[0]);
    // clean query string
    if (isset($base[1])) {
      // delete parameters
      $q = '&' . str_replace('&amp;', '&', $base[1]);
      $q = preg_replace('/&zsS_\d+=\d+/', '', $q);
      $q = str_replace('&', '&amp;', $q);
    }
    // return base url and query string
    $baseurl = $base[0] . "?$key=";
    $queryurl = $q;
    $requesturl = ($q == '') ? $base[0] : ($base[0].'?'.substr($q, 1));
  }

}

