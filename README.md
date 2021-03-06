#Overview

This package contains testing to verify that the Zend Framework validator plugin 
manager (Zend/Validator/ValidatorPluginManager) is configured to provide 
validators from the jim-moser/zf2-validators-empty-or package. In essence this 
package verifies that the jim-moser/zf2-validators-empty-or-plugin package has 
successfully integrated the validators from the 
jim-moser/zf2-validators-empty-or package into the Zend Framework installation.

Related packages:

* [jim-moser/zf2-validators-empty-or](https://github.com/jim-moser/zf2-validators-empty-or/)
* [jim-moser/zf2-validators-empty-or-test](https://github.com/jim-moser/zf2-validators-empty-or-test/)
* [jim-moser/zf2-validators-empty-or-plugin](https://github.com/jim-moser/zf2-validators-empty-or-plugin/)
* [jim-moser/zf2-validators-empty-or-plugin-test](https://github.com/jim-moser/zf2-validators-empty-or-plugin-test/)
	
A brief description of the related packages listed above can be found in the 
README.md file for the 
[jim-moser/zf2-validators-empty-or](https://github.com/jim-moser/zf2-validators-empty-or/) 
package.

#Dependencies

The code provided by this package only depends directly on code and classes 
provided by the following packages:
	jim-moser/zf2-validators-empty-or
	jim-moser/zf2-validators-empty-or-plugin
	laminas/laminas-loader
	laminas/laminas-mvc
	laminas/laminas-servicemanager
	phpunit/phpunit
	 
However it appears that the code within laminas-mvc and/or its' dependencies has 
several dependencies on code and classes within various laminas packages not 
specified as dependencies within the composer.json files of laminas-mvc and its' 
dependencies. To prevent this issue from causing problems, these missing 
dependencies have been added to the composer.json file of this package. The 
additional dependencies added under the "requires" section of the composer.json 
file are:
        laminas/laminas-i18n
        laminas/laminas-log
        laminas/laminas-serializer
        laminas/laminas-view

#Installation

##Alternative 1: Installation with Composer

1. For an existing Zend Framework installation, move into the parent of the 
	vendor directory. This directory should contain an existing composer.json 
	file. For a new installation, move into the directory you would like to 
	contain the vendor directory.

		$ cd <parent_path_of_vendor>	
	
2. Run the following command which will update the composer.json file, install 
	the zf2-validators-empty-or-plugin-test package and its dependencies into 
	their respective directories under the vendor directory, and update the 
	composer autoloading files.

		$ composer require jim-moser/zf2-validators-empty-or-plugin-test
		
##Alternative 2: Manual Installation to Vendor Directory

If you would like to install the packages manually and use a Module.php file to 
configure autoloading instead of using Composer to configure autoloading then 
see the installation section of the README.md file in the  
[jim-moser/zf2-validators-empty-or-plugin](https://github.com/jim-moser/zf2-validators-empty-or-plugin/) 
package.

#Running the Tests

After installation testing can be run immediately from the 
vendor/jim-moser/zf2-validators-empty-or-plugin-test directory as follows:

	$ cd <vendor_directory>/jim-moser/zf2-validators-empty-or-plugin-test
	$ php ../../phpunit/phpunit/phpunit

The second command above calls phpunit from the phpunit package installed under 
the vendor directory instead of any phpunit executable which may be installed 
system wide. This is done to ensure the version of PHPUnit executed is one that 
meets the version requirements specified in the composer.json file.