<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7e90b60c9989d4cafd4217975ebcf1f4
{
    public static $classMap = array (
        'IXWDA\\Main' => __DIR__ . '/../..' . '/classes/class-main.php',
        'IXWDA\\Output' => __DIR__ . '/../..' . '/classes/class-output.php',
        'IXWDA\\Register_Field' => __DIR__ . '/../..' . '/classes/class-register-field.php',
        'IXWDA\\Requirements' => __DIR__ . '/../..' . '/classes/class-requirements.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit7e90b60c9989d4cafd4217975ebcf1f4::$classMap;

        }, null, ClassLoader::class);
    }
}
