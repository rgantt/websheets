<?php
package('sedai.parser');

class SedaiParser
{
	protected $dir;
	protected $name;
	protected $format;
	protected $haystack;
	
	protected $pos = 0;
	
	public function __construct( $dir, $name, $key )
	{
		$this->file = $dir.'/'.$name;
		require $this->file;
		$this->haystack = $template[ $key ];
	}
	
	public function setFormat( $format )
	{
		$this->format = array( 'start' => $format[0], 'access' => $format[2], 'end' => $format[4] );
	}
	
	public function getFormat()
	{
		return $this->format;
	}
	
	public function getPos()
	{
		return $this->pos;
	}
	
	public function setPos( $pos )
	{
		$this->pos = $pos;
	}
	
	public function getHaystack()
	{
		return $this->haystack;
	}
	
	public function getNext()
	{
		$this->setPos( strpos( $this->haystack, $this->format['start'], $this->getPos() ) );
		if( $this->getPos() === false )
		{
			return false;
		}
		else
		{
			$n = $this->getPos(); $cmd = '';
			while( $this->haystack{ $n } != $this->format['end'] )
			{
				$cmd .= $this->haystack{ $n++ };
			}
			$this->setPos( $n );
		}
		return $cmd;
	}
}