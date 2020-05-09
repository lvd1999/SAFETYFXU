<?php
function userDetails($userID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
    $stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_cert($userID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE users_userID = ? AND type <> 'safepass'");
    $stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function get_safepass($userID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE users_userID = ? AND type='safepass'");
    $stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function codeExists($code) {

    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(empty($row)) {
        return false;
    } else {
        return true;
    }
}

function siteByCode($code) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function registeredSites($userID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM (siteregistrations
    inner JOIN buildingsites ON siteregistrations.buildingsites_buildingsiteID = buildingsites.buildingsiteID)
    WHERE users_userID = ? AND status = 'allowed'");
    $stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function siteDocs($siteID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM (documentsites
    INNER JOIN documents ON documents.documentID = documentsites.documents_documentID)
    WHERE buildingsites_buildingsiteID = ?");
    $stm->bindValue(1, $siteID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function siteDetails($siteID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites WHERE buildingsiteID = ?");
    $stm->bindValue(1, $siteID);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function docById($docID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documents WHERE documentID = ?");
    $stm->bindValue(1, $docID);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}
?>