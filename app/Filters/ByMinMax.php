<?php
    namespace App\Filters;

    class ByMinMax{
        public function handle($request, \Closure $next)
        {
            $builder = $next($request);
            if(request()->has('amount_start') && request()->has('amount_end')){
                return $builder
                ->whereBetween('price',[request()->query('amount_start'), request()->query('amount_end')]);
            }
            return $builder;
        }
    }
?>
