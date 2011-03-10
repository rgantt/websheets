<?
header("Content-type: application/atom+xml");

require_once '../../configuration/configure.php';
import('blargon.util.Atom');

$atom = new Atom();
?>
<?='<?xml version="1.0" encoding="utf-8"?'.'>'?>
<feed version="0.3" xml:lang="en-US" xmlns="http://purl.org/atom/ns#">
	<title><?=$atom->getSiteName()?></title>
	<link rel="alternate" type="text/html" href="<?=$atom->getAlternateLink()?>" />
	<tagline><?=$atom->getDescription()?></tagline>
	<generator url="<?=$atom->getBlargonUrl()?>" version="<?=$atom->getBlargonVersion()?>">Blargon</generator>
	<modified></modified>
	<? while( false !== ( $entry = $atom->getNextPost() ) ) { ?>
	<entry>
		<title type="text/plain" mode="xml"><?=$entry->getTitle()?></title>
		<link rel="alternate" type="text/html" href="<?=$entry->getAlternateLink()?>" />
		<author>
			<name><?=$entry->getAuthorName()?></name>
		</author>
		<id><?=$entry->getId()?></id>
		<issued><?=$entry->getPostedDate()?></issued>
		<modified><?=$entry->getModifiedDate()?></modified>
		<content type="text/html" mode="escaped"><![CDATA[<?=$entry->getReplacedContent()?>]]></content>
	</entry>
	<? } ?>
</feed>
