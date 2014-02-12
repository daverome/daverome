<?php
/*
 * Fake API for routes
 * /items
 * /items/item_id
 */

$id = (int) (isset( $_GET['id']) ? trim(strip_tags($_GET['id'])) : '' ) ;

$items = array(
    'items' => array(
        array('id' => 1, 'name' => 'Item 1'),
        array('id' => 2, 'name' => 'Item 2'),
        array('id' => 3, 'name' => 'Item 3'),
        array('id' => 4, 'name' => 'Item 4')
    )
);

if ( $id ) {
    foreach( $items['items'] as $item ) {
        if( $item['id'] == $id ) {
            $items = $item;
            break;
        }
    }
}
echo json_encode( $items );