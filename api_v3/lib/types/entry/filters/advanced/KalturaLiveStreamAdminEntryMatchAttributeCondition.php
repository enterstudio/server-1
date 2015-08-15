<?php

/**
 * Auto-generated class.
 * 
 * Used to search KalturaLiveStreamAdminEntry attributes. Use KalturaLiveStreamAdminEntryMatchAttribute enum to provide attribute name.
*/
class KalturaLiveStreamAdminEntryMatchAttributeCondition extends KalturaSearchMatchAttributeCondition
{
	/**
	 * @var KalturaLiveStreamAdminEntryMatchAttribute
	 */
	public $attribute;

	private static $mapBetweenObjects = array
	(
		"attribute" => "attribute",
	);

	public function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects() , self::$mapBetweenObjects);
	}

	protected function getIndexClass()
	{
		return 'entryIndex';
	}
}

