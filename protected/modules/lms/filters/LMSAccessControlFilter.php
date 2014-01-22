<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 24.11.13
 * Time: 16:08
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Filters;

class LMSAccessControlFilter extends \CAccessControlFilter
{
    protected function preFilter($filterChain)
    {
        $app=\Yii::app();
        $request=$app->getRequest();
        $user=\Yii::app()->getModule('lms')->getModule('user')->user;
        $verb=$request->getRequestType();
        $ip=$request->getUserHostAddress();

        foreach($this->getRules() as $rule)
        {
            if(($allow=$rule->isUserAllowed($user,$filterChain->controller,$filterChain->action,$ip,$verb))>0) // allowed
            break;
            elseif($allow<0) // denied
            {
                if(isset($rule->deniedCallback))
                    call_user_func($rule->deniedCallback, $rule);
                else
                    $this->accessDenied($user,$this->resolveErrorMessage($rule));
                return false;
            }
        }

        return true;
    }
}