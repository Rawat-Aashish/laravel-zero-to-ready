<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit304c5e768250ebd9243727d5b0a0ef41
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit304c5e768250ebd9243727d5b0a0ef41', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit304c5e768250ebd9243727d5b0a0ef41', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit304c5e768250ebd9243727d5b0a0ef41::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
