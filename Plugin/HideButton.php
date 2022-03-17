<?php
namespace Joshi\Hideaddcart\Plugin;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class HideButton {
	const MODULE_SHOW_CART_CONFIG_PATH = 'joshi_store/general/disable_cart';

	protected $storeManager;

	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		ScopeConfigInterface $scopeConfig,
		array $data = []
	) {
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;

	}

	public function getIsCartDisabled() {
		return $this->scopeConfig->getValue(self::MODULE_SHOW_CART_CONFIG_PATH, ScopeInterface::SCOPE_STORE,
			$this->getStoreId());
	}
	public function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}
	public function afterIsSaleable(Product $product) {
		if ($this->getIsCartDisabled()) {
			return [];
		}
		return true;

	}
}