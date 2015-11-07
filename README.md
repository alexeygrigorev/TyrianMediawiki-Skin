# TyrianMediawiki-Skin

A bootstrap-based skin for MediaWiki


- Uses Gentoo Tyrian styles https://github.com/gentoo/tyrian
- Skin code largely borrowed from http://borkweb.github.io/bootstrap-mediawiki/


## Installation 

First, navigate to the folder with MediaWiki installation, and then

	git clone https://github.com/alexeygrigorev/TyrianMediawiki-Skin.git skins/TyrianMediawiki-Skin/

After that, add the following to `LocalSettings.php`:

	$wgDefaultSkin = 'tyrian-mediawiki';
	require_once "$IP/skins/TyrianMediawiki-Skin/tyrian-mediawiki.php";



## Running instances 

- Currently, it's run at http://mlwiki.org
