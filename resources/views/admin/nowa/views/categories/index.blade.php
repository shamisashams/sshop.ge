@extends('admin.nowa.views.layouts.app')

@section('styles')



@endsection

@section('content')



    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.categories')</span>
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
                        <h4 class="card-title mg-b-0">@lang('admin.categories')</h4>
                    </div>
                    <a href="{{locale_route('category.create')}}" class="btn ripple btn-primary" type="button">@lang('admin.createbutt')</a>

                    {{--<p class="tx-12 tx-gray-500 mb-2">Example of Nowa Simple Table. <a href="">Learn more</a></p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="mr-0 p-0">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.slug')</th>
                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.path')</th>
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
                                        <input class="form-control" type="text" name="slug" onchange="this.form.submit()"
                                               value="{{Request::get('slug')}}"
                                               class="validate {{$errors->has('slug') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <select class="form-control" name="status" onchange="this.form.submit()">
                                            <option value="" {{Request::get('status') === '' ? 'selected' :''}}>@lang('admin.any')</option>
                                            <option value="1" {{Request::get('status') === '1' ? 'selected' :''}}>@lang('admin.active')</option>
                                            <option value="0" {{Request::get('status') === '0' ? 'selected' :''}}>@lang('admin.not_active')</option>
                                        </select>
                                    </th>
                                    <th>

                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="title" onchange="this.form.submit()"
                                               value="{{Request::get('title')}}"
                                               class="validate {{$errors->has('title') ? '' : 'valid'}}">
                                    </th>
                                    <th></th>
                                </tr>


                                @if($data)
                                    @foreach($data as $item)
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            <th scope="row">{{$item->slug}}</th>
                                            <td>
                                                @if($item->status)
                                                    <span class="green-text">@lang('admin.active')</span>
                                                @else
                                                    <span class="red-text">@lang('admin.not_active')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <?php

                                                $path = [];
                                                $arr = [];



                                                    $ancestors = $item->ancestors;
                                                    if(count($ancestors)){
                                                        foreach ($ancestors as $ancestor){
                                                            $arr[count($ancestors)]['ancestors'][] = $ancestor;
                                                            $arr[count($ancestors)]['current'] = $item;
                                                        }
                                                    } else {
                                                        $arr[0]['ancestors'] = [];
                                                        $arr[0]['current'] = $item;
                                                    }





                                                $max = max(array_keys($arr));

                                                $k = 0;
                                                foreach ($arr[$max]['ancestors'] as $ancestor){
                                                    $path[$k]['id'] = $ancestor->id;
                                                    $path[$k]['slug'] = $ancestor->slug;
                                                    $path[$k]['title'] = $ancestor->title;

                                                    $path[$k]['corner'] = $ancestor->corner;
                                                    $path[$k]['size'] = $ancestor->size;
                                                    $path[$k]['color'] = $ancestor->color;
                                                    $k++;
                                                }

                                                $path[$k]['id'] = $arr[$max]['current']->id;
                                                $path[$k]['slug'] = $arr[$max]['current']->slug;
                                                $path[$k]['title'] = $arr[$max]['current']->title;

                                                $path[$k]['corner'] = $arr[$max]['current']->corner;
                                                $path[$k]['size'] = $arr[$max]['current']->size;
                                                $path[$k]['color'] = $arr[$max]['current']->color;

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

                                                <a href="{{locale_route('category.edit',$item->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">შეცვლა</i>
                                                </a>

                                                <a href="{{locale_route('category.destroy',$item->id)}}"
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
