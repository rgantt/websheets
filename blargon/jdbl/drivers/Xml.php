<?
import("japhax.sql.Database");

/**
 * $Id: Xml.php,v 1.1.1.1 2005/07/06 17:28:54 blargon Exp $
 *
 * @author Ryan Gantt
 * @version $Revision: 1.1.1.1 $
 */
class Xml extends Database
{
	protected $queryString;
	protected $linkId;
	protected $resultId;

        function __construct(){}

        function connect( $login = array() )
        {
		return true;
        }

        function select_db( $dbName )
        {
		$f = dir( $dbName );
		while( ( $entry = $f->read() ) !== false )
		{
			if( !is_writeable( $dbName.'/'.$entry ) && ( $entry != '.' ) && ( $entry != '..' ) )
			{
				return false;
			}
		}
		return true;
        }

        function query( $query )
        {
                $queryId = mysql_query( $query, $this->linkId );
                if(!$queryId)
                {
			return false;
                }
                else
                {
                        $this->resultId = $queryId;
                        return $queryId;
                }
        }

        function close()
        {
            return mysql_close( $this->linkId );
        }

	function fetch_object( $query )
	{
		return mysql_fetch_object( $query );
	}

	function fetch_row( $query )
	{
		return mysql_fetch_row( $query );
	}

        function num_rows( $query )
        {
            return mysql_num_rows( $query );
        }

	function fetch_array( $query )
	{
		return;
	}

	function num_fields()
	{
		return;
	}
	
	function get_error()
	{
		return mysql_error( $this->linkId );
	}
	
	function get_connection()
	{
		return $this->linkId;
	}
}
?>
