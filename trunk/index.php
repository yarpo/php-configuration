<?php

$xml = "
<settings>
	<item name='jeden' value='wartosc'/>
	<item name='dwa' value='wartosc'/>
</settings>";

$o = new SimpleXMLElement($xml);

$n = count((array)$o->item);

$res = array();

for($i = 0; $i < $n; $i++)
{
	$attr = $o->item[$i]->attributes();
	foreach($attr as $field => $value)
	{
		$res[$field] = strval($value);
	}
}

echo '<pre>';
print_r($res);


