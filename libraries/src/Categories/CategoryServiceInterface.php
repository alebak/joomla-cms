<?php
/**
 * Joomla! Content Management System
 *
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Categories;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Form;

/**
 * Access to component specific categories.
 *
 * @since  4.0.0
 */
interface CategoryServiceInterface
{
	/**
	 * Returns the category service.
	 *
	 * @param   array   $options  The options
	 * @param   string  $section  The section
	 *
	 * @return  CategoryInterface
	 *
	 * @since   4.0.0
	 * @throws  SectionNotFoundException
	 */
	public function getCategory(array $options = [], $section = ''): CategoryInterface;

	/**
	 * Adds Count Items for Category Manager.
	 *
	 * @param   \stdClass[]  $items    The category objects
	 * @param   string       $section  The section
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 * @throws  \Exception
	 */
	public function countItems(array $items, string $section);

	/**
	 * Prepares the category form
	 *
	 * @param   \Joomla\CMS\Categories\Form  $form  The form to change
	 * @param   array|object                 $data  The form data
	 *
	 * @return   void
	 */
	public function prepareForm(Form $form, $data);
}
