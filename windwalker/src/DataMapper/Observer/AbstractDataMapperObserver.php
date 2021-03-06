<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\DataMapper\Observer;

use Joomla\Registry\Registry;
use Windwalker\DataMapper\ObservableDataMapper;

/**
 * An observer for ObservableDataMapper
 * 
 * @since  2.1
 */
abstract class AbstractDataMapperObserver implements \JObserverInterface
{
	/**
	 * Property mapper.
	 *
	 * @var  ObservableDataMapper
	 */
	protected $mapper;

	/**
	 * Property params.
	 *
	 * @var  array
	 */
	protected $params;

	/**
	 * Class init.
	 *
	 * @param  ObservableDataMapper  $mapper  An ObservableDataMapper to support hooks.
	 * @param  array                 $params  Params to provide other information.
	 */
	public function __construct(ObservableDataMapper $mapper, $params = array())
	{
		$mapper->attachObserver($this);

		$this->mapper = $mapper;
		$this->params = new Registry($params);
	}

	/**
	 * Creates the associated observer instance and attaches it to the $observableObject
	 *
	 * @param   \JObservableInterface $observableObject The observable subject object
	 * @param   array                 $params           Params for this observer
	 *
	 * @return  \JObserverInterface
	 *
	 * @since   3.1.2
	 */
	public static function createObserver(\JObservableInterface $observableObject, $params = array())
	{
		return new static($observableObject, $params);
	}
}
