<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\File;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use ReflectionClass;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class UserRepository extends BaseRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function uploadCv($model, $request){
        if ($request->hasFile('cv')) {
            $this->model = $model;
            //dd($this->model);
            // Get Name Of model
            $reflection = new ReflectionClass(get_class($this->model));
            $modelName = $reflection->getShortName();


            $imagename = date('Ymhs') . str_replace(' ', '', $request->file('cv')->getClientOriginalName());
            $destination = base_path() . '/storage/app/public/' . $modelName . '/' . $this->model->id . '/cv';
            $request->file('cv')->move($destination, $imagename);
            $this->model->files()->create([
                'title' => $imagename,
                'path' => 'storage/' . $modelName . '/' . $this->model->id . '/cv',
                'format' => $request->file('cv')->getClientOriginalExtension(),
                'type' => File::CV,
                'main' => 0
            ]);

        }

        return $this->model;
    }

    public function uploadId($request){
        if ($request->hasFile('avatar')) {
            // Get Name Of model
            $reflection = new ReflectionClass(get_class($this->model));
            $modelName = $reflection->getShortName();



            foreach ($request->file('avatar') as $key => $file) {
                $imagename = date('Ymhs') . str_replace(' ', '', $file->getClientOriginalName());
                $destination = base_path() . '/storage/app/public/' . $modelName . '/' . $this->model->id . '/id';
                $request->file('avatar')[$key]->move($destination, $imagename);
                $this->model->files()->create([
                    'title' => $imagename,
                    'path' => 'storage/' . $modelName . '/' . $this->model->id . '/id',
                    'format' => $file->getClientOriginalExtension(),
                    'type' => File::ID,
                    'main' => 0
                ]);
            }

        }

        return $this->model;
    }

    public function getPartners(Request $request){

        return $this->model->filter($request)->where('is_partner',1)->paginate(10);
    }

    public function getCustomers(Request $request){
        return $this->model->filter($request)->where('is_partner',0)->where('is_admin',0)->paginate(10);
    }

}
