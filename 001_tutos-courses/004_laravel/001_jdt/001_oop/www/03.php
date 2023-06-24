<?php
include 'includes/header.php';

// properties - atributes
class Employee
{
	public $name;
	public $lastName;
	public $department;
	protected $email;
	public $code;

	public function __construct(string $name, string $lastName, string $email, int $code)
	{
		$this->name = $name;
		$this->lastName = $lastName;
		$this->department = $lastName;
		$this->email = $email;
		$this->code = $code;

		// $this->employeeName();
		// $this->employeeNameProtected(); // protected - SOLO la Class - SI herencia
		// $this->employeeNamePrivate();
	}

	public function employeeName()
	{
		echo 'some echo ' . $this->name . ' ' . $this->lastName;
	}

	// solo en classes, SI inheritance
	protected function employeeNameProtected()
	{
		echo 'some echo ' . $this->name . ' ' . $this->lastName;
	}

	// solo esta class, NO inheritance
	private function employeeNamePrivate()
	{
		echo 'some echo ' . $this->name . ' ' . $this->lastName;
	}


	// // getter & setter
	public function getName()
	{
		return $this->name;
	}

	public function setEmail($email) {
		$this->email = $email;
	}
}

$employee = new Employee('Alex', 'Axes', 'TI', 420);
$employee2 = new Employee('Sol', 'Mejia', 'MK', 589);

echo "<pre>";
var_dump($employee, $employee2);
echo "</pre>";


// // modificadores de acceso
$employee->employeeName();
// $employee->employeeNameProtected();  // protected NO a las instancias, SOLO classes - NO herencia
// $employee->employeeNamePrivate();  // protected NO a las instancias, SOLO classes - SI herencia


// // getter & setter
echo '<pre>';
var_dump($employee->getName());
echo '</pre>';

$employee->setEmail('new@email.com');
echo '<pre>';
var_dump($employee);
echo '</pre>';


