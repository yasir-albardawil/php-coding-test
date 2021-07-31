<?php
include 'inc/header.php';

$data_ids = $_REQUEST['data_ids'];
$roleid = $_REQUEST['roleid'];
$data_id_array = explode(",", $data_ids);
if (!empty($data_id_array)) {
    $users->bulk_update_roles($data_id_array, $roleid);
}
?>