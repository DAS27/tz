<?php

namespace app\services;

use app\models\Manager;
use app\models\Request;

class RequestAssignerService
{
    public static function assign(Request $request)
    {
        $duplicateRequest = Request::findDuplicate($request);
        $managerId = null;

        if ($duplicateRequest) {
            $previousManagerDuplicateRequest = Manager::findOne($duplicateRequest->manager_id);
            if ($previousManagerDuplicateRequest->is_works) {
                $managerId = $previousManagerDuplicateRequest->id;
            }
        }

        if ($managerId == null) {
            $managerId = Manager::getManagerWithMinimalRequests()->id;
        }

        $request->manager_id = $managerId;

        $request->save();
    }
}
