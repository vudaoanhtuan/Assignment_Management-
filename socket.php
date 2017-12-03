<?php
	function sent_data($str) {
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$address = gethostname();
			$port = 10000;

			$sockconnect = socket_connect($socket, $address, $port);

			socket_write($socket, $str, strlen($str));
			$out = socket_read($socket, 1024);

			socket_close($socket);

	}
?>