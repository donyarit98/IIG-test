<?php 
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function userExists($db, $user)
{
    $userQuery = "SELECT * FROM userinfo u WHERE u.user=:user;";
    $stmt = $db->prepare($userQuery);
    $stmt->execute(array(':user' => $user));
    return !!$stmt->fetch(PDO::FETCH_ASSOC);
}


?>