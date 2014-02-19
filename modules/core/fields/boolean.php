<?php
/**
 * Parsimony
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@parsimony-cms.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Parsimony to newer
 * versions in the future. If you wish to customize Parsimony for your
 * needs please refer to http://www.parsimony.mobi for more information.
 *
 * @authors Julien Gras et Benoît Lorillot
 * @copyright Julien Gras et Benoît Lorillot
 * 
 * @category Parsimony
 * @package core\fields
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace core\fields;

/**
 * @title Boolean
 * @description Boolean
 * @copyright 1
 * @browsers all
 * @php_version_min 5.3
 * @modules_dependencies core:1
 */

class boolean extends \field {
	
	protected $type = 'BOOLEAN';
	protected $characters_max = '';
	protected $characters_min = 1;
	protected $regex = '^[0-1]$';
	protected $states = 'off,on';
	
	/**
	 * Validate field
	 * @param string $value
	 * @return string
	 */
	public function validate($value) {
		if ($value != 1) {
			$value = 0;
		}
		return $value;
	}
	
	public function getAllValues() {
		return explode(',', $this->states);
	}

}

?>
