<?php
namespace Magento\Xxyyzz\Page\Catalog\Admin;

use Magento\Xxyyzz\Page\AbstractAdminPage;

class AdminProductGridPage extends AbstractAdminPage
{
    /**
     * Include url of current page.
     */
    public static $URL = '/admin/catalog/product';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     */
    public static $productGridLoadingSpinner    =
        '.admin__data-grid-loading-mask[data-component="product_listing.product_listing.product_columns"]>.spinner';
    public static $addNewProductButton          = '#add_new_product-button';
    public static $filterClearAllButton         = '.admin__data-grid-header button[data-action=grid-filter-reset]';
    public static $filterExpanded               = '.admin__data-grid-filters-wrap._show';
    public static $filterExpandButton           =
        '.admin__data-grid-outer-wrap>.admin__data-grid-header button[data-action=grid-filter-expand]';
    public static $filterProductName            = '.admin__form-field input[name=name]';
    public static $filterProductSku             = '.admin__form-field input[name=sku]';
    public static $filterApplyButton            =
        '.admin__data-grid-filters-footer button[data-action=grid-filter-apply]';
    public static $gridNthRow                   =
        '.admin__data-grid-outer-wrap>.admin__data-grid-wrap tbody tr:nth-child(%s)';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    public function amOnAdminProductGridPage()
    {
        $I = $this->acceptanceTester;
        $I->amOnPage(self::$URL);
        $I->waitForElementNotVisible(self::$productGridLoadingSpinner, $this->pageloadTimeout);

    }

    public function goToAddNewProductPage()
    {
        $I = $this->acceptanceTester;
        $I->click(self::$addNewProductButton);
    }

    public function searchBySku($sku)
    {
        $I = $this->acceptanceTester;
        try {
            $I->waitForElementNotVisible(self::$productGridLoadingSpinner, $this->pageloadTimeout);
            $I->click(self::$filterClearAllButton);
        } catch (\Codeception\Exception\ElementNotFound $e) {
        }
        try {
            $I->wait(5);
            $I->waitForElementNotVisible(self::$productGridLoadingSpinner, $this->pageloadTimeout);
            $I->click(self::$filterExpandButton);
            $I->waitForElementNotVisible(self::$productGridLoadingSpinner, $this->pageloadTimeout);
        } catch (\Codeception\Exception\ElementNotFound $e) {
        }

        $I->fillField(self::$filterProductSku, $sku);
        $I->click(self::$filterApplyButton);
        $I->waitForElementNotVisible(self::$productGridLoadingSpinner, $this->pageloadTimeout);
    }

    public function containsInNthRow($n, $text)
    {
        $I = $this->acceptanceTester;
        return $I->see($text, sprintf(self::$gridNthRow, $n));
    }
}
