<?php

require_once Mage::getModuleDir('controllers', 'Mage_CatalogSearch').DS.'ResultController.php';

class Clerk_Clerk_CatalogSearch_ResultController extends Mage_CatalogSearch_ResultController
{
    public function indexAction()
    {
      //#clerk - 16/09/2016
        $clerk_active = (Mage::getStoreConfig('clerk/general/active', null)) ? TRUE : FALSE;
        $clerk_search_active = (Mage::getStoreConfig('clerk/search/active', null)) ? TRUE : FALSE;
        $clerk_check_debug = (Mage::helper('clerk')->checkDebugMode()) ? TRUE : FALSE;
        $suppress_search = ($clerk_active && $clerk_search_active && $clerk_check_debug);
      //#
        //if (!Mage::helper('clerk')->getSetting('clerk/search/active')) {
        if (!$suppress_search) {
            return parent::indexAction();
        }
        $this->getLayout()->getUpdate()->addUpdate('<remove name="search.result"/>');
        $this->getLayout()->getUpdate()->addUpdate('<remove name="catalogsearch.leftnav"/>');
        $this->getLayout()->getUpdate()->addUpdate('<remove name="enterprisesearch.leftnav"/>');
        $this->getLayout()->getUpdate()->addUpdate('<remove name="amshopby.navleft"/>');
        $this->loadLayout();
        // $block = $this->getLayout()->createBlock('catalogsearch/result');
        $block = $this->getLayout()->createBlock('clerk/search');
        $block->setTemplate('clerk/search.phtml');
        $this->getLayout()->getBlock('content')->append($block);
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('checkout/session');
        $this->renderLayout();
    }
}
