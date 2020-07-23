<?php
namespace JimMoser\ValidatorPluginTest;

use Laminas\Loader\AutoloaderFactory;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Bootstrap for unit testing.
 * 
 * Module loading and autoloading for unit testing. The autoloading is provided 
 * in case Composer autoloading is not being used.
 * 
 * @author    Jim Moser <jmoser@epicride.info>
 * @link      http://github.com/jim-moser/zf2-validators-empty-or-plugin-test 
 *            for source repository
 * @copyright Copyright (c) July 14, 2016 Jim Moser
 * @license   LICENSE.txt at http://github.com/jim-moser/
 *            zf2-validators-empty-or-plugin-test  
 *            New BSD License
 */
class Bootstrap
{
    protected static $serviceManager;

    public static function init()
    {
    	$zf2ModulePaths = array(dirname(dirname(__DIR__)));
        if ($path = static::findParentPath('vendor')) {
            $zf2ModulePaths[] = $path;
        }
        if ($path = static::findParentPath('module')) {
            if ($path !== $zf2ModulePaths[0]) {
                $zf2ModulePaths[] = $path;
            }
        }

        static::initAutoloader();

        // Add test directories to autoloader search path since some tests
        // call classes in these directories.
        // Needed for when Composer autoloading not used.
        AutoLoaderFactory::factory(array(
            //'Laminas\Loader\ClassMapAutoloader' => array(
            //),
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__  => __DIR__,
                    // This script may also be used by 
                    // zf2-validators-empty-or-test package if Composer 
                    // autoloading not used.
                    'JimMoser\ValidatorTest' => dirname(dirname(__DIR__)) . 
                        str_replace('/', DIRECTORY_SEPARATOR,
                            '/zf2-validators-empty-or-test/test/'),
                ),
            ),
        ));
        
        // Use ModuleManager to load this module and it's dependencies
        $zf2ModulePaths['JimMoser\Validator'] = dirname(dirname(__DIR__)) . 
            str_replace('/',
                        DIRECTORY_SEPARATOR,
                        '/zf2-validators-empty-or-plugin/'
            );
        $config = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
            'modules' => array(
                'JimMoser\Validator'
            ),
        );
        
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
    	$vendorPath = static::findParentPath('vendor');

    	// Composer autoloading.
    	if (file_exists($vendorPath . '/autoload.php')) {
    		$loader = include $vendorPath .'/autoload.php';
    	}
    	
    	// If composer was not used to install Zendframework2 then search
    	// for path of Zendframework installation as follows:
    	//    first look in 'ZF2_PATH' environment variable,
    	//    second, check for php.ini defined 'ZF2_PATH' variable,
    	//    finally, check in 'vendor/ZF2/library'.
    	
    	if (class_exists('Laminas\Loader\AutoloaderFactory')) {
    	    return;
    	}
        $zf2Path = getenv('ZF2_PATH');
        if (!$zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } else {
                if (is_dir($vendorPath . '/ZF2/library')) {
                    $zf2Path = $vendorPath . '/ZF2/library';
                }
            }
        }

        if (!$zf2Path) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Laminas\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}
Bootstrap::init();