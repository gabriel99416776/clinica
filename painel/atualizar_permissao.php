<?php
include("../bd.php");

if(isset($_POST['id']) && isset($_POST['permissao'])) {
    $id = intval($_POST['id']);
    $permissao = $_POST['permissao'];

    $stmt = $conn->prepare("UPDATE tbl_user SET permissao = ? WHERE id = ?");
    $stmt->bind_param("si", $permissao, $id);
    if($stmt->execute()){
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
?>