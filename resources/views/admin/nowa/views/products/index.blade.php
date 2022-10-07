@extends('admin.nowa.views.layouts.app')

@section('styles')



@endsection

@section('content')

{{--@dd($categories)--}}

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.products')</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@lang('admin.products')</h4>
                    </div>

                    <form enctype="multipart/form-data" action="{{route('product.import')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" type="file" name="file">
                        </div>
                        @error('file')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                        <?php
                        $chars = [
                            'A',
                            'B',
                            'C',
                            'D',
                            'E',
                            'F',
                            'G',
                            'H',
                            'I',
                            'J',
                            'K',
                            'L',
                            'M',
                            'N',
                            'O',
                            'P',
                            'R',
                            'S',
                            'T'
                        ];
                        ?>
                        <div class="form-group">
                            <label class="form-label">skip rows</label>
                            <input class="form-control" type="number" name="skip_rows" value="{{old('skip_rows') ?? 1}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">model cell</label>
                            <select name="model" class="form-control">
                                @foreach($chars as $key => $char)
                                    <option value="{{$char}}" {{$key == 0 || old('model') == $char ? 'selected':''}}>{{$char}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">name cell</label>
                            <select name="name" class="form-control">
                                @foreach($chars as $key => $char)
                                    <option value="{{$char}}" {{$key == 1 || old('name') == $char ? 'selected':''}}>{{$char}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">description cell</label>
                            <select name="description" class="form-control">
                                @foreach($chars as $key => $char)
                                    <option value="{{$char}}" {{$key == 2 || old('description') == $char ? 'selected':''}}>{{$char}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">quantity cell</label>
                            <select name="quantity" class="form-control">
                                @foreach($chars as $key => $char)
                                    <option value="{{$char}}" {{$key == 3 || old('quantity') == $char ? 'selected':''}}>{{$char}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">price cell</label>
                            <select name="price" class="form-control">
                                @foreach($chars as $key => $char)
                                    <option value="{{$char}}" {{$key == 4 || old('price') == $char ? 'selected':''}}>{{$char}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">@lang('admin.import')</button>
                        </div>


                    </form>

                    <div class="form-group">
                        <a href="{{locale_route('product.create')}}" class="btn ripple btn-primary" type="button">@lang('admin.createbutt')</a>
                    </div>




                    {{--<p class="tx-12 tx-gray-500 mb-2">Example of Nowa Simple Table. <a href="">Learn more</a></p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="mr-0 p-0">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.model')</th>
                                    <th>@lang('admin.slug')</th>
                                    <th>@lang('admin.group')</th>
                                    <th>@lang('admin.category')</th>
                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.quantity')</th>
                                    <th>@lang('admin.attributes')</th>
                                    <th>@lang('admin.title')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <th>
                                        <input class="form-control" type="number" name="id" onchange="this.form.submit()"
                                               value="{{Request::get('id')}}"
                                               class="validate {{$errors->has('id') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="model" onchange="this.form.submit()"
                                               value="{{Request::get('model')}}"
                                               class="validate {{$errors->has('model') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="slug" onchange="this.form.submit()"
                                               value="{{Request::get('slug')}}"
                                               class="validate {{$errors->has('slug') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="group" onchange="this.form.submit()"
                                               value="{{Request::get('group')}}"
                                               class="validate {{$errors->has('group') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <select class="form-control" name="category_id" onchange="this.form.submit()">
                                            <option value="" {{Request::get('category_id') === '' ? 'selected' :''}}>@lang('admin.any')</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{Request::get('category_id') == $category->id ? 'selected' :''}}>{{$category->title}}</option>
                                            @endforeach

                                        </select>
                                    </th>
                                    <th>
                                        <select class="form-control" name="status" onchange="this.form.submit()">
                                            <option value="" {{Request::get('status') === '' ? 'selected' :''}}>@lang('admin.any')</option>
                                            <option value="1" {{Request::get('status') === '1' ? 'selected' :''}}>@lang('admin.active')</option>
                                            <option value="0" {{Request::get('status') === '0' ? 'selected' :''}}>@lang('admin.not_active')</option>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <input class="form-control" type="text" name="title" onchange="this.form.submit()"
                                               value="{{Request::get('title')}}"
                                               class="validate {{$errors->has('title') ? '' : 'valid'}}">
                                    </th>

                                @if($data)
                                    @foreach($data as $item)
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            <th scope="row">{{$item->model}}</th>
                                            <th scope="row">{{$item->slug}}</th>
                                            <td>{{$item->group}}</td>
                                            <td>
                                                <?php
                                                $path = [];
                                                $arr = [];
                                                foreach ($item->categories as $key =>$cat){


                                                    $ancestors = $cat->ancestors;
                                                    if(count($ancestors)){
                                                        foreach ($ancestors as $ancestor){
                                                            $arr[count($ancestors)]['ancestors'][] = $ancestor;
                                                            $arr[count($ancestors)]['current'] = $cat;
                                                        }
                                                    } else {
                                                        $arr[0]['ancestors'] = [];
                                                        $arr[0]['current'] = $cat;
                                                    }
                                                }

                                                if(!empty($arr)){
                                                    $max = max(array_keys($arr));

                                                    $k = 0;
                                                    foreach ($arr[$max]['ancestors'] as $ancestor){
                                                        $path[$k]['id'] = $ancestor->id;
                                                        $path[$k]['slug'] = $ancestor->slug;
                                                        $path[$k]['title'] = $ancestor->title;
                                                        $path[$k]['colors'] = $ancestor->colors;
                                                        $path[$k]['corner'] = $ancestor->corner;
                                                        $path[$k]['size'] = $ancestor->size;
                                                        $path[$k]['color'] = $ancestor->color;
                                                        $k++;
                                                    }

                                                    $path[$k]['id'] = $arr[$max]['current']->id;
                                                    $path[$k]['slug'] = $arr[$max]['current']->slug;
                                                    $path[$k]['title'] = $arr[$max]['current']->title;
                                                    $path[$k]['colors'] = $arr[$max]['current']->colors;
                                                    $path[$k]['corner'] = $arr[$max]['current']->corner;
                                                    $path[$k]['size'] = $arr[$max]['current']->size;
                                                    $path[$k]['color'] = $arr[$max]['current']->color;
                                                }



                                                ?>


                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb breadcrumb-style mg-b-0">

                                                            @foreach($path as $_path)
                                                                <li class="breadcrumb-item">
                                                                    <a href="{{route('category.edit',$_path['id'])}}">{{$_path['title']}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ol>


                                                    </nav>
                                            </td>

                                            <td>

                                                @if($item->status)
                                                    <span class="green-text">@lang('admin.active')</span>
                                                @else
                                                    <span class="red-text">@lang('admin.not_active')</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{$item->quantity}}
                                            </td>
                                            <td>
                                                <?php
                                                $result = [];
                                                foreach ($item->attribute_values as $_item){
                                                    $options = $_item->attribute->options;
                                                    $value = '';
                                                    foreach ($options as $option){
                                                        if($_item->attribute->type == 'select'){
                                                            if($_item->integer_value == $option->id) {
                                                                if($_item->attribute->code == 'size'){
                                                                    $result[$_item->attribute->code] = $option->value;
                                                                }
                                                                elseif ($_item->attribute->code == 'corner'){
                                                                    $result[$_item->attribute->code] = $option->code;
                                                                }
                                                                else {
                                                                    $result[$_item->attribute->code] = $option->label;
                                                                }

                                                            }

                                                        }
                                                    }

                                                }

                                                $attributes = '';

                                                foreach ($result as $key => $value){
                                                    $attributes .= '<b>' . $key . '</b> : ' . $value . "\n";
                                                }
                                                ?>
                                                    <pre>{!! $attributes !!}</pre>
                                            </td>
                                            <td>
                                                <div class="panel panel-primary tabs-style-2">
                                                    <div class=" tab-menu-heading">
                                                        <div class="tabs-menu1">
                                                            <!-- Tabs -->
                                                            <ul class="nav panel-tabs main-nav-line">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li><a href="#cat-{{$locale}}-{{$item->id}}" class="nav-link {{$loop->first?"active":""}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body tabs-menu-body main-content-body-right border">
                                                        <div class="tab-content">

                                                            @foreach(config('translatable.locales') as $locale)
                                                                <div class="tab-pane {{$loop->first?"active":""}}" id="cat-{{$locale}}-{{$item->id}}">
                                                                    {{$item->translate($locale)->title ?? ''}}
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>

                                                <a href="{{locale_route('product.edit',$item->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">შეცვლა</i>
                                                </a>
                                                <a href="{{locale_route('product.destroy',$item->id)}}"
                                                   onclick="return confirm('Are you sure?')" class="pl-3">
                                                    <i class="fa fa-edit">წაშლა</i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif


                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        {{ $data->appends(request()->input())->links('admin.vendor.pagination.material') }}
    </div>
    <!-- /row -->

@endsection

@section('scripts')



@endsection
