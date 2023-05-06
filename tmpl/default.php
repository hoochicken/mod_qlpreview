<?php
/**
 * @package        mod_qlpathadmin
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
/** @var ModQlpathadminHelper $helper */
/** @var string $rawUrlLabel */
/** @var string $indexUrlLabel */
/** @var string $sefUrlLabel */
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerStyle('qlpathadmin', 'mod_qlpathadmin/styles.css');
$wa->useStyle('qlpathadmin');
$wa->registerScript('qlpathadmin', 'mod_qlpathadmin/styles.css');
$wa->useStyle('qlpathadmin');

/** @var stdClass $module */
?>
<div class="qlpathadmin" id="module<?php echo $module->id ?>">
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
        <?php echo Text::_('MOD_QLPATHADMIN_SAVE_HINT'); ?>
        </div>
    <?php endif; ?>
</div>
