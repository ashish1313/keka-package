﻿# keka-package
[![Issues](https://img.shields.io/github/issues/som-31/keka-package.svg?style=flat-square)](https://github.com/som-31/keka-package/issues)
[![Stars](https://img.shields.io/github/stars/som-31/keka-package.svg?style=flat-square)](https://github.com/som-31/keka-package/stargazers)


##A wrapper for Keka API implemented by Successive technologies

##First set the below env variables in your .env file : 
- keka_client_id=your_keka_client_id
- keka_secret_key=your_keka_secret_key
- api_key=your_api_key

```php
$employeeService = new EmployeeService();
$response =  $employeeService->getEmployees('employee_number');
