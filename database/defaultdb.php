<?php
    require_once('createdb.php');
    $create = CreateDb::getInstance();
    
    $create->dropTables();
    $create->loadAllTables();

    $create->addUser('root', 'root');
?>
