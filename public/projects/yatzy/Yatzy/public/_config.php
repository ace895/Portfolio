<?php
$GLOBALS["appDir"] = resolve_path("app");
$GLOBALS["vendorDir"] = resolve_path("vendor");
require_once $GLOBALS["vendorDir"] . "/autoload.php";

$GLOBALS["dbConfig"] = [
    "host" => "localhost",
    "dbname" => "yatzy",
    "user" => "postgres", 
    "password" => "password"
];

function resolve_path($name)
{
    if ($name == ".")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
        $appRoot = $_SERVER["DOCUMENT_ROOT"];
    }
    else if ($_SERVER["DOCUMENT_ROOT"] != "")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/../$name";
        $appRoot = $_SERVER["DOCUMENT_ROOT"] . "/$name";
    }
    else
    {
        return "../{$name}";
    }

    return file_exists($publicRoot) ? realpath($publicRoot) : realpath($appRoot);
}

spl_autoload_register(function ($fullName) {
    $parts = explode("\\", $fullName);
    $len = count($parts);
    $className = $parts[$len - 1];
    if (file_exists($GLOBALS["appDir"] . "/models/{$className}.php"))
    {
      require_once $GLOBALS["appDir"] . "/models/{$className}.php";
    }
});

?>