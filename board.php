<?php
require_once 'config.php';

use blargon\display\Display;

class ShowBoard extends Display {
	function show( $style ) {
		$content = '';
		$entries = $this->db->query('select id, user, time, entry from '.$this->config->get('prefix').'_board order by id desc limit 0,15');
		while( $entry = $this->db->fetchObject( $entries ) ) {
			$time = gmdate( $this->config->get( 'boardTime' ), ( $entry->time + ( 3600 * $this->config->get( 'timeOffset' ) ) ) );
			$info = $this->db->fetchObject( $this->db->query('select email, user from '.$this->config->get('prefix').'_user where id = \''.$entry->user.'\'') );
			
			$vars = array( 'style' => $style, 'time' => $this->lang->replaceGlobals( $time ), 'email' => $info->email, 'name' => $info->user, 'entry' => $entry->entry );
			
			$replacer = $this->template->setMethod( 'entry' );
			$replacer->addVariables( $vars );
			$content .= $this->template->createViewer( $replacer );
		}
		return $content;
	}
	
	function getSiteUrl() {
		return $this->config->get('siteUrl');
	}
	
	function getConfig() {
		return $this->config;
	}
}

$sb = new ShowBoard( $_GET['language'] );
$style = 'background-color:#0033CC; width:100%; height:100%; margin-top:0px; margin-bottom:0px;';
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="templates/<?php echo $sb->getConfig()->get('theme');?>/style/shell.css"/>
</head>
<body class="boardBody">
<table cellpadding="0" cellspacing="0" width="100%">
<?php echo $sb->show( $style );?>
</table>
</body>
</html>