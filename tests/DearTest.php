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

namespace Eighteen73\Dear\Test;

use Eighteen73\Dear\Api\Account;
use Eighteen73\Dear\Api\AttributeSet;
use Eighteen73\Dear\Api\BankAccount;
use Eighteen73\Dear\Api\Brand;
use Eighteen73\Dear\Api\Carrier;
use Eighteen73\Dear\Api\Contracts\DeleteMethodAllowed;
use Eighteen73\Dear\Api\Contracts\PostMethodAllowed;
use Eighteen73\Dear\Api\Contracts\PutMethodAllowed;
use Eighteen73\Dear\Api\Customer;
use Eighteen73\Dear\Api\FixedAssetType;
use Eighteen73\Dear\Api\Journal;
use Eighteen73\Dear\Api\Location;
use Eighteen73\Dear\Api\MeAddress;
use Eighteen73\Dear\Api\MeContact;
use Eighteen73\Dear\Api\PaymentTerm;
use Eighteen73\Dear\Api\ProductAvailability;
use Eighteen73\Dear\Api\ProductCategory;
use Eighteen73\Dear\Api\Supplier;
use Eighteen73\Dear\Api\Tax;
use Eighteen73\Dear\Api\UnitOfMeasure;
use PHPUnit\Framework\TestCase;
use Eighteen73\Dear\Dear;
use ReflectionClass;

class DearTest extends TestCase
{
    protected Dear $application;

    protected static array $methods = [
        'Account',
        'AttributeSet',
        'BankAccount',
        'Brand',
        'Carrier',
        'Customer',
        'FixedAssetType',
        'Journal',
        'Location',
        'Me',
        'MeAddress',
        'MeContact',
        'PaymentTerm',
        'Product',
        'ProductAvailability',
        'ProductCategory',
        'ProductFamily',
        'Supplier',
        'Tax',
        'Transaction',
        'UnitOfMeasure',
    ];

    public function setUp(): void
    {
        $this->application = Dear::create(null, null);
    }

    protected function getRandomCode(): string
    {
        return substr(md5(microtime()),rand(0,26),6);
    }

    protected function getId(array $response, string $method): string
    {
        $class = substr($method, 4);

        return match($class) {
            "Account" => $response["AccountsList"][0]["Code"],
            "AttributeSet" => $response['LocationList']['ID'],
            "Brand",
            "Location",
            "ProductCategory",
            "UnitOfMeasure",
            "Webhooks" => $response["ID"],
            "Carrier" => $response['CarrierList'][0]['CarrierID'],
            "Customer" => $response['CustomerList'][0]['ID'],
            "FixedAssetType" => $response['FixedAssetTypeList'][0]['FixedAssetTypeID'],
            "MeAddress" => $response['MeAddressesList'][0]['AddressID'],
            "MeContact" => $response['MeContactsList'][0]['ContactID'],
            "PaymentTerm" => $response['PaymentTermList'][0]['ID'],
            "Supplier" => $response['SupplierList'][0]['ID'],
            "Tax" => $response['TaxRuleList'][0]['ID'],
        };
    }

    public function testInitialize(): void
    {
        $this->assertInstanceOf(Dear::class, $this->application);
    }

    public function testAccount(): void
    {
        $reflection = new ReflectionClass(Account::class);
        $response = $this->application->Account()->get([]);

        $this->assertNotEmpty($response, "Test: Account");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Code" => $randomCode,
                "Status" => "ACTIVE",
                "Name" => "Test Account",
                "Type" => "CURRLIAB",
                "Description" => "Test Description",
                "Class" => "LIABILITY",
                "SystemAccount" => "Accounts Payable",
                "SystemAccountCode" => "CREDITORS"
            ];

            $response = $this->application->Account()->create($params);

            $this->assertNotEmpty($response, "Test: Account");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Code" => $randomCode,
                "Status" => "ACTIVE",
                "Name" => "Test Account",
                "Type" => "CURRLIAB",
                "Description" => "Test Description",
                "Class" => "LIABILITY",
                "SystemAccount" => "Accounts Payable",
                "SystemAccountCode" => "CREDITORS"
            ];

            $response = $this->application->Account()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Account()->update($id, [
                'Code' => $params['Code'],
                'Name' => $params['Name'],
                'Class' => $params['Class'],
                'Type' => $params['Type'],
                'Status' => $params['Status'],
            ]);

            $this->assertNotEmpty($response, "Test: Account");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Code" => $randomCode,
                "Status" => "ACTIVE",
                "Name" => "Test Account",
                "Type" => "CURRLIAB",
                "Description" => "Test Description",
                "Class" => "LIABILITY",
                "SystemAccount" => "Accounts Payable",
                "SystemAccountCode" => "CREDITORS"
            ];

            $response = $this->application->Account()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Account()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Account");
        }
    }

    public function testGetEndpoints(): void
    {
        foreach (self::$methods as $method) {
            $response = $this->application->{$method}()->get([]);

            $this->assertNotEmpty($response, "Test: $method");
        }
    }

    public function testAttributeSet(): void
    {
        $reflection = new ReflectionClass(AttributeSet::class);
        $response = $this->application->AttributeSet()->get([]);

        $this->assertNotEmpty($response, "Test: AttributeSet");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Attribute set $randomCode",
                "Attribute1Name" => "AttributeName $randomCode",
                "Attribute1Values" => "$randomCode",
                "Attribute1Type" => "List",
            ];

            $response = $this->application->AttributeSet()->create($params);

            $this->assertNotEmpty($response, "Test: AttributeSet");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Attribute set $randomCode",
                "Attribute1Name" => "AttributeName $randomCode",
                "Attribute1Values" => "$randomCode",
                "Attribute1Type" => "List",
            ];

            $response = $this->application->AttributeSet()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->AttributeSet()->update($id, $params);

            $this->assertNotEmpty($response, "Test: AttributeSet");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Attribute set $randomCode",
                "Attribute1Name" => "AttributeName $randomCode",
                "Attribute1Values" => "$randomCode",
                "Attribute1Type" => "List",
            ];

            $response = $this->application->AttributeSet()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->AttributeSet()->delete($id, []);

            $this->assertNotEmpty($response, "Test: AttributeSet");
        }
    }

    public function testBankAccount(): void
    {
        $reflection = new ReflectionClass(BankAccount::class);
        $response = $this->application->BankAccount()->get([]);

        $this->assertNotEmpty($response, "Test: BankAccount");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [

            ];

            $response = $this->application->BankAccount()->create($params);

            $this->assertNotEmpty($response, "Test: BankAccount");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [

            ];

            $response = $this->application->BankAccount()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->BankAccount()->update($id, $params);

            $this->assertNotEmpty($response, "Test: BankAccount");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [

            ];

            $response = $this->application->BankAccount()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->BankAccount()->delete($id, []);

            $this->assertNotEmpty($response, "Test: BankAccount");
        }
    }

    public function testBrand(): void
    {
        $reflection = new ReflectionClass(Brand::class);
        $response = $this->application->Brand()->get([]);

        $this->assertNotEmpty($response, "Test: Brand");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Brand $randomCode",
            ];

            $response = $this->application->Brand()->create($params);

            $this->assertNotEmpty($response, "Test: Brand");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Brand $randomCode",
            ];

            $response = $this->application->Brand()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Brand()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Brand");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Brand $randomCode",
            ];

            $response = $this->application->Brand()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Brand()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Brand");
        }
    }

    public function testCarrier(): void
    {
        $reflection = new ReflectionClass(Carrier::class);
        $response = $this->application->Carrier()->get([]);

        $this->assertNotEmpty($response, "Test: Carrier");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Description" => "Carrier $randomCode",
            ];

            $response = $this->application->Carrier()->create($params);

            $this->assertNotEmpty($response, "Test: Carrier");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Description" => "Carrier $randomCode",
            ];

            $response = $this->application->Carrier()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Carrier()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Carrier");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Description" => "Carrier $randomCode",
            ];

            $response = $this->application->Carrier()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Carrier()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Carrier");
        }
    }

    public function testCustomer(): void
    {
        $reflection = new ReflectionClass(Customer::class);
        $response = $this->application->Customer()->get([]);

        $this->assertNotEmpty($response, "Test: Customer");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "ACTIVE",
                "Name" => "Test Customer $randomCode",
                "PaymentTerm" => "30 days",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "AccountReceivable" => "1200",
                "RevenueAccount" => "4000",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Customer()->create($params);

            $this->assertNotEmpty($response, "Test: Customer");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "ACTIVE",
                "Name" => "Test Customer $randomCode",
                "PaymentTerm" => "30 days",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "AccountReceivable" => "1200",
                "RevenueAccount" => "4000",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Customer()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Customer()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Customer");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "ACTIVE",
                "Name" => "Test Customer $randomCode",
                "PaymentTerm" => "30 days",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "AccountReceivable" => "1200",
                "RevenueAccount" => "4000",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Customer()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Customer()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Customer");
        }
    }

    public function testFixedAssetType(): void
    {
        $reflection = new ReflectionClass(FixedAssetType::class);
        $response = $this->application->FixedAssetType()->get([]);

        $this->assertNotEmpty($response, "Test: FixedAssetType");
    }

    public function testJournal(): void
    {
        $reflection = new ReflectionClass(Journal::class);
        $response = $this->application->Journal()->get([]);

        $this->assertNotEmpty($response, "Test: Journal");
    }

    public function testLocation(): void
    {
        $reflection = new ReflectionClass(Location::class);
        $response = $this->application->Location()->get([]);

        $this->assertNotEmpty($response, "Test: Location");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Location $randomCode"
            ];

            $response = $this->application->Location()->create($params);

            $this->assertNotEmpty($response, "Test: Location");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Location $randomCode"
            ];

            $response = $this->application->Location()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Location()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Location");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Location $randomCode"
            ];

            $response = $this->application->Location()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Location()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Location");
        }
    }

    public function testMe(): void
    {
        $response = $this->application->Me()->get([]);
        $this->assertNotEmpty($response, "Test: Me");
    }

    public function testMeAddress(): void
    {
        $reflection = new ReflectionClass(MeAddress::class);
        $response = $this->application->MeAddress()->get([]);

        $this->assertNotEmpty($response, "Test: MeAddress");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Line1" => "business address $randomCode",
                "Line2" => null,
                "CitySuburb" => "DEFAULT City",
                "StateProvince" => "DEFAULT State",
                "ZipPostCode" => "DEFAULT Postcode",
                "Country" => "Australia",
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeAddress()->create($params);

            $this->assertNotEmpty($response, "Test: MeAddress");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Line1" => "business address $randomCode",
                "Line2" => null,
                "CitySuburb" => "DEFAULT City",
                "StateProvince" => "DEFAULT State",
                "ZipPostCode" => "DEFAULT Postcode",
                "Country" => "Australia",
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeAddress()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->MeAddress()->update($id, $params);

            $this->assertNotEmpty($response, "Test: MeAddress");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Line1" => "business address $randomCode",
                "Line2" => null,
                "CitySuburb" => "DEFAULT City",
                "StateProvince" => "DEFAULT State",
                "ZipPostCode" => "DEFAULT Postcode",
                "Country" => "Australia",
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeAddress()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->MeAddress()->delete($id, []);

            $this->assertNotEmpty($response, "Test: MeAddress");
        }
    }

    public function testMeContact(): void
    {
        $reflection = new ReflectionClass(MeContact::class);
        $response = $this->application->MeContact()->get([]);

        $this->assertNotEmpty($response, "Test: MeContact");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Business contact $randomCode",
                "Phone" => "12345678",
                "Fax" => null,
                "Email" => "test@test.com",
                "Website" => null,
                "Comment" => null,
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeContact()->create($params);

            $this->assertNotEmpty($response, "Test: MeContact");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Business contact $randomCode",
                "Phone" => "12345678",
                "Fax" => null,
                "Email" => "test@test.com",
                "Website" => null,
                "Comment" => null,
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeContact()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->MeContact()->update($id, $params);

            $this->assertNotEmpty($response, "Test: MeContact");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Business contact $randomCode",
                "Phone" => "12345678",
                "Fax" => null,
                "Email" => "test@test.com",
                "Website" => null,
                "Comment" => null,
                "Type" => "Business",
                "DefaultForType" => true
            ];

            $response = $this->application->MeContact()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->MeContact()->delete($id, []);

            $this->assertNotEmpty($response, "Test: MeContact");
        }
    }

    public function testPaymentTerm(): void
    {
        $reflection = new ReflectionClass(PaymentTerm::class);
        $response = $this->application->PaymentTerm()->get([]);

        $this->assertNotEmpty($response, "Test: PaymentTerm");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Payment Term $randomCode",
                "Method" => "Number of days"
            ];

            $response = $this->application->PaymentTerm()->create($params);

            $this->assertNotEmpty($response, "Test: PaymentTerm");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Payment Term $randomCode",
                "Method" => "Number of days"
            ];

            $response = $this->application->PaymentTerm()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->PaymentTerm()->update($id, $params);

            $this->assertNotEmpty($response, "Test: PaymentTerm");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Payment Term $randomCode",
                "Method" => "Number of days"
            ];

            $response = $this->application->PaymentTerm()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->PaymentTerm()->delete($id, []);

            $this->assertNotEmpty($response, "Test: PaymentTerm");
        }
    }

    public function testUnitOfMeasure(): void
    {
        $reflection = new ReflectionClass(UnitOfMeasure::class);
        $response = $this->application->UnitOfMeasure()->get([]);

        $this->assertNotEmpty($response, "Test: UnitOfMeasure");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Unit of Measure $randomCode",
            ];

            $response = $this->application->UnitOfMeasure()->create($params);

            $this->assertNotEmpty($response, "Test: UnitOfMeasure");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Unit of Measure $randomCode",
            ];

            $response = $this->application->UnitOfMeasure()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->UnitOfMeasure()->update($id, $params);

            $this->assertNotEmpty($response, "Test: UnitOfMeasure");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Unit of Measure $randomCode",
            ];

            $response = $this->application->UnitOfMeasure()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->UnitOfMeasure()->delete($id, []);

            $this->assertNotEmpty($response, "Test: UnitOfMeasure");
        }
    }

    public function testTax(): void
    {
        $reflection = new ReflectionClass(Tax::class);
        $response = $this->application->Tax()->get([]);

        $this->assertNotEmpty($response, "Test: Tax");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Test Tax $randomCode",
                "Account" => "2000",
                "IsActive" => true,
                "TaxInclusive" => false,
                "IsTaxForSale" => true,
                "IsTaxForPurchase" => false,
                "Components" => [
                    [
                        "Name" => "Tax 1st $randomCode",
                        "Percent" => "10.0000000000",
                        "AccountCode" => "2000",
                        "Compound" => false,
                        "ComponentOrder" => 1
                    ]
                ]
            ];

            $response = $this->application->Tax()->create($params);

            $this->assertNotEmpty($response, "Test: Tax");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Test Tax $randomCode",
                "Account" => "2000",
                "IsActive" => true,
                "TaxInclusive" => false,
                "IsTaxForSale" => true,
                "IsTaxForPurchase" => false,
                "Components" => [
                    [
                        "Name" => "Tax 1st $randomCode",
                        "Percent" => "10.0000000000",
                        "AccountCode" => "2000",
                        "Compound" => false,
                        "ComponentOrder" => 1
                    ]
                ]
            ];

            $response = $this->application->Tax()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Tax()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Tax");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Test Tax $randomCode",
                "Account" => "2000",
                "IsActive" => true,
                "TaxInclusive" => false,
                "IsTaxForSale" => true,
                "IsTaxForPurchase" => false,
                "Components" => [
                    [
                        "Name" => "Tax 1st $randomCode",
                        "Percent" => "10.0000000000",
                        "AccountCode" => "2000",
                        "Compound" => false,
                        "ComponentOrder" => 1
                    ]
                ]
            ];

            $response = $this->application->Tax()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Tax()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Tax");
        }
    }

    public function testProductAvailability(): void
    {
        $reflection = new ReflectionClass(ProductAvailability::class);
        $response = $this->application->ProductAvailability()->get([]);

        $this->assertNotEmpty($response, "Test: ProductAvailability");
    }

    public function testProductCategory(): void
    {
        $reflection = new ReflectionClass(ProductCategory::class);
        $response = $this->application->ProductCategory()->get([]);

        $this->assertNotEmpty($response, "Test: ProductCategory");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Category $randomCode"
            ];

            $response = $this->application->ProductCategory()->create($params);

            $this->assertNotEmpty($response, "Test: ProductCategory");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Category $randomCode"
            ];

            $response = $this->application->ProductCategory()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->ProductCategory()->update($id, $params);

            $this->assertNotEmpty($response, "Test: ProductCategory");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Name" => "Category $randomCode"
            ];

            $response = $this->application->ProductCategory()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->ProductCategory()->delete($id, []);

            $this->assertNotEmpty($response, "Test: ProductCategory");
        }
    }

    public function testSupplier(): void
    {
        $reflection = new ReflectionClass(Supplier::class);
        $response = $this->application->Supplier()->get([]);

        $this->assertNotEmpty($response, "Test: Supplier");

        if ($reflection->implementsInterface(PostMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "Active",
                "Name" => "Test Supplier $randomCode",
                "PaymentTerm" => "30 days",
                "AccountPayable" => "2000",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Supplier()->create($params);

            $this->assertNotEmpty($response, "Test: Supplier");
        }

        if ($reflection->implementsInterface(PutMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "Active",
                "Name" => "Test Supplier $randomCode",
                "PaymentTerm" => "30 days",
                "AccountPayable" => "2000",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Supplier()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Supplier()->update($id, $params);

            $this->assertNotEmpty($response, "Test: Supplier");
        }

        if ($reflection->implementsInterface(DeleteMethodAllowed::class)) {
            $randomCode = $this->getRandomCode();
            $params = [
                "Status" => "Active",
                "Name" => "Test Supplier $randomCode",
                "PaymentTerm" => "30 days",
                "AccountPayable" => "2000",
                "PriceTier" => "Tier 1",
                "Currency" => "AUD",
                "TaxRule" => "Auto Look Up",

            ];

            $response = $this->application->Supplier()->create($params);

            $id = $this->getId($response, __FUNCTION__);
            $response = $this->application->Supplier()->delete($id, []);

            $this->assertNotEmpty($response, "Test: Supplier");
        }
    }

    public function testAdvancedPurchase(): void
    {
        $parameters = $this->createPurchase();
        $response = $this->application->advancedPurchase()->create($parameters);

        $this->assertArrayHasKey('ID', $response);

        $response = $this->application->advancedPurchase()->find($response['ID']);
        $this->assertArrayHasKey('ID', $response);


        $response = $this->application->advancedPurchase()->delete($response['ID']);
        $this->assertArrayHasKey('ID', $response);
    }

    public function testPurchase(): void
    {
        $parameters = $this->createPurchase();
        $response = $this->application->purchase()->create($parameters);

        $this->assertArrayHasKey('ID', $response);

        $response = $this->application->purchase()->find($response['ID']);
        $this->assertArrayHasKey('ID', $response);


        $response = $this->application->purchase()->delete($response['ID']);
        $this->assertArrayHasKey('ID', $response);
    }

    protected function createPurchase(): array
    {
        $randomCode = $this->getRandomCode();
        return [
            "SupplierID" => "8946ca8f-0bf2-483b-88fc-70923d8bdd28",
            "Location" => "Main Warehouse",
            "CurrencyRate" => "1",
            "Approach" => "STOCK"
        ];
    }

    public function testSale(): void
    {
        $parameters = $this->createSale();
        $response = $this->application->sale()->create($parameters);

        $this->assertArrayHasKey('ID', $response);

        $response = $this->application->sale()->find($response['ID']);
        $this->assertArrayHasKey('ID', $response);


        $response = $this->application->sale()->delete($response['ID']);
        $this->assertArrayHasKey('ID', $response);
    }

    protected function createSale(): array
    {
        $randomCode = $this->getRandomCode();
        return [
            "CustomerID" => "53f8767f-c0ae-4346-9d4f-35103974d89e",
            "Location" => "Main Warehouse",
            "CurrencyRate" => "1"
        ];
    }

    public function testProductGet(): void
    {
        $data = $this->application->productFamily()->get([]);
        $this->assertArrayHasKey('ProductFamilies', $data);

        $data = $this->application->product()->get([]);
        $this->assertArrayHasKey('Products', $data);
    }

    public function testProductPost(): void
    {
        $parameters = $this->createProduct();
        $productResponse = $this->application->product()->create($parameters);

        $this->assertNotEmpty($productResponse['Products']);

        // Product family
        $parameters = $this->createProductFamily();
        $parameters['Products'] = [];
        $parameters['Products'][] = [
            'ID' => $productResponse['Products'][0]['ID'],
            'SKU' => $productResponse['Products'][0]['SKU'],
            'Name' => $productResponse['Products'][0]['Name'],
            'Option1' => '1',
        ];

        $response = $this->application->productFamily()->create($parameters);

        $this->assertNotEmpty($response['ProductFamilies']);
    }

    public function testProductPut(): void
    {
        $parameters = $this->createProduct();
        $response = $this->application->product()->create($parameters);

        $parameters['Name'] = 'Update Test Product';
        $id = $response['Products'][0]['ID'];
        $response = $this->application->product()->update($id, $parameters);

        $this->assertEquals('Update Test Product', $response['Products'][0]['Name']);
    }

    protected function createProduct(): array
    {
        $randomCode = $this->getRandomCode();
        return [
            "SKU" => $randomCode,
            "Status" => "Active",
            "Name" => "Test Product Family $randomCode",
            "Category" => "Gloves",
            "Brand" => null,
            "Type" => "Stock",
            "CostingMethod" => "FIFO",
            "DefaultLocation" => "Main Warehouse",
            "UOM" => "Item",
            "Option1Name" => "Option 1",
            "PriceTier1" => 140.0000,
        ];
    }

    protected function createProductFamily(): array
    {
        $randomCode = $this->getRandomCode();
        return [
            "SKU" => $randomCode,
            "Status" => "Active",
            "Name" => "Test Product Family $randomCode",
            "Category" => "Gloves",
            "Brand" => null,
            "Type" => "Stock",
            "CostingMethod" => "FIFO",
            "DefaultLocation" => "Main Warehouse",
            "UOM" => "Item",
            "Option1Name" => "Option 1",
            "PriceTier1" => 140.0000,
        ];
    }

    public function testWebhooks(): void
    {
        $response = $this->application->webhooks()->get([]);
        $this->assertNotEmpty($response);

        $webhookParams = $this->createWebhooks();
        $response = $this->application->webhooks()->create($webhookParams);
        $id = $this->getId($response, __FUNCTION__);
        $this->assertNotNull($id);

        $response = $this->application->webhooks()->update($id, $webhookParams);
        $this->assertNotEmpty($response['ID']);

        $response = $this->application->webhooks()->delete($id, []);
        $this->assertArrayHasKey('Webhooks', $response);
    }

    protected function createWebhooks(): array
    {
        $randomCode = $this->getRandomCode();
        return [
            "Type" => "Sale/OrderAuthorised",
            "IsActive" => true,
            "ExternalURL" => "http://127.0.0.1/webhooks/",
	        "Name" => "Order Authorised $randomCode",
            "ExternalAuthorizationType" => "basicauth",
            "ExternalUserName" => "$randomCode",
            "ExternalPassword" => "$randomCode",
            "ExternalBearerToken" => ""
        ];
    }
}