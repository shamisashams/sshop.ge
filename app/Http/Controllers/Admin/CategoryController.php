<?php
/**
 *  app/Http/Controllers/Admin/CategoryController.php
 *
 * Date-Time: 30.07.21
 * Time: 09:18
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryColor;
use App\Models\Language;
use App\Models\Translations\CategoryTranslation;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryColorRepository;
use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    /**
     * @var \App\Repositories\CategoryRepositoryInterface
     */
    private $categoryRepository;
    private $categoryColorRepository;

    /**
     * @param \App\Repositories\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryColorRepository $categoryColorRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryColorRepository = $categoryColorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(CategoryRequest $request)
    {
//        dd($languages = Language::where('status' ,true)->pluck('title', 'locale'));
        return view('admin.nowa.views.categories.index', [
            'data' => $this->categoryRepository->getData($request, ['translations','ancestors'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $category = $this->categoryRepository->model;
        $categories = $this->categoryRepository->getCategoryTree();

        //dd($categories);

        $url = locale_route('category.store', [], false);
        $method = 'POST';

        return view('admin.nowa.views.categories.form', [
            'category' => $category,
            'url' => $url,
            'method' => $method,
            'categories' => $categories,
            'attributes' => Attribute::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
       //dd($request->all());
        $saveData = Arr::except($request->except('_token','path'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['corner'] = isset($saveData['corner']) && (bool)$saveData['corner'];
        $saveData['size'] = isset($saveData['size']) && (bool)$saveData['size'];
        $saveData['color'] = isset($saveData['color']) && (bool)$saveData['color'];
        $saveData['parent_id'] = $saveData['parent_id'] ? $saveData['parent_id'] : null;
        $saveData['on_page'] = isset($saveData['on_page']) && (bool)$saveData['on_page'];

        $filter = isset($saveData['filter']) ?? null;
        unset($saveData['filter']);
        if($filter == 'corner_color'){
            $saveData['corner'] = 1;
            $saveData['color'] = 1;
            $saveData['size'] = 0;
        }
        if($filter == 'size_color'){
            $saveData['corner'] = 0;
            $saveData['color'] = 1;
            $saveData['size'] = 1;
        }
        if($filter == 'size'){
            $saveData['corner'] = 0;
            $saveData['color'] = 0;
            $saveData['size'] = 1;
        }
        if($filter == 'color'){
            $saveData['corner'] = 0;
            $saveData['color'] = 1;
            $saveData['size'] = 0;
        }
        if($filter == 'corner_size_color'){
            $saveData['corner'] = 1;
            $saveData['color'] = 1;
            $saveData['size'] = 1;
        }
        if(!$filter){
            $saveData['corner'] = 0;
            $saveData['color'] = 0;
            $saveData['size'] = 0;
        }
        //dd($saveData);
        $category = $this->categoryRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $category = $this->categoryRepository->saveFiles($category->id, $request);
        }

        $category->attributes()->sync($saveData['attributes'] ?? []);

        return redirect(locale_route('category.index', $category->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $locale, Category $category)
    {
        return view('admin.pages.category.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, Category $category, CategoryRepository $categoryRepository)
    {
        $url = locale_route('category.update', $category->id, false);
        $method = 'PUT';

        $categories = $this->categoryRepository->getCategoryTreeWithoutDescendant($category->id);



        return view('admin.nowa.views.categories.form', [
            'category' => $category,
            'url' => $url,
            'method' => $method,
            'categories' => $categories,
            'attributes' => Attribute::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\CategoryRequest $request
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, string $locale, Category $category)
    {
        //dd($request->all());

        $saveData = Arr::except($request->except('_token','path'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['corner'] = isset($saveData['corner']) && (bool)$saveData['corner'];
        $saveData['size'] = isset($saveData['size']) && (bool)$saveData['size'];
        $saveData['color'] = isset($saveData['color']) && (bool)$saveData['color'];
        $saveData['parent_id'] = $saveData['parent_id'] ? $saveData['parent_id'] : null;
        $saveData['on_page'] = isset($saveData['on_page']) && (bool)$saveData['on_page'];


        $filter = isset($saveData['filter']) ?? null;
        unset($saveData['filter']);
        if($filter == 'corner_color'){
            $saveData['corner'] = 1;
            $saveData['color'] = 1;
            $saveData['size'] = 0;
        }
        if($filter == 'size_color'){
            $saveData['corner'] = 0;
            $saveData['color'] = 1;
            $saveData['size'] = 1;
        }
        if($filter == 'size'){
            $saveData['corner'] = 0;
            $saveData['color'] = 0;
            $saveData['size'] = 1;
        }
        if($filter == 'color'){
            $saveData['corner'] = 0;
            $saveData['color'] = 1;
            $saveData['size'] = 0;
        }
        if($filter == 'corner_size_color'){
            $saveData['corner'] = 1;
            $saveData['color'] = 1;
            $saveData['size'] = 1;
        }
        if(!$filter){
            $saveData['corner'] = 0;
            $saveData['color'] = 0;
            $saveData['size'] = 0;
        }

        $this->categoryRepository->update($category->id, $saveData);

        $this->categoryRepository->model->attributes()->sync($saveData['attributes'] ?? []);



        // Save Files

            $category = $this->categoryRepository->saveFiles($category->id, $request);

        //dd(count($data));


        return redirect(locale_route('category.index', $category->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, Category $category)
    {
        if (!$this->categoryRepository->delete($category->id)) {
            return redirect(locale_route('category.show', $category->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('category.index'))->with('success', __('admin.delete_message'));
    }




    public function autocomplete(Request $request, CategoryRepository $categoryRepository) {
        $json = array();

        if ($request->get('filter_name') !== null) {

            $filter_data = array(
                'filter_name' => $request->get('filter_name'),
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->categoryRepository->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function addColor($locale,Category $category){

        //dd($category);


        //dd($categories);

        $url = locale_route('category.store_color', [$category], false);
        $method = 'POST';

        return view('admin.nowa.views.categories.colors-form', [
            'category' => $category,
            'url' => $url,
            'method' => $method,
            'category_color' => new CategoryColor()
        ]);
    }

    public function storeColor(Request $request, $locale, Category $category){
        $saveData = $request->except(['_token']);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['category_id'] = $category->id;
        //dd($saveData);
        $categoryColor = $this->categoryColorRepository->create($saveData);

        // Save Files


        $this->categoryColorRepository->saveFiles($categoryColor->id, $request);



        return redirect(locale_route('category.edit', $category->id))->with('success', __('admin.create_successfully'));


    }

    public function editColor($locate,Category $category,CategoryColor $categoryColor){
        $url = locale_route('category.update_color', [$category->id,$categoryColor->id], false);
        $method = 'PUT';





        return view('admin.nowa.views.categories.colors-form', [
            'category' => $category,
            'url' => $url,
            'method' => $method,
            'category_color' => $categoryColor
        ]);
    }

    public function updateColor(Request $request,$locale,Category $category,CategoryColor $categoryColor){
        $saveData = $request->except('_token','_method');
        //$saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];


        //dd($saveData);
        $this->categoryColorRepository->update($categoryColor->id, $saveData);


        // Save Files

        $this->categoryColorRepository->saveFiles($categoryColor->id, $request);

        //dd(count($data));


        return redirect(locale_route('category.edit', $category->id))->with('success', __('admin.update_successfully'));
    }

    public function deleteColor($locale, Category $category, CategoryColor $categoryColor){

        if (!$this->categoryColorRepository->delete($categoryColor->id)) {
            return redirect(locale_route('category.edit', $category->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('category.edit', $category->id))->with('success', __('admin.delete_message'));
    }
}
