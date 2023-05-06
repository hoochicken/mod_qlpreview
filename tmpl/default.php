<?php
/**
 * @package        mod_qlpreview
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;

// no direct access
defined('_JEXEC') or die;
/** @var JRegistry $params */
/** @var WebAssetManager $wa */
/** @var ModQlpreviewHelper $helper */
/** @var string $rawUrlLabel */
/** @var string $indexUrlLabel */
/** @var string $sefUrlLabel */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerStyle('qlpreview', 'mod_qlpreview/styles.css');
$wa->useStyle('qlpreview');
$wa->registerScript('qlpreview', 'mod_qlpreview/styles.css');
$wa->useStyle('qlpreview');

/** @var stdClass $module */
?>
<div class="qlpreview" id="module<?php echo $module->id ?>">
    <?php if ((bool)$params->get('display_save_hint', false)) : ?>
        <div class="alert alert-info">
    <?php endif; ?>
        <?php if ((bool)$params->get('display_raw_url', false)) : ?>
            <a class="btn btn-secondary" target="_blank"
               href="<?php echo $helper->getRawUrl(); ?>"><?php echo $rawUrlLabel; ?></a>
        <?php endif; ?>
        <?php if ((bool)$params->get('display_index_url', false)) : ?>
            <a class="btn btn-secondary" target="_blank"
               href="<?php echo $helper->getIndexUrl(); ?>"><?php echo $indexUrlLabel; ?></a>
        <?php endif; ?>
        <?php if ((bool)$params->get('display_sef_url', false)) : ?>
            <a class="btn btn-secondary" target="_blank"
               href="<?php echo $helper->getSefUrl(); ?>"><?php echo $sefUrlLabel; ?></a>
        <?php endif; ?>
    <?php if ((bool)$params->get('display_save_hint', false)) : ?>
        <?php echo Text::_('MOD_QLPREVIEW_SAVE_HINT'); ?>
        </div>
    <?php endif; ?>
</div>
