<?php

namespace AB\Bundle\ApiEntity;

class ApiGroupCollection {
	public $groups;

	public static function fromGroupArray(array $groups) {
		$groupCol = new ApiGroupCollection;
		$groupsArray = array();
		foreach ($groups as $g) {
			$groupCol->groups[$g->getId()] = ApiGroup::fromGroup($g);
		}

		return $groupCol;
	}
}