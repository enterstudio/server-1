<?php
/**
 * @package plugins.reach
 */
class kReachUtils
{
	/**
	 * @param $entryId
	 * @return string
	 * @throws Exception
	 */
	public static function generateReachVendorKs($entryId)
	{
		$entry = entryPeer::retrieveByPK($entryId);
		if (!$entry)
			throw new Exception("Entry Id [$entryId] not Found to create REACH Vendor limited session");

		$partner = $entry->getPartner();

		// Limit the KS to edit access a specific entry
		$privileges = kSessionBase::PRIVILEGE_EDIT . ':' . $entryId;

		// Limit the KS to use only the Vendor Role
		$privileges .= ',' . kSessionBase::PRIVILEGE_SET_ROLE . ':' . UserRoleId::REACH_VENDOR_ROLE;

		// Disable entitlement to avoid entitlement validation when accessing an entry
		$privileges .= ',' . kSessionBase::PRIVILEGE_DISABLE_ENTITLEMENT_FOR_ENTRY. ':' . $entryId;

		$limitedKs = '';
		$result = kSessionUtils::startKSession($partner->getId(), $partner->getSecret(), '', $limitedKs, dateUtils::DAY, kSessionBase::SESSION_TYPE_USER, '', $privileges, null, null);
		if ($result < 0)
			throw new Exception('Failed to create REACH Vendor limited session for partner '.$partner->getId());

		return $limitedKs;
	}
	
	public static function calcPricePerSecond(entry $entry, $pricePerUnit)
	{
		return ($entry->getLengthInMsecs()/1000) * $pricePerUnit;
	}

	public static function calcPricePerMinute(entry $entry, $pricePerUnit)
	{
		return ($entry->getLengthInMsecs()/1000/dateUtils::MINUTE) * $pricePerUnit;
	}
	
	public static function calculateTaskPrice(entry $entry, VendorCatalogItem $vendorCatalogItem)
	{
		return call_user_func($vendorCatalogItem->getPricing()->getPriceFunction(), $entry, $vendorCatalogItem->getPricing()->getPricePerUnit());
	}
	
	public static function isEnoughCreditLeft(EntryVendorTask $entryVendorTask)
	{
		$vendorProfile = $entryVendorTask->getVendorProfile();
		return $vendorProfile->isEnoughCreditLeft($entryVendorTask->getPrice());
	}
}