<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductOption\Business\Internal\DemoData;

use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface;
use Spryker\Zed\Installer\Business\Model\AbstractInstaller;

class ProductOptionDataInstall extends AbstractInstaller
{

    /**
     * @var \Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface
     */
    protected $optionWriter;

    /**
     * @var \Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface
     */
    protected $productOptionWriter;

    /**
     * @param \Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface $optionWriter
     * @param \Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Writer\WriterInterface $ProductOptionWriter
     */
    public function __construct(
        WriterInterface $optionWriter,
        WriterInterface $ProductOptionWriter
    ) {
        $this->optionWriter = $optionWriter;
        $this->productOptionWriter = $ProductOptionWriter;
    }

    /**
     * @return void
     */
    public function install()
    {
        $this->info('This will install some demo product options and product option assignments');

        $this->optionWriter->write();
        $this->productOptionWriter->write();
    }

}
