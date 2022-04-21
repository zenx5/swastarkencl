<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita7f6ee8ace3dd76b8321980e0c5016bc
{
    public static $files = array (
        '3f72034fca05792b93a19b20b4cd2e76' => __DIR__ . '/../..' . '/classes/SwastarkenclState.php',
        '26373cbd66c85772ad9a6ab7e842f370' => __DIR__ . '/../..' . '/classes/SwastarkenclDocumentType.php',
        '487e9fd11e5236d30c8a67f74b8989ca' => __DIR__ . '/../..' . '/classes/SwastarkenclDeliveryType.php',
        '443bc2423246ee8a0c98b573cd7eb925' => __DIR__ . '/../..' . '/classes/SwastarkenclServiceType.php',
        '1d9269a43f2e14b4905130a7d44f2d46' => __DIR__ . '/../..' . '/classes/SwastarkenclPaymentType.php',
        '38baa90e4bce62be955a50dd876429b8' => __DIR__ . '/../..' . '/classes/SwastarkenclCarrier.php',
        'bc3c732e07e06800eb18ffea0ffe86be' => __DIR__ . '/../..' . '/classes/SwastarkenclEmision.php',
        '01554916bb5935a7b9bf42e263e7fc78' => __DIR__ . '/../..' . '/classes/SwastarkenclCustomersAgency.php',
        'd07c63864f430e342ec89d008a5fe56f' => __DIR__ . '/../..' . '/classes/SwastarkenclLogs.php',
    );

    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Curl\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Curl\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita7f6ee8ace3dd76b8321980e0c5016bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita7f6ee8ace3dd76b8321980e0c5016bc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita7f6ee8ace3dd76b8321980e0c5016bc::$classMap;

        }, null, ClassLoader::class);
    }
}