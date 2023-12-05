<?php
/**
 * module 'xml.php'
 * 
 * function lire_xml(...) 
 */
function lire_xml(string $fileName)
{
    $xml = simplexml_load_file('../data/' . $fileName);

    function XML2Array(SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = &$array[$name])
                && (is_array($node) || ($node = array($node)))
                && $node = &$node[];

            $node = $element->count() ? XML2Array($element) : trim($element);
        }

        return $array;
    }
    var_dump(XML2Array($xml));
    return;
}
?>