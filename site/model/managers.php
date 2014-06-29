<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\Registry\Registry;
use Windwalker\Compare\InCompare;
use Windwalker\DI\Container;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage Managers model
 *
 * @since 1.0
 */
class RemoteimageModelManagers extends ListModel
{
	/**
	 * Component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'remoteimage';

	/**
	 * The URL option for the component.
	 *
	 * @var  string
	 */
	protected $option = 'com_remoteimage';

	/**
	 * The prefix to use with messages.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_REMOTEIMAGE';

	/**
	 * The model (base) name
	 *
	 * @var  string
	 */
	protected $name = 'managers';

	/**
	 * Item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'manager';

	/**
	 * List name.
	 *
	 * @var  string
	 */
	protected $viewList = 'managers';

	/**
	 * Configure tables through QueryHelper.
	 *
	 * @return  void
	 */
	protected function configureTables()
	{
		$queryHelper = $this->getContainer()->get('model.managers.helper.query', Container::FORCE_NEW);

		$queryHelper->addTable('manager', '#__remoteimage_managers')
			->addTable('category',  '#__categories', 'manager.catid      = category.id')
			->addTable('user',      '#__users',      'manager.created_by = user.id')
			->addTable('viewlevel', '#__viewlevels', 'manager.access     = viewlevel.id')
			->addTable('lang',      '#__languages',  'manager.language   = lang.lang_code');

		$this->filterFields = array_merge($this->filterFields, $queryHelper->getFilterFields());
	}

	/**
	 * The post getQuery object.
	 *
	 * @param JDatabaseQuery $query The db query object.
	 *
	 * @return  void
	 */
	protected function postGetQuery(\JDatabaseQuery $query)
	{
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method will only called in constructor. Using `ignore_request` to ignore this method.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$params = $this->getParams();
		$user   = $this->container->get('user');
		$input  = $this->container->get('input');
		$app    = $this->container->get('app');

		// Order
		// =====================================================================================
		$orderCol = $params->get('orderby', 'a.ordering');
		$this->state->set('list.ordering', $orderCol);

		// Order Dir
		// =====================================================================================
		$listOrder = $params->get('order_dir', 'asc');
		$this->state->set('list.direction', $listOrder);

		// Limitstart
		// =====================================================================================
		$this->state->set('list.start', $input->getInt('limitstart', 0));

		// Max Level
		// =====================================================================================
		$maxLevel = $params->get('maxLevel');

		if ($maxLevel)
		{
			$this->state->set('filter.max_category_levels', $maxLevel);
		}

		// Edit Access
		// =====================================================================================
		if (($user->authorise('core.edit.state', 'com_remoteimage')) || ($user->authorise('core.edit', 'com_remoteimage')))
		{
			// Filter on published for those who do not have edit or edit.state rights.
			$this->state->set('filter.unpublished', 1);
		}

		// View Level
		// =====================================================================================
		if (!$params->get('show_noauth'))
		{
			$this->state->set('filter.access', true);
		}
		else
		{
			$this->state->set('filter.access', false);
		}

		// Language
		// =====================================================================================
		$this->state->set('filter.language', $app->getLanguageFilter());

		parent::populateState($ordering, 'ASC');
	}

	/**
	 * Process the query filters.
	 *
	 * @param JDatabaseQuery $query   The query object.
	 * @param array          $filters The filters values.
	 *
	 * @return  JDatabaseQuery The db query object.
	 */
	protected function processFilters(\JDatabaseQuery $query, $filters = array())
	{
		$user = $this->container->get('user');
		$db   = $this->container->get('db');
		$date = $this->container->get('date');

		// If no state filter, set published >= 0
		if (!isset($filters['manager.state']) && property_exists($this->getTable(), 'state'))
		{
			$query->where($query->quoteName('manager.state') . ' >= 0');
		}

		// Category
		// =====================================================================================
		$category = $this->getCategory();

		if ($category->id != 1 && in_array('category.lft', $this->filterFields) && in_array('category.rgt', $this->filterFields))
		{
			$query->where($query->format('(%n >= %a AND %n <= %a)', 'category.lft', $category->lft, 'category.rgt', $category->rgt));
		}

		// Max Level
		// =====================================================================================
		$maxLevel = $this->state->get('filter.max_category_levels', -1);

		if ($maxLevel > 0)
		{
			$query->where($query->quoteName('category.level') . " <= " . $maxLevel);
		}

		// Edit Access
		// =====================================================================================
		if ($this->state->get('filter.unpublished'))
		{
			$query->where('manager.state >= 0');
		}
		else
		{
			$query->where('manager.state > 0');

			$nullDate = $query->Quote($db->getNullDate());
			$nowDate  = $query->Quote($date->toSQL(true));

			if (in_array('manager.publish_up', $this->filterFields) && in_array('manager.publish_down', $this->filterFields))
			{
				$query->where('(manager.publish_up = ' . $nullDate . ' OR manager.publish_up <= ' . $nowDate . ')');
				$query->where('(manager.publish_down = ' . $nullDate . ' OR manager.publish_down >= ' . $nowDate . ')');
			}
		}

		// View Level
		// =====================================================================================
		if ($access = $this->state->get('filter.access') && in_array('manager.access', $this->filterFields))
		{
			$query->where(new InCompare('manager.access', $user->getAuthorisedViewLevels()));
		}

		// Language
		// =====================================================================================
		if ($this->state->get('filter.language') && in_array('a.language', $this->filterFields))
		{
			$lang_code = $db->quote(JFactory::getLanguage()->getTag());
			$query->where("a.language IN ('{$lang_code}', '*')");
		}

		return parent::processFilters($query, $filters);
	}

	/**
	 * Configure the filter handlers.
	 *
	 * Example:
	 * ``` php
	 * $filterHelper->setHandler(
	 *     'manager.date',
	 *     function($query, $field, $value)
	 *     {
	 *         $query->where($field . ' >= ' . $value);
	 *     }
	 * );
	 * ```
	 *
	 * @param FilterHelper $filterHelper The filter helper object.
	 *
	 * @return  void
	 */
	protected function configureFilters($filterHelper)
	{
	}

	/**
	 * Configure the search handlers.
	 *
	 * Example:
	 * ``` php
	 * $searchHelper->setHandler(
	 *     'manager.title',
	 *     function($query, $field, $value)
	 *     {
	 *         return $query->quoteName($field) . ' LIKE ' . $query->quote('%' . $value . '%');
	 *     }
	 * );
	 * ```
	 *
	 * @param SearchHelper $searchHelper The search helper object.
	 *
	 * @return  void
	 */
	protected function configureSearches($searchHelper)
	{
	}
}
