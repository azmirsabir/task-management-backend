<?php
  
  use Illuminate\Pagination\LengthAwarePaginator;
  
  if(!function_exists("orderByColumn")) {
    function orderByColumn(&$query, $request): void
    {
      $dir='asc';
      if($request->has('order_by')) {
        $order_by = $request->query('order_by', 'created_at');
        
        if (str_starts_with($order_by, '-')) {
          $dir='desc';
          $order_by = substr($order_by, 1);
        }
        $query=$query->orderBy($order_by,$dir);
      }
    }
  }
  
  if(!function_exists("addPagination")) {
    function addPagination(&$query, $request):array
    {
      $data=[];
      if($request->has("per_page")) {
        $perPage = $request->query('per_page', 10);
        $currentPage = $request->query('page', 1);
        
        $totalCount = $query->count();
        $totalPages = ceil($totalCount / $perPage);
        $firstPage = $totalPages>0 ? ($currentPage-1) *$perPage +1 : null;
        $to=$totalPages>0?$firstPage+$perPage-1:null;
        $lastPage=max($totalPages,1);
        $data= [
          'total'=>$totalCount,
          'totalPages'=>$totalPages,
          'perPage'=>$perPage,
          'currentPage'=>$currentPage,
          'lastPage'=>$lastPage,
          'isLastPage'=>$currentPage==$lastPage,
          'isFirstPage'=>$currentPage==1,
          'from'=>$firstPage,
          'to'=> min($totalCount, (int)$to),
        ];
        $skip=$perPage*($currentPage-1);
        $query=$query->skip($skip)->take($perPage);
      }
      
      return $data;
    }
  }
  
  if(!function_exists("pag")) {
    function pag(LengthAwarePaginator $paginator)
    {
      return response()->json(
        [
        'status'=>200,
        'message'=>'success',
        'data' => $paginator->items(),
        'meta' => [
          'pagination' => [
            'total' => $paginator->total(),
            'count' => $paginator->count(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'total_pages' => $paginator->lastPage(),
            'links' => [
              'prev' => $paginator->previousPageUrl(),
              'next' => $paginator->nextPageUrl(),
            ],
          ],
        ],
      ]);
    }
  }
