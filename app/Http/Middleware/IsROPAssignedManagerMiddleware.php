<?php

namespace App\Http\Middleware;

use App\Models\Manager;
use Closure;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsROPAssignedManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {



        if(session()->get('r')) {
            /** проверим право редактировать этого менеджера
             * обязательный параметр
             */

            if($request->manager_id) {

                /** @var  $result  / если true, то менеджер принадлежит данному РОПу */
                $result = ROPViewModel::make()
                    ->ropManagerId(ROPViewModel::make()->r(session()->get('r'))->id,
                        $request->manager_id);

                if($result) {
                    return $next($request);
                }

                return redirect()->back();



            }

        }


        return redirect(route('rop_login'));



    }
}
