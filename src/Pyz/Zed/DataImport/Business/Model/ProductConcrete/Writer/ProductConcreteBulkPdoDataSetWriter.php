<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer;

use Pyz\Zed\DataImport\Business\Model\DataFormatter\DataFormatter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\Sql\ProductConcreteSqlInterface;
use Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\Product\Dependency\ProductEvents;

class ProductConcreteBulkPdoDataSetWriter implements DataSetWriterInterface
{
    use DataFormatter;

    const BULK_SIZE = 3000;

    /**
     * @var array
     */
    protected static $productConcreteCollection = [];

    /**
     * @var array
     */
    protected static $productLocalizedAttributesCollection = [];

    /**
     * @var array
     */
    protected static $productBundleCollection = [];

    /**
     * @var array
     */
    protected static $productConcreteUpdated = [];

    /**
     * @var array
     */
    protected static $productSearchCollection = [];

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\Sql\ProductConcreteSqlInterface
     */
    protected $productConcreteSql;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface
     */
    protected $propelExecutor;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\Sql\ProductConcreteSqlInterface $productConcreteSql
     * @param \Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface $propelExecutor
     */
    public function __construct(
        ProductConcreteSqlInterface $productConcreteSql,
        PropelExecutorInterface $propelExecutor
    ) {
        $this->productConcreteSql = $productConcreteSql;
        $this->propelExecutor = $propelExecutor;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $this->collectProductConcrete($dataSet);
        $this->collectProductConcreteLocalizedAttributes($dataSet);
        $this->collectProductConcreteBundle($dataSet);

        if (count(static::$productConcreteCollection) >= static::BULK_SIZE) {
            $this->flush();
        }
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->persistConcreteProductEntities();
        $this->persistConcreteProductLocalizedAttributesEntities();
        $this->persistConcreteProductSearchEntities();
        $this->persistConcreteProductBundleEntities();

        //TODO this is wrong place
        foreach (static::$productConcreteUpdated as $concreteProductId) {
            DataImporterPublisher::addEvent(ProductEvents::PRODUCT_CONCRETE_PUBLISH, $concreteProductId);
        }

        DataImporterPublisher::triggerEvents();
        $this->flushMemory();
    }

    /**
     * @return void
     */
    protected function persistConcreteProductEntities(): void
    {
        $sku = $this->formatPostgresArrayString(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_SKU)
        );
        $attributes = $this->formatPostgresArrayFromJson(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_ATTRIBUTES)
        );
        $discount = $this->formatPostgresArray(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_DISCOUNT)
        );
        $warehouses = $this->formatPostgresArrayString(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_WAREHOUSES)
        );
        $isActive = $this->formatPostgresArray(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_IS_ACTIVE)
        );
        $skuProductAbstract = $this->formatPostgresArrayString(
            $this->getCollectionDataByKey(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_ABSTRACT_SKU)
        );

        $sql = $this->productConcreteSql->createConcreteProductSQL();
        $parameters = [
            $discount,
            $warehouses,
            $sku,
            $isActive,
            $attributes,
            $skuProductAbstract,
        ];
        $result = $this->propelExecutor->execute($sql, $parameters);
        foreach ($result as $columns) {
            static::$productConcreteUpdated[] = $columns[ProductConcreteHydratorStep::KEY_ID_PRODUCT];
        }
    }

    /**
     * @return void
     */
    protected function persistConcreteProductLocalizedAttributesEntities(): void
    {
        if (!empty(static::$productLocalizedAttributesCollection)) {
            $sku = $this->formatPostgresArrayString(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_SKU)
            );
            $idLocale = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_FK_LOCALE)
            );
            $name = $this->formatPostgresArrayString(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_NAME)
            );
            $isComplete = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_IS_COMPLETE)
            );
            $description = $this->formatPostgresArrayString(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_DESCRIPTION)
            );
            $attributes = $this->formatPostgresArrayFromJson(
                $this->getCollectionDataByKey(static::$productLocalizedAttributesCollection, ProductConcreteHydratorStep::KEY_ATTRIBUTES)
            );

            $sql = $this->productConcreteSql->createConcreteProductLocalizedAttributesSQL();
            $parameters = [
                $sku,
                $name,
                $description,
                $attributes,
                $isComplete,
                $idLocale,
            ];
            $this->propelExecutor->execute($sql, $parameters);
        }
    }

    /**
     * @return void
     */
    protected function persistConcreteProductSearchEntities(): void
    {
        if (!empty(static::$productSearchCollection)) {
            $idLocale = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productSearchCollection, ProductConcreteHydratorStep::KEY_FK_LOCALE)
            );
            $isSearchable = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productSearchCollection, ProductConcreteHydratorStep::KEY_IS_SEARCHABLE)
            );
            $sku = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productSearchCollection, ProductConcreteHydratorStep::KEY_SKU)
            );

            $sql = $this->productConcreteSql->createConcreteProductSearchSQL();
            $parameters = [
                $idLocale,
                $sku,
                $isSearchable,
            ];
            $this->propelExecutor->execute($sql, $parameters);
        }
    }

    /**
     * @return void
     */
    protected function persistConcreteProductBundleEntities(): void
    {
        if (!empty(static::$productBundleCollection)) {
            $bundledProductSku = $this->formatPostgresArrayString(
                $this->getCollectionDataByKey(static::$productBundleCollection, ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_SKU)
            );
            $sku = $this->formatPostgresArrayString(
                $this->getCollectionDataByKey(static::$productBundleCollection, ProductConcreteHydratorStep::KEY_SKU)
            );
            $quantity = $this->formatPostgresArray(
                $this->getCollectionDataByKey(static::$productBundleCollection, ProductConcreteHydratorStep::KEY_QUANTITY)
            );

            $sql = $this->productConcreteSql->createConcreteProductBundleSQL();
            $parameters = [
                $bundledProductSku,
                $sku,
                $quantity,
            ];
            $this->propelExecutor->execute($sql, $parameters);
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function collectProductConcrete(DataSetInterface $dataSet): void
    {
        if (!$this->isSkuAlreadyCollected($dataSet)) {
            $productConcreteTransfer = $dataSet[ProductConcreteHydratorStep::PRODUCT_CONCRETE_TRANSFER]->modifiedToArray();
            $productConcreteTransfer[ProductConcreteHydratorStep::KEY_ABSTRACT_SKU] = $dataSet[ProductConcreteHydratorStep::KEY_ABSTRACT_SKU];
            static::$productConcreteCollection[] = $productConcreteTransfer;
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return bool
     */
    protected function isSkuAlreadyCollected(DataSetInterface $dataSet)
    {
        $collectedSkus = array_column(static::$productConcreteCollection, ProductConcreteHydratorStep::KEY_SKU);
        $dataSetSku = $dataSet[ProductConcreteHydratorStep::PRODUCT_CONCRETE_TRANSFER]->getSku();

        return in_array($dataSetSku, $collectedSkus);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function collectProductConcreteLocalizedAttributes(DataSetInterface $dataSet): void
    {
        foreach ($dataSet[ProductConcreteHydratorStep::PRODUCT_CONCRETE_LOCALIZED_TRANSFER] as $productConcreteLocalizedTransfer) {
            $productSearchArray = $productConcreteLocalizedTransfer[ProductConcreteHydratorStep::KEY_PRODUCT_SEARCH_TRANSFER]->modifiedToArray();
            $productSearchArray[ProductConcreteHydratorStep::KEY_SKU] = $productConcreteLocalizedTransfer[ProductConcreteHydratorStep::KEY_SKU];

            $localizedAttributeArray = $productConcreteLocalizedTransfer[ProductConcreteHydratorStep::KEY_PRODUCT_CONCRETE_LOCALIZED_TRANSFER]->modifiedToArray();
            $localizedAttributeArray[ProductConcreteHydratorStep::KEY_SKU] = $productConcreteLocalizedTransfer[ProductConcreteHydratorStep::KEY_SKU];
            $localizedAttributeArray[ProductConcreteHydratorStep::KEY_DESCRIPTION] = str_replace(
                '"',
                '',
                $localizedAttributeArray[ProductConcreteHydratorStep::KEY_DESCRIPTION]
            );

            static::$productLocalizedAttributesCollection[] = $localizedAttributeArray;
            static::$productSearchCollection[] = $productSearchArray;
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function collectProductConcreteBundle(DataSetInterface $dataSet): void
    {
        foreach ($dataSet[ProductConcreteHydratorStep::PRODUCT_BUNDLE_TRANSFER] as $productConcreteBundleTransfer) {
            $productConcreteBundleArray = $productConcreteBundleTransfer[ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_TRANSFER]->modifiedToArray();
            $productConcreteBundleArray[ProductConcreteHydratorStep::KEY_SKU] = $productConcreteBundleTransfer[ProductConcreteHydratorStep::KEY_SKU];
            $productConcreteBundleArray[ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_SKU] = $productConcreteBundleTransfer[ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_SKU];

            static::$productBundleCollection[] = $productConcreteBundleArray;
        }
    }

    /**
     * @return void
     */
    protected function flushMemory(): void
    {
        static::$productConcreteCollection = [];
        static::$productLocalizedAttributesCollection = [];
        static::$productSearchCollection = [];
        static::$productBundleCollection = [];
        static::$productConcreteUpdated = [];
    }
}
