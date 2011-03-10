<?
header("Content-type: application/xml");

require_once '../../configuration/configure.php';

import('blargon.util.RSS');
$rss = new RSS();
?>
<?="<?xml version=\"1.0\"?".">"?>
<!-- generator="blargon/<?=$rss->getBlargonVersion()?>" -->
<rss version="0.92">
	<channel>
		<title><?=$rss->getSiteName()?></title>
		<link><?=$rss->getAlternateLink()?></link>
		<description><?=$rss->getDescription()?></description>
		<language>en-us</language>
		<docs>http://backend.userland.com/rss092</docs>
		<? while( false !== ( $entry = $rss->getNextPost() ) ) { ?>
		<item>
			<title><?=$entry->getTitle()?></title>
			<description><?=$entry->getReplacedContent()?></description>
			<link><?=$entry->getAlternateLink()?></link>
		</item>
		<? } ?>
	</channel>
</rss>
