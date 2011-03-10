<?
/**
 * $Id: config.php,v 1.2 2005/07/06 18:44:42 blargon Exp $
 *
 * Japha configuration directives. The only required directive is the the classpath.
 *
 * @author <a href="mailto:gantt@cs.montana.edu">Ryan Gantt</a>
 * @version $Revision: 1.2 $
 */

/**
 * Each of these array entries refers to one path that the class files could be located in.
 *
 * If the class is found in the first path, then it is loaded. Otherwise, each path is searched for the class
 * until a match is found.
 *
 * @type String[]
 */
$classpath = array(
	'C:/htdocs/websheets',
	'C:/htdocs/japha3',
	'C:/htdocs'
);
?>