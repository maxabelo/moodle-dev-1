<?php
include 'includes/header.php';


// // // Static Methods:    (  ::  )
// NO requieren ser instanciados
class Person
{
	protected $name;
	protected $lastName;
	protected $email;
	protected $phone;

	protected static $nickname;

	public function __construct(string $name, string $lastName, string $email, string $phone)
	{
		self::$nickname = $name . "_" . $lastName;

		$this->name = $name;
		$this->lastName = $lastName;
		$this->department = $lastName;
		$this->email = $email;
		$this->code = $phone;

		// $this->employeeName();
		// $this->employeeNameProtected(); // protected - SOLO la Class - SI herencia
		// $this->employeeNamePrivate(); // solo la Class - NO herencia
	}

	public function showUserInfo()
	{
		echo 'Name: ' . $this->name . ' ' . $this->lastName . ' | ' . $this->email;
	}

	
	// // // static: Le pertenece SOLO a la Class   y NOOO a sus instancias
	public static function concatNameAndLastname()
	{
		echo 'Static Method';
	}

	public static function getNickname() {
		return self::$nickname;
	}
}

Person::concatNameAndLastname();

$juan = new Person('Juan', 'DT', 'sd@sd.com', '1212');
echo '<pre>';
var_dump($juan::getNickname());
echo '</pre>';

