<?php
include 'includes/header.php';

// // // Inherintance - Herencia

// class Person // Se puede Instanciar
abstract class Person // NO se puede instanciar
{
	protected $name;
	protected $lastName;
	protected $email;
	protected $phone;

	public function __construct(string $name, string $lastName, string $email, string $phone)
	{
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
}


class Employee extends Person
{
	protected $code;
	protected $department;

	public function __construct(
		string $name,
		string $lastName,
		string $email,
		string $phone,
		int $code,
		string $department
	) {
		parent::__construct($name, $lastName, $email, $phone);

		$this->code = $code;
		$this->department = $department;
	}
}

class Supplier extends Person
{
	protected $company;

	public function __construct(
		string $name,
		string $lastName,
		string $email,
		string $phone,
		string $company
	) {
		parent::__construct($name, $lastName, $email, $phone);

		$this->company = $company;
	}

	public function getCompany()
	{
		return $this->company;
	}
}


$alex = new Supplier('Alex', 'Axes', 'alex@axes.com', '3333333', 'SEOMADY');
$alex->showUserInfo();

echo $alex->getCompany();
