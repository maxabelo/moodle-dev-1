# Notes

- --- Agregar campos al    `$OUTPUT`     de moodle, a la variable global

```php
//var_dump($templatecontext['output']->unique_end_html_token);die();

$templatecontext['output']->page->course->otherrss = 'Othersss name UPDATED';
print_object($templatecontext['output']->page->course->otherrss);die();

//$templatecontext['output']->alexxx = 'Othersss name UPDATED';
//print_object($templatecontext['output']->alexxx);die();

//$templatecontext['output']->supportemail = 'Othersss name UPDATED';
//print_object($templatecontext['output']->page);die();
```


- Q es un Reverse Proxi?
	- Auth con microservice con Google Cloud
		- Token x microservice

