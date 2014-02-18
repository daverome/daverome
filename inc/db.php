<?php
date_default_timezone_set( 'UTC' );

define('SQLITE_FILE', 'items.sqlite3');


function createTable() {
    global $dbh;
    $dbh->exec("CREATE TABLE IF NOT EXISTS items (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    added TEXT NOT NULL,
    modified TEXT DEFAULT NULL)");
}

function createFakeData() {
    global $dbh;
    for( $i = 0; $i < 10; $i ++) {
        createItem('Item ' . ($i + 1));
    }
}

//***************************************************************************
//
//***************************************************************************
function createItem($name) {
    global $dbh;

    $stmt = $dbh->prepare("INSERT INTO items VALUES(null, :name, :added, null)");
    $stmt->bindParam( ':name', $name );
    $stmt->bindParam( ':added', date('Y-m-d g:i:s', time()) );
    return $stmt->execute();
}

function readItem($id=null) {
    global $dbh;

    if( $id ) { //Get Single Item
        $stmt = $dbh->prepare("SELECT * FROM items WHERE id=:id LIMIT 1");
        $stmt->bindParam( ':id', $id );
    }
    else { //Get All Items
        $stmt = $dbh->prepare("SELECT * FROM items");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateItem($name, $id) {
    global $dbh;

    $stmt = $dbh->prepare("UPDATE items SET name=:name, modified=:modified WHERE id=:id");
    $stmt->bindParam( ':name', $name );
    $stmt->bindParam( ':modified', date('Y-m-d g:i:s', time()) );
    $stmt->bindParam( ':id', $id );
    return $stmt->execute();
}

function deleteItem($id) {
    global $dbh;

    $stmt = $dbh->prepare("DELETE FROM items WHERE id=:id");
    $stmt->bindParam( ':id', $id );
    return $stmt->execute();
}


try {
    $init_table = false;
    if ( !file_exists(  getcwd() . '/' . SQLITE_FILE ) ) {
        $init_table = true;
    }

    $dbh = new PDO('sqlite:' . SQLITE_FILE);

    if( $init_table ) {
        createTable();
        createFakeData();
    }
}
catch(PDOException $e) {
    print 'Exception : '.$e->getMessage();
}

