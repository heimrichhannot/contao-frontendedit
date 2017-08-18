<?php

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\Haste\Util\Files;

class ModuleNewsList extends ModuleList
{
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### FRONTENDEDIT NEWS LIST ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    protected function generateFields($objItem)
    {
        $arrItem = parent::generateFields($objItem);

        global $objPage;

        $arrItem['fields']['newsHeadline']   = $objItem->headline;
        $arrItem['fields']['subHeadline']    = $objItem->subheadline;
        $arrItem['fields']['hasSubHeadline'] = $objItem->subheadline ? true : false;
        $arrItem['fields']['linkHeadline']   = ModuleNews::generateLink($this, $objItem->headline, $objItem, false);
        $arrItem['fields']['more']           = ModuleNews::generateLink($this, $GLOBALS['TL_LANG']['MSC']['more'], $objItem, false, true);
        $arrItem['fields']['link']           = ModuleNews::generateNewsUrl($this, $objItem, false);
        $arrItem['fields']['text']           = '';

        // Clean the RTE output
        if ($objItem->teaser != '')
        {
            if ($objPage->outputFormat == 'xhtml')
            {
                $arrItem['fields']['teaser'] = \StringUtil::toXhtml($objItem->teaser);
            }
            else
            {
                $arrItem['fields']['teaser'] = \StringUtil::toHtml5($objItem->teaser);
            }

            $arrItem['fields']['teaser'] = \StringUtil::encodeEmail($arrItem['fields']['teaser']);
        }

        // Display the "read more" button for external/article links
        if ($objItem->source != 'default')
        {
            $arrItem['fields']['text'] = true;
        }

        // Compile the news text
        else
        {
            $objElement = \ContentModel::findPublishedByPidAndTable($objItem->id, 'tl_news');

            if ($objElement !== null)
            {
                while ($objElement->next())
                {
                    $arrItem['fields']['text'] .= $this->getContentElement($objElement->current());
                }
            }
        }

        $arrMeta = ModuleNews::getMetaFields($this, $objItem);

        // Add the meta information
        $arrItem['fields']['date']             = $arrMeta['date'];
        $arrItem['fields']['hasMetaFields']    = !empty($arrMeta);
        $arrItem['fields']['numberOfComments'] = $arrMeta['ccount'];
        $arrItem['fields']['commentCount']     = $arrMeta['comments'];
        $arrItem['fields']['timestamp']        = $objItem->date;
        $arrItem['fields']['author']           = $arrMeta['author'];
        $arrItem['fields']['datetime']         = date('Y-m-d\TH:i:sP', $objItem->date);

        // enclosures are added in runBeforeTemplateParsing

        return $arrItem;
    }

    protected function runBeforeTemplateParsing($objTemplate, $arrItem)
    {
        if ($arrItem['fields']['addEnclosure'])
        {
            if (!is_array($arrItem['fields']['enclosure']))
            {
                $arrItem['fields']['enclosure'] = [$arrItem['fields']['enclosure']];
            }
            $this->addEnclosuresToTemplate($objTemplate, $arrItem['fields']);
        }
    }
}
