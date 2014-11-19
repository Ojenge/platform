<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi User Create Validator
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Ushahidi\Core\Data;
use Ushahidi\Core\Tool\Validator;
use Ushahidi\Core\Entity\UserRepository;
use Ushahidi\Core\Entity\RoleRepository;

class Ushahidi_Validator_User_Create implements Validator
{	
	protected $repo;
	protected $valid;

	public function __construct(UserRepository $repo, RoleRepository $role)
	{
		$this->repo = $repo;
		$this->role = $role;
	}

	public function check(Data $input)
	{
		$this->valid = Validation::factory($input->asArray());
		$this->valid
			->rules('email', [
								['not_empty'], 
								['email'],
								[[$this->repo, 'isUniqueEmail'], [':value']]
							]
					)
			->rules('realname', [
									['regex', [':value', '/^[a-z0-9 .\-]+$/i']]
								]
					)
			->rules('username', [
								['not_empty'], 
								[[$this->repo, 'isUniqueUsername'], [':value']],
								['regex', [':value', '/^[a-z][a-z0-9._-]+[a-z0-9]$/i']],
							]
					)
			->rules('password', [
									['not_empty'],
									['min_length', [':value', 7]],
									['max_length', [':value', 72]]
								]
					)
			->rules('role', [
								[[$this->role, 'doesRoleExist'], [':value']]
							]
					);	

		return $this->valid->check();
	}


	public function errors($from = 'user')
	{
		return $this->valid->errors($from);
	}
}
