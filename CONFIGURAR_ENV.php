<?php
// Script de instalación local: selecciona SQLite sin revelar credenciales.
$file=$argv[1]??'';
if (!$file || !is_file($file)) {fwrite(STDERR,"No existe .env.\n");exit(1);}
$text=file_get_contents($file);
$text=preg_replace('/^DB_CONNECTION=.*$/m','DB_CONNECTION=sqlite',$text);
$text=preg_replace('/^(DB_HOST|DB_PORT|DB_DATABASE|DB_USERNAME|DB_PASSWORD)=/m','#$1=',$text);
file_put_contents($file,$text);
echo "Configuración local SQLite aplicada.\n";
