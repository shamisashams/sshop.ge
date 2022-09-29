<?php

namespace App\Repositories\Eloquent;


use App\Models\Order;
use App\Models\ProductProductSet;
use App\Models\ProductSet;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\File as dFile;
use ReflectionClass;


class CollectionRepository extends BaseRepository
{

    public function __construct(ProductSet $model)
    {
        parent::__construct($model);
    }


    public function saveSetImage(int $id, $request){
        $this->model = $this->findOrFail($id);


        $path = explode('/',$this->model->set_image);

        array_shift($path);

        dFile::delete(storage_path('app/public/' . implode('/',$path)));
        //dd(storage_path('app/public/' . implode('/',$path)));


        //dd($this->model->recipe_img);

        // Get Name Of model
        $reflection = new ReflectionClass(get_class($this->model));
        $modelName = $reflection->getShortName();



        $imagename = date('Ymhs') . str_replace(' ', '', $request->file('set_image')->getClientOriginalName());
        $destination = 'public/'. $modelName . '/' . $this->model->id . '/set_image';
        $path = $request->file('set_image')->storeAs($destination, $imagename);
        $this->model->where('id',$id)->update([
            'set_image' => 'storage/'.$modelName . '/' . $this->model->id . '/set_image/'.$imagename,

        ]);



        return $this->model;
    }

}
