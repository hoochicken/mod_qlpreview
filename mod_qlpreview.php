<?php
/**
 * @package		mod_qlpreview
 * @copyright	Copyright (C) 2023 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\CMS\Factory;

defined('_JEXEC') or die;
require_once dirname(__FILE__).'/ModQlpreviewHelper.php';

/** @var stdClass $module  */
/** @var JRegistry $params  */
/** @var stdClass $menuItem  */
try{
    $helper = new ModQlpreviewHelper($module, $params, Factory::getApplication()->getInput(), \Joomla\CMS\Factory::getDbo(), (JUri::getInstance())->getHost(), $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http');
    if (!$helper->checkMenuItem()) {
        return;
    }
    $rawUrlLabel = $helper->getRawButtonLabel();
    $indexUrlLabel = $helper->getIndexButtonLabel();
    $sefUrlLabel = $helper->getSefButtonLabel();

    $id = (int)Factory::getApplication()->getInput()->get(ModQlpreviewHelper::INPUT_ID_KEY, 0);
    if (0 >= $id) {
        throw new Exception('qlpreview: keine Id gegeben, neuer Menüeintrag?');
    }

    $helper->generateUrlsByMenuItemId(Factory::getApplication()->getInput()->get(ModQlpreviewHelper::INPUT_ID_KEY, 0));
    require JModuleHelper::getLayoutPath('mod_qlpreview', $params->get('layout', 'default'));
} catch (Exception $e) {

}
