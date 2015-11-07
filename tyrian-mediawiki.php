<?php
/**
 * Bootstrap MediaWiki
 *
 * @ingroup Skins
 */
if (!defined('MEDIAWIKI')) {
  die("This is an extension to the MediaWiki package and cannot be run standalone.");
}

$wgExtensionCredits['skin'][] = array(
  'path'        => __FILE__,
  'name'        => 'Tyrian Mediawiki',
  'url'         => 'http://mlwiki.org',
  'author'      => 'Alexey',
  'description' => 'MediaWiki skin using Bootstrap 3',
);

$wgValidSkinNames['tyrian-mediawiki'] = 'TyrianMediaWiki';
$wgAutoloadClasses['SkinTyrianMediaWiki'] = __DIR__ . '/TyrianMediaWiki.skin.php';

$skinDirParts = explode(DIRECTORY_SEPARATOR, __DIR__);
$skinDir = array_pop($skinDirParts);


$wgResourceModules['skins.tyrian-mediawiki'] = array(
  'styles' => array(
    $skinDir . '/assets/bootstrap.min.css' => array('media' => 'screen'),
    $skinDir . '/assets/tyrian.min.css' => array('media' => 'screen'),
    $skinDir . '/assets/tyrian-wiki.css' => array('media' => 'screen'),
  ),
  'scripts' => array($skinDir . '/assets/bootstrap.js'),
  'dependencies' => array('jquery'),
  'remoteBasePath' => &$GLOBALS['wgStylePath'],
  'localBasePath'  => &$GLOBALS['wgStyleDirectory'],
);