<?php
require_once( 'inc/db.php' );

$id         = (int) (isset( $_GET['id']) ? trim(strip_tags($_GET['id'])) : '' ) ;
$is_POST    = $_SERVER['REQUEST_METHOD']  === 'POST';
$is_PUT     = $_SERVER['REQUEST_METHOD']  === 'PUT';
$is_DELETE  = $_SERVER['REQUEST_METHOD']  === 'DELETE';
$is_GET     = !$is_POST && !$is_PUT && !$is_DELETE;

//***************************************************************************
// GET /items
//***************************************************************************
if ( $is_GET && !$id ) {
    //echo 'GET /items';
    $items = readItem();
    echo json_encode( array( 'items' => $items ) );
}


//***************************************************************************
// GET /items/id
//***************************************************************************
if ( $is_GET && $id ) {
    //echo 'GET /items/id';
    $item = readItem( $id );
    echo json_encode( $item );
}


//***************************************************************************
// POST /items
//***************************************************************************
if ( $is_POST && !$id ) {
    $json = file_get_contents("php://input");
    if( $json ) {
        $data = json_decode( $json );
        if( $data && $data->item->name ) {
            createItem( $data->item->name );
        }
    }
}

//***************************************************************************
// PUT /items/id
//***************************************************************************
if ( $is_PUT && $id ) {
    $json = file_get_contents("php://input");
    if( $json ) {
        $data = json_decode( $json );

        if( $data && $data->item->name ) {
            updateItem( $data->item->name, $id  );
        }
    }
}

//***************************************************************************
// DELETE /items/id
//***************************************************************************
if ( $is_DELETE && $id ) {
    deleteItem($id);
}