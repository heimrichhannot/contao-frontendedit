<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\Haste\Util\Files;

class ModuleMemberList extends ModuleList
{
	protected function generateFields($objItem)
	{
		$arrItem = parent::generateFields($objItem);

		if (in_array('member_content_archives', \ModuleLoader::getActive()))
		{
			$arrFilterTags = deserialize($this->memberContentArchiveTags, true);
			$arrItem['fields']['memberContent'] = '';

			if (($objMemberContentArchives = \HeimrichHannot\MemberContentArchives\MemberContentArchiveModel::findOneBy('mid', $objItem->memberId ?: $objItem->id)) !== null)
			{
				$arrItem['fields']['memberContentId'] = $objMemberContentArchives->id;

				if (in_array($objMemberContentArchives->tag, $arrFilterTags))
				{
					$objElement = \ContentModel::findPublishedByPidAndTable($objMemberContentArchives->id, 'tl_member_content_archive');

					if ($objElement !== null)
					{
						while ($objElement->next())
						{
							$arrItem['fields']['memberContent'] .= \Controller::getContentElement($objElement->current());
						}
					}
				}

				if ($objMemberContentArchives->tag == $this->memberContentArchiveTeaserTag)
				{
					$arrItem['fields']['memberContentTitle'] = $objMemberContentArchives->title;
					$arrItem['fields']['memberContentTeaser'] = $objMemberContentArchives->teaser;
				}

				// override member fields
				$arrOverridableMemberFields = deserialize(\Config::get('overridableMemberFields'));

				if (!empty($arrOverridableMemberFields))
				{
					foreach ($arrOverridableMemberFields as $strField)
					{
						$strFieldOverride = 'member' . ucfirst($strField);
						if ($objMemberContentArchives->{$strFieldOverride})
						{
							if (\Validator::isUuid($objMemberContentArchives->{$strFieldOverride}))
								$objMemberContentArchives->{$strFieldOverride} =
									Files::getPathFromUuid($objMemberContentArchives->{$strFieldOverride});

							$arrItem['fields'][$strField] = $objMemberContentArchives->{$strFieldOverride};
						}
					}
				}
			}
		}

		return $arrItem;
	}
}