<?php

namespace AB\Bundle\ApiEntity;

// Projection of a Entity\Group class for the Group API
class ApiGroup {
	public $mentor;
	public $secondaryMentor;
	public $pupils;

	public static function fromGroup(\AB\Bundle\Entity\Group $g) {
		$group = new ApiGroup;
		$group->mentor = ApiUser::fromUser($g->getMentor());
        $group->secondaryMentor = ApiUser::fromUser($g->getSecondaryMentor());
        $group->pupils = array_map(
        	function($u) { return ApiUser::fromUser($u); }, 
            $g->getPupils()->getValues());
        return $group;
	}
}

?>