<?php

namespace AB\Bundle\ApiEntity;

class ApiUserCollection {
	public $pupils;
	public $mentors;

	public static function fromPupilsMentorsArrays(array $pupils, array $mentors) {
		$userCol = new ApiUserCollection;
		$userCol->pupils = array_map(function($u) { return ApiUser::fromUser($u); }, $pupils);
		$userCol->mentors = array_map(function($u) { return ApiUser::fromUser($u); }, $mentors);
		return $userCol;
	}
}

?>