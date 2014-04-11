<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Groups\Services;
use \Rendes\Services\BaseService;

class GroupService extends BaseService
{

    public function populate(\Rendes\Modules\Groups\Entities\Group $group, $groupData)
    {
        $group->setName($groupData['name']);
        $group->setDescription($groupData['description']);
		$group->setIsPublic($groupData['isPublic']);
        return $group;
    }

}