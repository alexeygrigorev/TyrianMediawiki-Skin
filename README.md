# TyrianMediawiki-Skin

A bootstrap-based skin for MediaWiki


- Uses [Gentoo Tyrian](https://github.com/gentoo/tyrian) design 
- Skin code is largely based on http://borkweb.github.io/bootstrap-mediawiki/


## Installation 

First, navigate to the folder with MediaWiki installation, and then

	git clone https://github.com/alexeygrigorev/TyrianMediawiki-Skin.git skins/TyrianMediawiki-Skin/

After that, add the following to `LocalSettings.php`:

	$wgDefaultSkin = 'tyrian-mediawiki';
	require_once "$IP/skins/TyrianMediawiki-Skin/tyrian-mediawiki.php";



## Running instances 

- Currently, it's run at http://mlwiki.org
