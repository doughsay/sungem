<?php
namespace helpers\html;

function js($x) {
	if(!is_array($x)) { $x = [$x]; }
	$a = [];
	foreach($x as $src) {
		$a[] = "<script type='text/javascript' src='/js/$src.js'></script>";
	}
	return implode("\n", $a);
}

function css($x) {
	if(!is_array($x)) { $x = [$x]; }
	$a = [];
	foreach($x as $href) {
		$a[] = "<link rel='stylesheet' type='text/css' href='/css/$href.css'>";
	}
	return implode("\n", $a);
}

function table($data, $firstRowIsHeader = false) {
	$td = function($d) { return "<td>$d</td>"; };
	$th = function($h) { return "<th>$h</th>"; };
	$trd = function($row) use ($td) { return "<tr>".implode('', array_map($td, $row))."</tr>"; };
	$trh = function($row) use ($th) { return "<tr>".implode('', array_map($th, $row))."</tr>"; };
	$thead = function($s) { return "<thead>$s</thead>"; };
	$tbody = function($s) { return "<tbody>$s</tbody>"; };
	$table = function($s) { return "<table>$s</table>"; };

	$innerStuff = '';

	if($firstRowIsHeader) {
		$header = array_shift($data);
		$innerStuff = $thead($trh($header));
	}

	$innerStuff .= $tbody(implode("\n", array_map($trd, $data)));

	return $table($innerStuff);
}