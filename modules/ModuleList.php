<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybrid\Submission;
use HeimrichHannot\XCommonEnvironment;

class ModuleList extends \Module
{
	protected $strTemplate = 'mod_frontendedit_list';
	protected $arrSkipInstances = array();

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$this->Templateemplate = new \BackendTemplate('be_wildcard');

			$this->Templateemplate->wildcard = '### FRONTENDEDIT LIST ###';
			$this->Templateemplate->title = $this->headline;
			$this->Templateemplate->id = $this->id;
			$this->Templateemplate->link = $this->name;
			$this->Templateemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $this->Templateemplate->parse();
		}

		\DataContainer::loadDataContainer($this->formHybridDataContainer);
		\System::loadLanguageFile($this->formHybridDataContainer);
		
		return parent::generate();
	}
	
	protected function compile()
	{
		$this->Template->headline = $this->headline;
		$this->Template->hl = $this->hl;

		if (\Input::get('delete'))
		{
			$this->deleteInstance(\Input::get('delete'));
			// return to the list
			\Controller::redirect(XCommonEnvironment::removeParameterFromUri(XCommonEnvironment::getCurrentUrl(), 'delete'));
		}

		$this->arrSkipInstances = deserialize($this->skipInstances, true);
		$this->arrEditable = deserialize($this->formHybridEditable, true);
		list($this->Template->items, $this->Template->count) = $this->getItems();
	}

	protected function deleteInstance($intId)
	{
		// important: set the concrete table
		FrontendEditInstanceModel::setTable($this->formHybridDataContainer);

		if (($objInstance = FrontendEditInstanceModel::findByPk($intId)) !== null)
		{
			$dc = new DC_Hybrid($this->formHybridDataContainer, $objInstance);

			// call ondelete callbacks
			if (is_array($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback']))
			{
				foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($dc);
				}
			}

			$objInstance->delete();
		}
	}
	
	protected function getItems()
	{
		$arrItems = array();
		$arrColumns = array();
		$arrValues = array();
		$arrOptions = array();

		// important: set the concrete table
		FrontendEditInstanceModel::setTable($this->formHybridDataContainer);

		// offset
		$offset = intval($this->skipFirst);

		// limit
		$limit = null;
		if ($this->numberOfItems > 0)
		{
			$limit = $this->numberOfItems;
		}

		// total number of items
		if (count($arrColumns) > 0)
			$intTotal = FrontendEditInstanceModel::countBy($arrColumns, $arrValues, $arrOptions);
		else
			$intTotal = FrontendEditInstanceModel::countAll($arrOptions);

		$this->Template->empty = false;

		if ($intTotal < 1)
		{
			$this->Template->empty = true;
		}

		// split results
		list($offset, $limit) = $this->splitResults($offset, $intTotal, $limit);

		$arrOptions['limit']  = $limit;
		$arrOptions['offset'] = $offset;

//		if ($this->ticket_sorting !== '') {
//			$order = str_replace( array('_asc', '_desc'), array(' ASC', ' DESC'), $this->ticket_sorting);
//			$arrOptions['order']  = ($order === 'random') ? 'RAND()' : 'tl_ticket.' . $order;
//		}

		// Get the items
		if (count($arrColumns) > 0)
			$objInstances = FrontendEditInstanceModel::findBy($arrColumns, $arrValues, $arrOptions);
		else
			$objInstances = FrontendEditInstanceModel::findAll($arrOptions);

		if ($objInstances !== null)
		{
			while ($objInstances->next())
			{
				$arrItem = array();

				// always pass id
				$arrItem['fields']['id'] = $objInstances->id;

				foreach ($this->arrEditable as $strName)
					$arrItem['fields'][$strName] = $objInstances->{$strName};

				// details url
				if (($objPageJumpTo = XCommonEnvironment::getPageObjectById($this->jumpToDetails)) !== null)
				{
					$arrItem['detailsUrl'] = $this->generateFrontendUrl($objPageJumpTo->row()) . '?id=' . $objInstances->id;
				}

				// delete url
				global $objPage;
				$arrItem['deleteUrl'] = $this->generateFrontendUrl($objPage->row()) . '?delete=' . $objInstances->id;

				$arrItems[] = $arrItem;
			}
		}
		else
		{
			$this->Template->empty = true;
			return;
		}

		return array($arrItems, $intTotal);
	}

	protected function splitResults($offset, $intTotal, $limit)
	{
		$total = $intTotal - $offset;
	
		// Split the results
		if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$total = min($limit, $total);
			}
	
			// Get the current page
			$id = 'page_s' . $this->id;
			$page = \Input::get($id) ?: 1;
	
			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				global $objPage;
				$objPage->noSearch = 1;
				$objPage->cache = 0;
	
				// Send a 404 header
				header('HTTP/1.1 404 Not Found');
				return;
			}
	
			// Set limit and offset
			$limit = $this->perPage;
			$offset += (max($page, 1) - 1) * $this->perPage;
	
			// Overall limit
			if ($offset + $limit > $total)
			{
				$limit = $total - $offset;
			}
	
			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, $GLOBALS['TL_CONFIG']['maxPaginationLinks'], $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}
	
		return array($offset, $limit);
	}

}
