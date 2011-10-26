<?php
header('Content-type: application/atom+xml');

require_once '../../configuration/configure.php';
import('blargon.util.Atom');

$atom = new Atom();
?>
<?='<?xml version="1.0" encoding="utf-8"?>'?>
<feed xmlns="http://purl.org/atom/ns#draft-ietf-atompub-format-09">
	<title type="text"><?=$atom->getSiteName()?></title>
	<subtitle type="html"><?=$atom->getSubTitle()?></subtitle>
	<updated><?=$atom->getUpdated()?></updated>
	<id><?=$atom->getId()?></id>
	<link rel="alternate" type="text/html" hreflang="en" href="<?=$atom->getAlternateLink()?>"/>
	<rights><?=$atom->getRights()?></rights>
	<generator uri="http://blargon.japha.net/" version="<?=$atom->getBlargonVersion()?>">Blargon <?=$atom->getBlargonVersion()?></generator>
	<? while( false !== ( $entry = $atom->getNextPost() ) ) { ?>
	<entry>
		<title><?=$entry->getTitle()?></title>
		<id><?=$entry->getId()?></id>
		<updated><?=$entry->getUpdated()?></updated>
		<published><?=$entry->getPublished()?></published>
		<author>
			<name><?=$entry->getAuthorName()?></name>
			<email><?=$entry->getAuthorEmail()?></email>
		</author>
		<content type="xhtml" xml:lang="en" xml:base=""><?=$entry->getReplacedContent()?></content>
	</entry>
	<? } ?>
</feed>
