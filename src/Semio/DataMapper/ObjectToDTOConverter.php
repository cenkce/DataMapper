<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nullcappone
 * Date: 2/26/13
 * Time: 2:20 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Semio\DataMapper;

class ObjectToDTOConverter extends EntityToDTOConverter
{
    protected function getDTOClass($obj)
    {
        return $obj->class;
    }

}
