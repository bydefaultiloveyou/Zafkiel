<?php

namespace Zafkiel;

class Classloader
{

    private static $directories;

    public static function initialize()
    {

        self::$directories =
            require __DIR__ . "/autoload-psr4.php";

        spl_autoload_register(function ($classname) {

            // merubah namepace menjadi array
            $classname = explode("\\", $classname);

            // hapus array index 0 yang dimana nama awal namespace
            // contoh App\Controller\HomeController -> Contoller\HomeController
            unset($classname[0]);

            // looping semua directory yang telah di berikan di zafkiel.json
            foreach (self::$directories as $directory) {

                $dir = __DIR__ . "/../" . $directory . implode("/", $classname) . ".php";

                // check aoakah file ada di ada sesuai dengan name space yang di berikan
                if (file_exists($dir))
                    require $dir;
            }
        });
    }
}
