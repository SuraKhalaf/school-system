<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="School System ApplicationAPI",
 *    version="1.0.0",
 *    description="Demo School System API",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
}
