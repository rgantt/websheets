<?
package('blargon.messages');

import('japha.util.Stack');
import('blargon.messages.Message');

class MessageStack extends Stack
{
	public function push( Message $object )
	{
		parent::push( $object );
	}
}
?>
