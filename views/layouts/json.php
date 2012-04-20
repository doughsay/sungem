<?php
$json = function($content) {
	header('Content-Type:application/json');
	echo json_encode($content);
};