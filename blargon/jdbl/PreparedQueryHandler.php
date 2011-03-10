<?
package('blargon.jdbl');

import('blargon.factory.DblFactory');
import('blargon.jdbl.PreparedQueryLoader');

class PreparedQueryHandler
{
	private $db;
	private $class;
	
	private $queryBuffer = null;
	private $methodBuffer;
	
	private $defaultNull = null;
	
	public function __construct( $class, $defaultNull=null )
	{
		if( !is_null( $defaultNull ) )
		{
			$this->defaultNull = $defaultNull;
		}
		$this->class = $class;
		$this->db = DblFactory::getConn();
	}
	
	public function execute( $method, $parms=array(), $key='default' )
	{
		if( is_null( $this->queryBuffer ) || ( $this->methodBuffer != $method ) )
		{
			$this->loadQueryString( $method, $key );
		}
		$query = $this->db->query( $this->replaceWildcards( $this->queryBuffer, $parms ) ) or die(mysql_error());
		if( $query )
		{
			return $query;
		}
		throw new InvalidQueryException('There was an error with the query or the method name or key');
	}
	
	public function replaceWildcards( $query, $replaces )
	{
		if( ( count( $replaces ) >= 1 ) && ( strtolower( $replaces[ count( $replaces ) - 1 ] ) == 'submit' ) )
		{
			array_splice( $replaces, -1 );
		}
		if( !is_null( $this->defaultNull ) )
		{
			$query = str_replace( '{0}', $this->defaultNull, $query );
			array_unshift( $replaces, $this->defaultNull );
		}
		$i = 0;
		while( $i < count( $replaces ) )
		{
			$query = str_replace( '{'.$i.'}', $replaces[ $i ], $query );
			$i++;
		}
		return $query;
	}
	
	public function loadQueryString( $method, $key='default' )
	{
		$hlp = new PreparedQueryLoader( $this->class, $method );
		try
		{
			$this->queryBuffer = $hlp->getQueryByKey( $key );
		}
		catch( QueryNotFoundException $e )
		{
			throw $e;
		}
	}
}
?>
