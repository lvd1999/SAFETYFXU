<?php
// List of functions (v3)
// userDetails
// adminDetails
// get_pendingrequest
// acceptRequest
// get_sites
// get_newsites
// get_sitesInfo
// docsByAdmin
// newDocsByAdmin
// deleteDocument
// GOunreadDocument
// GOunreadDocumentV2
// AllMembersByAdmin
// AllMembersByAdminGroupByUser
// userSafepass
// membersBySite
// GOunreadDocumentV3
// unreadDocumentByTitle
// unreadDocumentMembersBySite
// workingSitesByUserToAdmin
//docsBySite
//get_certs

//Changed-v3
function userDetails($id)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
    $stm->bindValue(1, $id);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

//Changed-v3
function adminDetails($id)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM admins WHERE adminID = ?");
    $stm->bindValue(1, $id);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}


//Changed-v3
function get_pendingrequest($adminid)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM `siteregistrations` join users on userID = users_userID join buildingsites on buildingsiteID = buildingsites_buildingsiteID where admins_adminID = ? and status = 'pending'");
    $stm->bindValue(1, $adminid);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Changed-v3
function acceptRequest($siteregistrationid) {
    global $pdo;
    $stm = $pdo->prepare("UPDATE siteregistrations SET status='allowed' WHERE siteregistrationID = ?");
    $stm->bindValue(1, $siteregistrationid);
    $stm->execute();
    //$stm2 = $pdo->prepare("INSERT INTO siteregistrations (users_userID, buildingsites_buildingsiteID) VALUES (? , ?, ?)");
    //$stm2->bindValue(1, $userid);
    //$stm2->bindValue(2, $buildingsiteid);
	//$stm2->bindValue(3, 'allowed');
    //$stm2->execute();
}


//Changed-v3
function get_sites($adminid)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites WHERE admins_adminID = ?");
    $stm->bindValue(1, $adminid);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Changed-v3
function get_newsites($adminid)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites left join siteregistrations on buildingsiteID = siteregistrations.buildingsites_buildingsiteID WHERE siteregistrationID IS NULL and buildingsites.admins_adminID = ?");
    $stm->bindValue(1, $adminid);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Changed-v3
function get_sitesInfo($adminid)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM buildingsites join siteregistrations on buildingsiteID = siteregistrations.buildingsites_buildingsiteID join users on userID = users_userID WHERE buildingsites.admins_adminID = ?");
    $stm->bindValue(1, $adminid);
    $stm->execute();
    //$row = $stm->fetchAll(PDO::FETCH_ASSOC);
	//return $row;
	
	// init our results array
	$posts = array ();

	$lastPostId = NULL;
	$count=0;
	// get the first post (plus it's JOINed photo)
	while ( $post = $stm->fetch (PDO::FETCH_OBJ) ) {

		if ( $lastPostId != $post->buildingsiteID ) {
			if ( $lastPostId !== NULL ) {
				// add this obj to the post array
				$posts[] = $tPost;
			}
			// start a new temp object
			$tPost = new stdClass();
			$tPost->buildingsiteID = $post->buildingsiteID;
			$tPost->address = $post->address;
			$tPost->code = $post->code;
			$tPost->sitename = $post->sitename;
			$tPost->gos  = array();
		}


		$tPost->gos[] = $post->users_userID.": ".$post->firstname." ".$post->surname." - ".$post->status;

		$lastPostId = $post->buildingsiteID;
		$count++;
	}
	if(!empty($tPost)){$posts[] = $tPost;}

	return json_encode($posts); 
	
}

//Changed-v3
function docsByAdmin($adminid) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documents join documentsites on documentID = documents_documentID join buildingsites on buildingsiteID = buildingsites_buildingsiteID WHERE documents.admins_adminID = ? order by sitename asc");
	$stm->bindValue(1, $adminid);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Changed-v3
function newDocsByAdmin($adminid) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documents left join documentsites on documentID = documents_documentID where documentsiteID IS NULL and documents.admins_adminID = ?");
	$stm->bindValue(1, $adminid);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function deleteDocument($documentID)
{
    global $pdo;
    $stm = $pdo->prepare("DELETE from documents WHERE documentID=$documentID");
    $stm->bindValue(1, $documentID);
    $stm->execute();
}

function GOunreadDocument($adminID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documentstatus JOIN documents ON documents_documentID = documents.documentID JOIN users ON users_userID = userID WHERE status='unread' AND admins_adminID = ?");
	$stm->bindValue(1, $adminID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function GOunreadDocumentV2($siteID)
{
    global $pdo;

    $stm = $pdo->prepare("SELECT * FROM (((documentstatus
    INNER JOIN users ON documentstatus.users_userID = users.userID)
    INNER JOIN documents ON documentstatus.documents_documentID = documents.documentID)
    INNER JOIN documentsites ON documentsites.documents_documentID = documents.documentID)
    WHERE documentstatus.status='unread' AND documentsites.buildingsites_buildingsiteID = ?");

	$stm->bindValue(1, $siteID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function AllMembersByAdmin($adminID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT u.userID,u.firstname, u.surname FROM users u
    JOIN siteregistrations ON u.userID = siteregistrations.users_userID
    JOIN buildingsites ON buildingsites.buildingsiteID = siteregistrations.buildingsites_buildingsiteID
    JOIN admins ON buildingsites.admins_adminID = admins.adminID
    WHERE admins.adminID = ?");
	$stm->bindValue(1, $adminID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function AllMembersByAdminGroupByUser($adminID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT u.userID, u.firstname, u.surname, u.occupation FROM users u 
    JOIN siteregistrations ON u.userID = siteregistrations.users_userID
    JOIN buildingsites ON buildingsites.buildingsiteID = siteregistrations.buildingsites_buildingsiteID
    JOIN admins ON buildingsites.admins_adminID = admins.adminID
    WHERE admins.adminID = ?
    GROUP BY u.userID");
	$stm->bindValue(1, $adminID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function userSafepass($userID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates 
    JOIN users ON users.userID = certificates.users_userID
    WHERE certificates.type='safepass' AND certificates.users_userID = ?");
	$stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function membersBySite($buildingsiteID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM siteregistrations 
    JOIN users ON users.userID = siteregistrations.users_userID
    WHERE siteregistrations.buildingsites_buildingsiteID = ?");
	$stm->bindValue(1, $buildingsiteID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function GOunreadDocumentV3($siteID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM (((documentstatus
    INNER JOIN users ON documentstatus.users_userID = users.userID)
    INNER JOIN documents ON documentstatus.documents_documentID = documents.documentID)
    INNER JOIN documentsites ON documentsites.documents_documentID = documents.documentID)
    WHERE documentstatus.status='unread' AND documentsites.buildingsites_buildingsiteID = ?
    GROUP BY title");
	$stm->bindValue(1, $siteID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function unreadDocumentByTitle($title) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documentstatus
    JOIN documents ON documentstatus.documents_documentID = documents.documentID
    WHERE documentstatus.status = 'unread' AND documents.title = ?");
	$stm->bindValue(1, $title);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function unreadDocumentMembersBySite($site) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM users
    JOIN documentstatus ON documentstatus.users_userID = users.userID
    WHERE documentstatus.status='unread' AND documentstatus.documents_documentID = ?");
	$stm->bindValue(1, $site);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function workingSitesByUserToAdmin($userID, $adminID) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM (siteregistrations 
    INNER JOIN buildingsites ON buildingsites.buildingsiteID = siteregistrations.buildingsites_buildingsiteID)
    WHERE siteregistrations.users_userID = ? AND buildingsites.admins_adminID = ?");
	$stm->bindValue(1, $userID);
	$stm->bindValue(2, $adminID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}








// old version functions
function codeExists($code) {

    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(empty($row)) {
        return false;
    } else {
        return true;
    }
}



function displayRegisteredSites($email) {
    global $pdo;
    $stm = $pdo->prepare("SELECT bs.code, bs.address FROM (building_sites bs INNER JOIN requests r ON bs.code = r.code) WHERE r.email = ? AND r.status='allowed'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function siteMembers($id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT u.id,u.email, u.firstname, u.surname, u.occupation FROM (site_registration sr INNER JOIN users u ON sr.email = u.email) WHERE sr.building_site = ?");
    $stm->bindValue(1, $id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function registeredSites($email) {
    global $pdo;
    $stm = $pdo->prepare("SELECT r.code, r.status, bs.address FROM (requests r INNER JOIN building_sites bs ON r.code = bs.code) 
    WHERE email = ? ORDER BY FIELD(status, 'allowed')");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSiteByCode($code) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}



function getSitesByAdmin($admin_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites bs INNER JOIN admins a ON a.company_name = bs.company_name WHERE a.company_name = ?");
    $stm->bindValue(1, $admin_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getDocuments($user_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT p.title, pdfs.pdf_id FROM pdf p INNER JOIN pdf_status pdfs 
    ON p.id=pdfs.pdf_id 
    WHERE pdfs.user_id = ? AND pdfs.status='unread'  ");
    $stm->bindValue(1, $user_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getPDFById($pdf_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM pdf WHERE id = ?");
    $stm->bindValue(1, $pdf_id);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}


function get_safepass($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE email = ? AND type='safepass'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function delete_cert($email, $type)
{
    global $pdo;
    $stm = $pdo->prepare("DELETE FROM certificates WHERE email = ? AND cert_image_front = ? ");
    $stm->bindValue(1, $email);
    $stm->bindValue(2, $type);
    $stm->execute();
}

function get_cert($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE email = ? AND type <> 'safepass'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function docsBySite($siteID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM documentsites  
    JOIN documents on documentsites.documents_documentID = documents.documentID
    WHERE buildingsites_buildingsiteID = ?");
    $stm->bindValue(1, $siteID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function get_certs($userID)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE users_userID = ?");
    $stm->bindValue(1, $userID);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}