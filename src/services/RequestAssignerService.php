<?php

namespace app\services;

use app\models\Manager;
use app\models\Request;

class RequestAssignerService
{
    public static function assign(Request $request)
    {
        $duplicateRequest = Request::findDuplicate($request);
        $previousManagerDuplicateRequest = Manager::findOne($duplicateRequest->manager_id);
        $managerId = null;

        if ($duplicateRequest && $previousManagerDuplicateRequest->is_works) {
            $managerId = $previousManagerDuplicateRequest->id;
        } elseif (!$duplicateRequest || !$previousManagerDuplicateRequest->is_works) {
            $managerId = Manager::getManagerWithMinimalRequests()->id;
        }

        $request->manager_id = $managerId;

        $request->save();
    }
}
