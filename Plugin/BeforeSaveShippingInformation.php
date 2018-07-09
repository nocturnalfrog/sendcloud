<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 12-4-18
 * Time: 9:30
 */

namespace SendCloud\SendCloud\Plugin;


use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Framework\App\RequestInterface;
use Magento\Quote\Model\QuoteRepository;

class BeforeSaveShippingInformation
{
    private $request;
    private $quoteRepository;

    public function __construct(
        RequestInterface $request,
        QuoteRepository $quoteRepository
    )
    {
        $this->request = $request;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param ShippingInformationManagement $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSaveAddressInformation(ShippingInformationManagement $subject, $cartId, ShippingInformationInterface $addressInformation)
    {
        $extensionAttributes = $addressInformation->getExtensionAttributes();
        $spId = $extensionAttributes->getSendcloudServicePointId();
        $spName = $extensionAttributes->getSendcloudServicePointName();
        $spStreet = $extensionAttributes->getSendcloudServicePointStreet();
        $spHouseNumber = $extensionAttributes->getSendcloudServicePointHouseNumber();
        $spZipCode = $extensionAttributes->getSendcloudServicePointZipCode();
        $spCity = $extensionAttributes->getSendcloudServicePointCity();
        $spCountry = $extensionAttributes->getSendcloudServicePointCountry();

        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setSendcloudServicePointId($spId);
        $quote->setSendcloudServicePointName($spName);
        $quote->setSendcloudServicePointStreet($spStreet);
        $quote->setSendcloudServicePointHouseNumber($spHouseNumber);
        $quote->setSendcloudServicePointZipCode($spZipCode);
        $quote->setSendcloudServicePointCity($spCity);
        $quote->setSendcloudServicePointCountry($spCountry);
    }
}