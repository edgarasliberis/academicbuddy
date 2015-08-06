<?php

namespace AB\Bundle\ApiEntity;

use JMS\Serializer\Annotation\Type;

// Projection of a Entity\User class for the Group API
class ApiUser {

	/**
	 * @Type("integer")
	 */
	public $id;

	/**
	 * @Type("string")
	 */
	public $name;

	/**
	 * @Type("string")
	 */
	public $email;

	public static function fromUser(\AB\Bundle\Entity\User $u = null) {
		if(is_null($u)) return null;
		$user = new ApiUser;
		$user->id = $u->getId();
		$user->name = $u->getFirstName() . ' ' . $u->getLastName();
		$user->email = $u->getEmail();
		return $user;
	}
}


?>