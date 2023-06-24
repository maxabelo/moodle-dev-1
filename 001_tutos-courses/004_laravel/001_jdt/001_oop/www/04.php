<?php
include 'includes/header.php';

// Constructor property Promotion
class Employee
{
	public function __construct(
		public $name,
		public $lastName,
		public $department,
		public $email,
		public $code
	) {
	}
}

$employee = new Employee('Alex', 'Axes', 'TI', 420);
$employee2 = new Employee('Alex', 'Axes', 'TI', 589);

echo "<pre>";
var_dump($employee, $employee2);
echo "</pre>";
