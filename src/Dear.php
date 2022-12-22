<?php

/**
 * Part of Dear package.
 *
 * @package Dear
 * @version 1.0
 * @author Umair Mahmood
 * @license MIT
 * @copyright Copyright (c) 2019 Umair Mahmood
 *
 */

namespace Eighteen73\Dear;


/**
 * @method \Eighteen73\Dear\Api\Account account()
 * @method \Eighteen73\Dear\Api\AdvancedPurchase advancedPurchase()
 * @method \Eighteen73\Dear\Api\AdvancedPurchaseCreditNote advancedPurchaseCreditNote()
 * @method \Eighteen73\Dear\Api\AdvancedPurchaseInvoice advancedPurchaseInvoice()
 * @method \Eighteen73\Dear\Api\AdvancedPurchaseManualJournal advancedPurchaseManualJournal()
 * @method \Eighteen73\Dear\Api\AdvancedPurchasePayment advancedPurchasePayment()
 * @method \Eighteen73\Dear\Api\AdvancedPurchasePutAway advancedPurchasePutAway()
 * @method \Eighteen73\Dear\Api\AdvancedPurchaseStockReceived advancedPurchaseStockReceived()
 * @method \Eighteen73\Dear\Api\AttributeSet attributeSet()
 * @method \Eighteen73\Dear\Api\BankAccount bankAccount()
 * @method \Eighteen73\Dear\Api\BankTransfer bankTransfer()
 * @method \Eighteen73\Dear\Api\Brand brand()
 * @method \Eighteen73\Dear\Api\Carrier carrier()
 * @method \Eighteen73\Dear\Api\Customer customer()
 * @method \Eighteen73\Dear\Api\Disassembly disassembly()
 * @method \Eighteen73\Dear\Api\DisassemblyList disassemblyList()
 * @method \Eighteen73\Dear\Api\DisassemblyOrder disassemblyOrder()
 * @method \Eighteen73\Dear\Api\FinishedGoods finishedGoods()
 * @method \Eighteen73\Dear\Api\FinishedGoodsList finishedGoodsList()
 * @method \Eighteen73\Dear\Api\FinishedGoodsOrder finishedGoodsOrder()
 * @method \Eighteen73\Dear\Api\FinishedGoodsPick finishedGoodsPick()
 * @method \Eighteen73\Dear\Api\FixedAssetType fixedAssetType()
 * @method \Eighteen73\Dear\Api\InventoryWriteOff inventoryWriteOff()
 * @method \Eighteen73\Dear\Api\InventoryWriteOffList inventoryWriteOffList()
 * @method \Eighteen73\Dear\Api\Journal journal()
 * @method \Eighteen73\Dear\Api\Location location()
 * @method \Eighteen73\Dear\Api\Me me()
 * @method \Eighteen73\Dear\Api\MeAddress meAddress()
 * @method \Eighteen73\Dear\Api\MeContact meContact()
 * @method \Eighteen73\Dear\Api\MoneyOperation moneyOperation()
 * @method \Eighteen73\Dear\Api\MoneyTaskList moneyTaskList()
 * @method \Eighteen73\Dear\Api\PaymentTerm paymentTerm()
 * @method \Eighteen73\Dear\Api\Product product()
 * @method \Eighteen73\Dear\Api\ProductAttachment productAttachment()
 * @method \Eighteen73\Dear\Api\ProductAvailability productAvailability()
 * @method \Eighteen73\Dear\Api\ProductCategory productCategory()
 * @method \Eighteen73\Dear\Api\ProductFamily productFamily()
 * @method \Eighteen73\Dear\Api\ProductFamilyAttachment productFamilyAttachment()
 * @method \Eighteen73\Dear\Api\Purchase purchase()
 * @method \Eighteen73\Dear\Api\PurchaseAttachment purchaseAttachment()
 * @method \Eighteen73\Dear\Api\PurchaseCreditNote purchaseCreditNote()
 * @method \Eighteen73\Dear\Api\PurchaseInvoice purchaseInvoice()
 * @method \Eighteen73\Dear\Api\PurchaseList purchaseList()
 * @method \Eighteen73\Dear\Api\PurchaseManualJournal purchaseManualJournal()
 * @method \Eighteen73\Dear\Api\PurchaseOrder purchaseOrder()
 * @method \Eighteen73\Dear\Api\PurchasePayment purchasePayment()
 * @method \Eighteen73\Dear\Api\PurchaseStockReceived purchaseStockReceived()
 * @method \Eighteen73\Dear\Api\Sale sale()
 * @method \Eighteen73\Dear\Api\SaleAttachment saleAttachment()
 * @method \Eighteen73\Dear\Api\SaleCreditNote saleCreditNote()
 * @method \Eighteen73\Dear\Api\SaleFulfilment saleFulfilment()
 * @method \Eighteen73\Dear\Api\SaleFulfilmentPack saleFulfilmentPack()
 * @method \Eighteen73\Dear\Api\SaleFulfilmentPick saleFulfilmentPick()
 * @method \Eighteen73\Dear\Api\SaleFulfilmentShip saleFulfilmentShip()
 * @method \Eighteen73\Dear\Api\SaleInvoice saleInvoice()
 * @method \Eighteen73\Dear\Api\SaleList saleList()
 * @method \Eighteen73\Dear\Api\SaleManualJournal saleManualJournal()
 * @method \Eighteen73\Dear\Api\SaleOrder saleOrder()
 * @method \Eighteen73\Dear\Api\SalePayment salePayment()
 * @method \Eighteen73\Dear\Api\SaleQuote saleQuote()
 * @method \Eighteen73\Dear\Api\StockAdjustment stockAdjustment()
 * @method \Eighteen73\Dear\Api\StockAdjustmentList stockAdjustmentList()
 * @method \Eighteen73\Dear\Api\StockTake stockTake()
 * @method \Eighteen73\Dear\Api\StockTakeList stockTakeList()
 * @method \Eighteen73\Dear\Api\StockTransfer stockTransfer()
 * @method \Eighteen73\Dear\Api\StockTransferList stockTransferList()
 * @method \Eighteen73\Dear\Api\StockTransferOrder stockTransferOrder()
 * @method \Eighteen73\Dear\Api\Supplier supplier()
 * @method \Eighteen73\Dear\Api\Tax tax()
 * @method \Eighteen73\Dear\Api\Transaction transaction()
 * @method \Eighteen73\Dear\Api\UnitOfMeasure unitOfMeasure()
 * @method \Eighteen73\Dear\Api\Webhooks webhooks()
 */
class Dear
{
    protected static self|null $instance = null;

    protected Config $config;

    protected function __construct(string $accountId = null, string $applicationKey = null)
    {
        $this->config = new Config($accountId, $applicationKey);
    }

    public static function create(string $accountId = null, string $applicationKey = null): self
    {
        return (static::$instance) ?: new static($accountId, $applicationKey);
    }

    public function __call(string $name, mixed $arguments): mixed
    {
        $class = "\\Eighteen73\\Dear\\Api\\" . ucwords($name);
        if (class_exists($class)) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("undefined method $name called.");
    }
}
