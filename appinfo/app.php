<?php
/**
 * ownCloud - user_permission
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dino Peng <dino.p@inwinstack.com>
 * @copyright Dino Peng 2015
 */

namespace OCA\User_Permission\AppInfo;

$app = new Application();
$app->getContainer()->query('UserHooks')->register();

\OCP\Util::addScript('user_permission', 'permission');
\OCP\Util::addScript('user_permission', 'import');
\OCP\Util::addStyle( 'user_permission', "style");
