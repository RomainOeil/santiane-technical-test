<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit23d4bf5a8e48f9ccfc99955a21c0a55f
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

        spl_autoload_register(array('ComposerAutoloaderInit23d4bf5a8e48f9ccfc99955a21c0a55f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit23d4bf5a8e48f9ccfc99955a21c0a55f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit23d4bf5a8e48f9ccfc99955a21c0a55f::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInit23d4bf5a8e48f9ccfc99955a21c0a55f::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire23d4bf5a8e48f9ccfc99955a21c0a55f($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire23d4bf5a8e48f9ccfc99955a21c0a55f($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
