<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Util\AbstractController;
use App\Services\CategoryService;
use App\Services\CountryService;
use Illuminate\Http\Request;
use App\Services\PromocodeService;
use Response;

class PromocodeController extends AbstractController {

    public $promocodeService, $categoryService;
    public function __construct(PromocodeService $promocodeService, CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->promocodeService = $promocodeService;
        $this->categoryService = $categoryService;
    }

    /**
     * List all clients.
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function index(Request $request)
    {
        $categories  = $this->categoryService->listCategories();
        $promocodes  = $this->promocodeService->listPromocodes();
        $tableData = $this->promocodeService->datatables($promocodes);

        if($request->ajax())
            return $tableData;

        return view('promocodes.index')
              ->with('categories', $categories)
              ->with('modal', 'promocodes')
              ->with('modal_', 'كوبونات الخصم')
              ->with('tableData', $tableData);
    }

    /**
     * Update client.
     * requirements={
     *      {"name"="name_ar", "dataType"="String", "requirement"="\d+", "description"="client name ar"},
     *      {"name"="name_en", "dataType"="String", "requirement"="\d+", "description"="client name en"},
     *      {"name"="type", "dataType"="String", "requirement"="\d+", "description"="client type"},
     *  }
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function store(Request $request)
    {
        $data  = $request->all();
        $promocode = $this->promocodeService->createPromocode($data);
        return $promocode;
    }
    /**
     * Edit client.
     * requirements={
     *      {"name"="id", "dataType"="Integer", "requirement"="\d+", "description"="client id"}
     *  }
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function edit(Request $request , $id)
    {
        $promocode = $this->promocodeService->getPromocode($id);
        session(['promocodeId' => $id]);
        return Response::json(['msg'=>'Adding Successfully','data'=> $promocode->toJson()]);
    }

    /**
     * Update client.
     * requirements={
     *      {"name"="id", "dataType"="Integer", "requirement"="\d+", "description"="client id"},
     *      {"name"="name_ar", "dataType"="String", "requirement"="\d+", "description"="client name ar"},
     *      {"name"="name_en", "dataType"="String", "requirement"="\d+", "description"="client name en"},
     *      {"name"="type", "dataType"="String", "requirement"="\d+", "description"="client type"},
     *  }
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function update(Request $request)
    {
        $data  = $request->all();
        $promocode = $this->promocodeService->updatePromocode($data, session('promocodeId'));

        return $promocode;
    }

    /**
     * Delete client.
     * requirements={
     *      {"name"="id", "dataType"="Integer", "requirement"="\d+", "description"="client id"}
     *  }
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function destroy(Request $request, $id)
    {
        $promocode = $this->promocodeService->deletePromocode($id);

        if($request->ajax())
        {
            return Response::json(['msg'=>'Deleted Successfully',200]);
        }
        return redirect()->back();
    }
}
