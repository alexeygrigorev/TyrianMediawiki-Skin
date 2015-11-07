<?php
/**
 * 
 * @Version 1.0.0
 */

if (!defined('MEDIAWIKI')) {
  die(-1);
}


/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinTyrianMediaWiki extends SkinTemplate {

  public $skinname = 'tyrian-mediawiki';
  public $stylename = 'tyrian-mediawiki';
  public $template = 'TyrianMediaWikiTemplate';
  public $useHeadElement = true;

  public function initPage(OutputPage $out) {
    global $wgSiteJS;
    parent::initPage($out);
    $out->addModuleScripts('skins.tyrian-mediawiki');
    $out->addMeta('viewport', 'width=device-width, initial-scale=1.0');
    $out->addMeta('theme-color', '#54487a');
  }

  public function setupSkinUserCss(OutputPage $out) {
    global $wgSiteCSS;
    parent::setupSkinUserCss($out);

    $out->addModuleStyles('skins.tyrian-mediawiki');
  }
}

class TyrianMediaWikiTemplate extends QuickTemplate {
  public $skin;

  /**
   * Template filter callback for Bootstrap skin.
   * Takes an associative array of data set from a SkinTemplate-based
   * class, and a wrapper for MediaWiki's localization database, and
   * outputs a formatted page.
   *
   * @access private
   */
  public function execute() {
    global $wgRequest, $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink;
    global $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID;
    global $wgSiteCSS;
    global $wgEnableUploads;
    global $wgLogo;
    global $wgTOCLocation;
    global $wgNavBarClasses;
    global $wgSubnavBarClasses;

    $this->skin = $this->data['skin'];
    $action = $wgRequest->getText('action');
    $url_prefix = str_replace('$1', '', $wgArticlePath);

    // Suppress warnings to prevent notices about missing indexes in $this->data
    wfSuppressWarnings();
    $this->html('headelement');

    ?>
    <div class="ololo-wiki">

    <header class="wiki-header">
      <div class="site-title">
        <div class="container">
          <div class="row">
            <div class="site-title-buttons">
              <div class="btn-group">
                <div >
                  <form class="navbar-search navbar-form navbar-right" action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
                    <div class="input-group">
                      <input class="form-control" type="search" name="search" placeholder="Search" title="Search <?php echo $wgSitename; ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
                      <input type="hidden" name="title" value="Special:Search">
                      <div class="input-group-btn">
                        <input name="fulltext" value="Search" title="Search the pages for this text" id="mw-searchButton" class="searchButton btn btn-default" type="submit">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="wiki-title">
              <h1><a href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>"><?php echo $wgSitename ?></a></h1>
            </div>
          </div>
        </div>
      </div>

      <nav class="navbar navbar-grey navbar-sticky" id="wiki-actions" role="navigation">
        <div class="container">
          <div class="row">
            <ul class="nav navbar-nav">
              <li><a href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">Home</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $url_prefix; ?>Special:RecentChanges" class="recent-changes"><i class="fa fa-edit"></i> Recent Changes</a></li>
                  <li><a href="<?php echo $url_prefix; ?>Special:SpecialPages" class="special-pages"><i class="fa fa-star-o"></i> Special Pages</a></li>
                  <?php if ( $wgEnableUploads ) { ?>
                  <li><a href="<?php echo $url_prefix; ?>Special:Upload" class="upload-a-file"><i class="fa fa-upload"></i> Upload a File</a></li>
                  <?php } ?>
                </ul>
              </li>              
            </ul>

            <div> <!-- user zone -->
              <?php
              if ($wgUser->isLoggedIn()) {
                if (count($this->data['personal_urls']) > 0) {
                  $name = strtolower($wgUser->getName());
                  $user_nav = $this->get_array_links( $this->data['personal_urls'], $user_icon . $name, 'user' );
                  ?>
                  <ul<?php $this->html('userlangattributes') ?> class="nav navbar-nav navbar-right">
                    <?php echo $user_nav; ?>
                  </ul>
                  <?php
                }

                if ( count( $this->data['content_actions']) > 0 ) {
                  $content_nav = $this->get_array_links( $this->data['content_actions'], 'Page', 'page' );
                  ?>
                  <ul class="nav navbar-nav navbar-right content-actions"><?php echo $content_nav; ?></ul>
                  <?php
                }
              } else {  // not logged in
                ?>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                  <?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Userlogin' ), wfMsg( 'login' ) ); ?>
                  </li>
                </ul>
                <?php
              }
              ?>
            </div>
          <div>
        </div>
      </nav>  
    </header>

    <div id="wiki-outer-body">
      <div id="wiki-body" class="container">
        <?php
          if ( 'sidebar' == $wgTOCLocation ) {
            ?>
            <div class="row">
              <section class="col-md-3 toc-sidebar"></section>
              <section class="col-md-9 wiki-body-section">
            <?php
          }//end if
        ?>
        <?php if( $this->data['sitenotice'] ) { ?><div id="siteNotice" class="alert-message warning"><?php $this->html('sitenotice') ?></div><?php } ?>
        <?php if ( $this->data['undelete'] ): ?>
        <!-- undelete -->
        <div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
        <!-- /undelete -->
        <?php endif; ?>
        <?php if($this->data['newtalk'] ): ?>
        <!-- newtalk -->
        <div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
        <!-- /newtalk -->
        <?php endif; ?>

        <div class="pagetitle page-header">
          <h1><?php $this->html( 'title' ) ?> <small><?php $this->html('subtitle') ?></small></h1>
        </div>  

        <div class="body">
        <?php $this->html( 'bodytext' ) ?>
        </div>

        <?php if ( $this->data['catlinks'] ): ?>
        <div class="category-links">
        <!-- catlinks -->
        <?php $this->html( 'catlinks' ); ?>
        <!-- /catlinks -->
        </div>
        <?php endif; ?>
        <?php if ( $this->data['dataAfterContent'] ): ?>
        <div class="data-after-content">
        <!-- dataAfterContent -->
        <?php $this->html( 'dataAfterContent' ); ?>
        <!-- /dataAfterContent -->
        </div>
        <?php endif; ?>
        <?php
          if ('sidebar' == $wgTOCLocation ) {
            ?>
            </section></section>
            <?php
          }//end if
        ?>
      </div>
    </div>
    <hr/>
    <p></p>
    <footer>
      <div class="container">
        <div class="row">
          <div class="width: 15px;"></div>
          <div>
            <strong>2012 &ndash; <?php echo date('Y'); ?> by 
              <a href="http://alexeygrigorev.com">Alexey Grigorev</a></strong><br/>
            Powered by <a href="https://www.mediawiki.org">MediaWiki</a>. 
            Theme and style <a href="https://github.com/gentoo/tyrian">Tyrian</a> 
            by <a href="https://www.gentoo.org/">Gentoo</a>.<br/>
            <small>
              The contents of this document, unless otherwise expressly stated, are licensed under the
              <a href="http://creativecommons.org/licenses/by-sa/3.0/" rel="license">CC-BY-SA-3.0</a> license.
            </small>
          </div>
        </div>
      </div>
    </footer>
    <?php
    $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */
    $this->html('reporttime');
    ?>
    </div>
    </body>
    </html>
    <?php
  }

  /**
   * Render one or more navigations elements by name, automatically reveresed
   * when UI is in RTL mode
   */
  private function nav( $nav ) {
    $output = '';
    foreach ( $nav as $topItem ) {
      $pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
      if ( array_key_exists( 'sublinks', $topItem ) ) {
        $output .= '<li class="dropdown">';
        $output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $topItem['title'] . ' <b class="caret"></b></a>';
        $output .= '<ul class="dropdown-menu">';

        foreach ( $topItem['sublinks'] as $subLink ) {
          if ( 'divider' == $subLink ) {
            $output .= "<li class='divider'></li>\n";
          } elseif ( $subLink['textonly'] ) {
            $output .= "<li class='nav-header'>{$subLink['title']}</li>\n";
          } else {
            if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
              $href = $pageTitle->getLocalURL();
            } else {
              $href = $subLink['link'];
            }//end else

            $slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
            $output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']} {$slug}'>{$subLink['title']}</a>";
          }//end else
        }
        $output .= '</ul>';
        $output .= '</li>';
      } else {
        if( $pageTitle ) {
          $output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $topItem['title'] . '</a></li>';
        }//end if
      }//end else
    }//end foreach
    return $output;
  }//end nav

  /**
   * Render one or more navigations elements by name, automatically reveresed
   * when UI is in RTL mode
   */
  private function nav_select( $nav ) {
    $output = '';
    foreach ( $nav as $topItem ) {
      $pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
      $output .= '<optgroup label="'.strip_tags( $topItem['title'] ).'">';
      if ( array_key_exists( 'sublinks', $topItem ) ) {
        foreach ( $topItem['sublinks'] as $subLink ) {
          if ( 'divider' == $subLink ) {
            $output .= "<option value='' disabled='disabled' class='unclickable'>----</option>\n";
          } elseif ( $subLink['textonly'] ) {
            $output .= "<option value='' disabled='disabled' class='unclickable'>{$subLink['title']}</option>\n";
          } else {
            if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
              $href = $pageTitle->getLocalURL();
            } else {
              $href = $subLink['link'];
            }//end else

            $output .= "<option value='{$href}'>{$subLink['title']}</option>";
          }//end else
        }//end foreach
      } elseif ( $pageTitle ) {
        $output .= '<option value="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</option>';
      }//end else
      $output .= '</optgroup>';
    }//end foreach

    return $output;
  }//end nav_select

  private function get_page_links( $source ) {
    $titleBar = $this->getPageRawText( $source );
    $nav = array();
    foreach(explode("\n", $titleBar) as $line) {
      if(trim($line) == '') continue;
      if( preg_match('/^\*\*\s*divider/', $line ) ) {
        $nav[ count( $nav ) - 1]['sublinks'][] = 'divider';
        continue;
      }//end if

      $sub = false;
      $link = false;
      $external = false;

      if(preg_match('/^\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
        $sub = false;
        $link = true;
      }elseif(preg_match('/^\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
        $sub = false;
        $link = true;
        $external = true;
      }elseif(preg_match('/^\*\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
        $sub = true;
        $link = true;
        $external = true;
      }elseif(preg_match('/\*\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
        $sub = true;
        $link = true;
      }elseif(preg_match('/\*\*\s*([^\* ]*)(.+)/', $line, $match)) {
        $sub = true;
        $link = false;
      }elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
        $sub = false;
        $link = false;
      }

      if( strpos( $match[2], '|' ) !== false ) {
        $item = explode( '|', $match[2] );
        $item = array(
          'title' => $match[1] . $item[1],
          'link' => $item[0],
          'local' => true,
        );
      } else {
        if( $external ) {
          $item = $match[2];
          $title = $match[1] . $match[3];
        } else {
          $item = $match[1] . $match[2];
          $title = $item;
        }//end else

        if( $link ) {
          $item = array('title'=> $title, 'link' => $item, 'local' => ! $external , 'external' => $external );
        } else {
          $item = array('title'=> $title, 'link' => $item, 'textonly' => true, 'external' => $external );
        }//end else
      }//end else

      if( $sub ) {
        $nav[count( $nav ) - 1]['sublinks'][] = $item;
      } else {
        $nav[] = $item;
      }//end else
    }

    return $nav;  
  }//end get_page_links

  private function get_array_links( $array, $title, $which ) {
    $nav = array();
    $nav[] = array('title' => $title);
    foreach ($array as $key => $item) {
      $link = array(
        'id' => Sanitizer::escapeId($key),
        'attributes' => $item['attributes'],
        'link' => htmlspecialchars($item['href'] ),
        'key' => $item['key'],
        'class' => htmlspecialchars($item['class'] ),
        'title' => htmlspecialchars($item['text'] ),
      );

      if ('page' == $which) {
        switch ($link['title']) {
          case 'Page': 
            $icon = 'file';
            break;
          case 'Discussion': 
            $icon = 'comment'; 
            break;
          case 'Edit': 
            $icon = 'pencil';
            break;
          case 'History': 
            $icon = 'clock-o'; 
            break;
          case 'Delete': 
            $icon = 'remove'; 
            break;
          case 'Move': 
            $icon = 'arrows'; 
            break;
          case 'Protect': 
            $icon = 'lock'; 
            break;
          case 'Watch': 
            $icon = 'eye-open'; 
            break;
          case 'Unwatch': 
            $icon = 'eye-slash'; 
            break;
        }

        $link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
      } elseif ('user' == $which) {
        switch($link['title']) {
          case 'My talk': $icon = 'comment'; break;
          case 'My preferences': $icon = 'cog'; break;
          case 'My watchlist': $icon = 'eye-close'; break;
          case 'My contributions': $icon = 'list-alt'; break;
          case 'Log out': $icon = 'off'; break;
          default: $icon = 'user'; break;
        }

        $link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
      }

      $nav[0]['sublinks'][] = $link;
    }

    return $this->nav($nav);
  }


  function getPageRawText($title) {
    global $wgParser, $wgUser;
    $pageTitle = Title::newFromText($title);
    if (!$pageTitle->exists()) {
      return 'Create the page [[Bootstrap:TitleBar]]';
    } else {
      $article = new Article($pageTitle);
      $wgParserOptions = new ParserOptions($wgUser);
      // get the text as static wiki text, but with already expanded templates,
      // which also e.g. to use {{#dpl}} (DPL third party extension) for dynamic menus.
      $parserOutput = $wgParser->preprocess($article->getRawText(), $pageTitle, $wgParserOptions );
      return $parserOutput;
    }
  }

  function includePage($title) {
    global $wgParser, $wgUser;
    $pageTitle = Title::newFromText($title);
    if (!$pageTitle->exists()) {
      echo 'The page [[' . $title . ']] was not found.';
    } else {
      $article = new Article($pageTitle);
      $wgParserOptions = new ParserOptions($wgUser);
      $parserOutput = 
        $wgParser->parse($article->getRawText(), $pageTitle, $wgParserOptions);
      echo $parserOutput->getText();
    }
  }

  public static function link() { }
}