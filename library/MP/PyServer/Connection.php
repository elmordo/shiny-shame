<?php
class MP_PyServer_Connection {

	private static $_host = "127.0.0.1";

	private static $_port = 53535;

	public static function sendRequest(MP_PyServer_Request $request) {
		// otevreni spojeni a poslani requestu
		$conn = self::_openConnection();
		fwrite($conn, $request->serialize());
		fclose($conn);
	}

	protected static function _closeConnection($connection) {
		fclose($connection);
		sleep(2);
	}

	protected static function _openConnection() {
		// vytvoreni spojeni a vraceni handleru
		$conn = fsockopen(self::$_host, self::$_port);

		// pokud spojeni nebylo vytvoreno, pokusime se spustit server
		if (!$conn) {
			exec("cd " . APPLICATION_PATH . "/../python; sh start");
<<<<<<< HEAD
			sleep(1);
=======
>>>>>>> 1f928b7afaf2d10b5e3488099cbbb6e02d377864
			$conn = fsockopen(self::$_host, self::$_port);
		}

		// kontrola, zda bylo spojeni navazano
		if (!$conn) throw new MP_PyServer_Exception("Unable to connect python server", 1);
		
		return $conn;
	}
}