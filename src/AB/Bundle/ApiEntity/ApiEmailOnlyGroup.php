<?php
namespace AB\Bundle\ApiEntity;

use JMS\Serializer\Annotation\Type;

// Group where users are identified using only the email. U
// Used while sending emails using pairings' JSON file.
// Should be removed when we only permit GUI group allocation.
class ApiEmailOnlyGroup {
	/**
	 * @Type("string")
	 */
	public $mentor;

	/**
	 * @Type("string")
	 */
	public $secondaryMentor;

	/**
	 * @Type("array<string>")
	 */
	public $pupils;
}

?>