<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Import namespaces and classes of the core
use Mibew\Database;
use Mibew\Thread;

// Initialize libraries
require_once(dirname(dirname(__FILE__)).'/libs/init.php');
require_once(MIBEW_FS_ROOT.'/libs/operator.php');
require_once(MIBEW_FS_ROOT.'/libs/chat.php');
require_once(MIBEW_FS_ROOT.'/libs/userinfo.php');
require_once(MIBEW_FS_ROOT.'/libs/pagination.php');
require_once(MIBEW_FS_ROOT.'/libs/interfaces/style.php');
require_once(MIBEW_FS_ROOT.'/libs/classes/style.php');
require_once(MIBEW_FS_ROOT.'/libs/classes/page_style.php');


$operator = check_login();

$page = array();

setlocale(LC_TIME, getstring("time.locale"));

$userid = "";
if (isset($_GET['userid'])) {
	$userid = verifyparam("userid", "/^.{0,63}$/", "");
}

function threads_by_userid($userid)
{
	$db = Database::getInstance();
	if ($userid == "") {
		return null;
	}

	return $db->query(
		"SELECT {chatthread}.* " .
		"FROM {chatthread} " .
		"WHERE userid=:user_id " .
			"AND (invitationstate = :invitation_accepted " .
				"OR invitationstate = :invitation_not_invited) " .
		"ORDER BY dtmcreated DESC",
		array(
			':user_id' => $userid,
			':invitation_accepted' => Thread::INVITATION_ACCEPTED,
			':invitation_not_invited' => Thread::INVITATION_NOT_INVITED
		),
		array('return_rows' => Database::RETURN_ALL_ROWS)
	);
}

$found = threads_by_userid($userid);

prepare_menu($operator);
setup_pagination($found, 6);
foreach ($page['pagination.items'] as $key => $item) {
	$page['pagination.items'][$key] = Thread::createFromDbInfo($item);
}

$page['title'] = getlocal("page.analysis.userhistory.title");
$page['menuid'] = "history";

$page_style = new PageStyle(PageStyle::currentStyle());
$page_style->render('userhistory');

?>