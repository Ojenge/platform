<?php

/**
 * Ushahidi Permission Entity
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\Core\Entity;

use Ushahidi\Core\StaticEntity;

class Permission extends StaticEntity
{
	protected $id;
	protected $name;
	protected $description;

	// Standard permissions names
	const DataImport      = 'Bulk Data Import';
	const ManagePosts     = 'Manage Posts';
	const ManageSettings  = 'Manage Settings';
	const ManageUsers     = 'Manage Users';
	const EditOwnPosts    = 'Edit their own posts';

	// DataTransformer
	public function getDefinition()
	{
		return [
			'id'           => 'int',
			'name'         => 'string',
			'description'  => 'string',
		];
	}

	// Entity
	public function getResource()
	{
		return 'permission';
	}

	// StatefulData
	protected function getImmutable()
	{
		return array_merge(parent::getImmutable(), ['name']);
	}
}
