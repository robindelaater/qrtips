<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit46fdb6a03a49f4b220914cfedb276677
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

        spl_autoload_register(array('ComposerAutoloaderInit46fdb6a03a49f4b220914cfedb276677', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit46fdb6a03a49f4b220914cfedb276677', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        \Composer\Autoload\ComposerStaticInit46fdb6a03a49f4b220914cfedb276677::getInitializer($loader)();

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInit46fdb6a03a49f4b220914cfedb276677::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire46fdb6a03a49f4b220914cfedb276677($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire46fdb6a03a49f4b220914cfedb276677($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
