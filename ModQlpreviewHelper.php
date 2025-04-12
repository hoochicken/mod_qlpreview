<?php
/**
 * @package        mod_qlqlpreview
 * @copyright      Copyright (C) 2025 ql.de All rights reserved.
 * @author         Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Database\DatabaseDriver;
use Joomla\Input\Input;
use Joomla\Registry\Registry as Registry;

defined('_JEXEC') or die;

class ModQlpreviewHelper
{
    const INPUT_OPTION_KEY = 'option';
    const INPUT_OPTION_VALUE = 'com_menus';
    const INPUT_VIEW_KEY = 'view';
    const INPUT_VIEW_VALUE = 'item';
    const INPUT_LAYOUT_KEY = 'layout';
    const INPUT_LAYOUT_VALUE = 'edit';
    const INPUT_ID_KEY = 'id';

    private stdClass $module;
    private Registry $params;
    private Input $input;
    private DatabaseDriver $db;
    private string $base_url;
    private string $protocol;

    private string $raw_url;
    private string $index_url;
    private string $sef_url;

    function __construct(stdClass $module, Registry $params, Input $input, DatabaseDriver $db, string $base_url, string $protocol)
    {
        $this->module = $module;
        $this->params = $params;
        $this->input = $input;
        $this->db = $db;
        $this->base_url = $base_url;
        $this->protocol = $protocol;
    }

    public function checkMenuItem(): bool
    {
        return
            self::INPUT_OPTION_VALUE === $this->input->getString(self::INPUT_OPTION_KEY)
            &&
            self::INPUT_LAYOUT_VALUE === $this->input->getString(self::INPUT_LAYOUT_KEY)
            &&
            self::INPUT_VIEW_VALUE === $this->input->getString(self::INPUT_VIEW_KEY);
    }

    public function generateUrlsByMenuItemId(int $id): void
    {
        $menuItem = $this->getMenuItemById($id);
        if (is_null($menuItem)) {
            throw new Exception('qlpreview: MenuItem konnte nicht gefunden werden.');
        }
        $this->raw_url = $this->generateRawUrl($menuItem->link);
        $this->index_url = $this->generateIndexUrl($menuItem->link);
        $this->sef_url = $this->generateSefUrl($menuItem->link);
    }

    public function getMenuItemById(int $id): ?stdClass
    {
        $query = $this->db->getQuery(true);
        $query->select('id, title, alias, link');
        $query->from('#__menu');
        $query->where('published = 1');
        $query->andWhere(sprintf('id=%s', (string)$id));
        $this->db->setQuery($query);
        return $this->db->loadObject();
    }

    private function getBaseUrl(): string
    {
        return $this->base_url;
    }

    public function addProtocol(string $path): string
    {
        return sprintf('%s://%s', $this->protocol, $path);
    }

    public function generateRawUrl(?string $path): string
    {
        return $this->addProtocol(sprintf('%s/%s', $this->base_url, $path));
    }

    private function generateIndexUrl(?string $path): string
    {
        return $this->addProtocol(sprintf('%s%s', $this->base_url, Route::link('site', $path)));
    }

    private function generateSefUrl(?string $path): string
    {
        return $this->addProtocol(sprintf('%s%s', $this->base_url, Route::link('site', $path)));
    }

    public function getRawUrl(): string
    {
        return $this->raw_url;
    }

    public function getIndexUrl(): string
    {
        return $this->index_url;
    }

    public function getSefUrl(): string
    {
        return $this->sef_url;
    }

    public function getRawButtonLabel(): string
    {
        return $this->getButtonLabel('raw_url_label', 'MOD_QLPREVIEW_RAWLINK_BUTTON_LABEL');
    }

    public function getIndexButtonLabel(): string
    {
        return $this->getButtonLabel('index_url_label', 'MOD_QLPREVIEW_INDEXLINK_BUTTON_LABEL');
    }

    public function getSefButtonLabel(): string
    {
        return $this->getButtonLabel('sef_url_label', 'MOD_QLPREVIEW_SEFLINK_BUTTON_LABEL');
    }

    public function getButtonLabel($key, string $default): string
    {
        return Text::_($this->params->get($key, $default));
    }
}
