<?php

$ids = $product->categories->pluck("id")->toArray();

$stock_ids = $product->stocks->pluck("id")->toArray();

//dd($stock_ids);
if($product->parent_id === null){
    $disabled = '';
    } else $disabled = 'disabled';

$traverse = function ($categories, $prefix = '-') use (&$traverse,$ids,$disabled) {

    $html = '<ul style="margin: initial !important;padding: initial !important;">';
    foreach ($categories as $key => $category) {
        if(in_array($category->id,$ids)) $checked = 'checked';

        elseif(in_array($category->id,old('categories') ?? [])){

            $checked = 'checked';
        } else $checked = '';
        $html .= '<li style="margin-bottom: 5px"><label class="ckbox">
                        <input '.$disabled.' type="checkbox" name="categories[]" data-checkboxes="mygroup" class="custom-control-input" '. $checked .' id="'.$category->id.'" value="'.$category->id.'">
                        <span style="margin-left: 5px">'.$category->title.'</span>

                        </label></li>';


        if(count($category->children)){
            $html .= '<li class="child" style="padding-left: 20px;margin-bottom: 5px">';
            $html .= $traverse($category->children, $prefix.'-');
            $html .= '</li>';
        }

    }

    $html .= '</ul>';

    return $html;
};

?>
@extends('admin.nowa.views.layouts.app')

@section('styles')

    <!--- Internal Select2 css-->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <!---Internal Fancy uploader css-->
    <link href="{{asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/telephoneinput/telephoneinput.css')}}">

    <link rel="stylesheet" href="{{asset('uploader/image-uploader.css')}}">
    <!--  smart photo master css -->
    <link href="{{asset('assets/plugins/SmartPhoto-master/smartphoto.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/croppie/croppie.css')}}" />

@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{$product->created_at ? __('admin.product-update') : __('admin.product-create')}}</span>
            @if($product->parent)<span class="main-content-title mg-b-0 mg-b-lg-1">&nbsp; Product Parent: <a href="{{route('product.edit',$product->parent->id)}}">{{$product->parent->title}}</a></span>@endif
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->
    <input name="old-images[]" id="old_images" hidden disabled value="{{$product->files}}">
    <!-- row -->
    {!! Form::model($product,['url' => $url, 'method' => $method,'files' => true]) !!}
    <input id="inp_crop_img" type="hidden" name="base64_img">

    @if($product->parent_id !== null)
        @foreach($ids as $id)
            <input type="hidden" name="categories[]" value="{{$id}}">
        @endforeach
    @endif

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="mb-4">


                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        @foreach(config('translatable.locales') as $locale)
                                            <?php
                                            $active = '';
                                            if($loop->first) $active = 'active';
                                            ?>

                                            <li><a href="#lang-{{$locale}}" class="nav-link {{$active}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="main-content-label mg-b-5">
                                    @lang('admin.productinfo')
                                    </div>
                                    @foreach(config('translatable.locales') as $locale)

                                        <?php
                                        $active = '';
                                        if($loop->first) $active = 'active';
                                        ?>
                                        <div class="tab-pane {{$active}}" id="lang-{{$locale}}">
                                            <div class="form-group">
                                                <label class="form-label">@lang('admin.title')</label>
                                                <input type="text" name="{{$locale.'[title]'}}" class="form-control" placeholder="Name" value="{{$product->translate($locale)->title ?? old($locale.'.title')}}">
                                                @error($locale.'.title')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>

                                            {{--<div class="form-group">
                                                {!! Form::label($locale.'[short_description]',__('admin.short_description'),['class' => 'form-label']) !!}
                                                {!! Form::text($locale.'[short_description]',$product->translate($locale)->short_description ?? '',['class' => 'form-control']) !!}

                                                @error($locale.'.short_description')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>--}}

                                            <div class="form-group">
                                                <label class="form-label" for="description">@lang('admin.description')</label>
                                                <textarea class="form-control" id="description-{{$locale}}"
                                                          name="{{$locale}}[description]'">
                                                    {!! $product->translate($locale)->description ?? old($locale.'.description') !!}
                                                </textarea>
                                                @error($locale.'.description')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>



                                            <div class="main-content-label mg-b-5 text-danger">
                                            @lang('admin.product_seo')
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label($locale.'[meta_title]',__('admin.meta_title'),['class' => 'form-label']) !!}
                                                {!! Form::text($locale.'[meta_title]',$product->translate($locale)->meta_title ?? old($locale.'.meta_title'),['class' => 'form-control']) !!}

                                                @error($locale.'.meta_title')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label($locale.'[meta_description]',__('admin.meta_description'),['class' => 'form-label']) !!}
                                                {!! Form::text($locale.'[meta_description]',$product->translate($locale)->meta_description ?? old($locale.'.meta_description'),['class' => 'form-control']) !!}

                                                @error($locale.'.meta_description')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label($locale.'[meta_keyword]',__('admin.meta_keyword'),['class' => 'form-label']) !!}
                                                {!! Form::text($locale.'[meta_keyword]',$product->translate($locale)->meta_keyword ?? old($locale.'.meta_keyword'),['class' => 'form-control']) !!}

                                                @error($locale.'.meta_keyword')
                                                <small class="text-danger">
                                                    <div class="error">
                                                        {{$message}}
                                                    </div>
                                                </small>
                                                @enderror
                                            </div>




                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">

                    <div>
                        <h6 class="card-title mb-1">@lang('admin.prodcategoriesss')</h6>
                    </div>
                    <div class="mb-4">


                        <?=$traverse($categories);?>

                            @if($errors->has('categories'))
                                <small class="error text-danger">{{ $errors->first('categories') }}</small>
                            @endif


                    </div>

                    <div class="form-group">
                        {!! Form::label('slug',__('admin.slug'),['class' => 'form-label']) !!}
                        <input type="text" name="slug" class="form-control" placeholder="@lang('admin.slug')" value="{{$product->slug ?? old('slug')}}">
                        @error('slug')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>


                    <div class="form-group">
                        {!! Form::label('code',__('admin.code'),['class' => 'form-label']) !!}
                        {!! Form::text('code',$product->code ?? old('code'),['class' => 'form-control']) !!}

                        @error('code')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    @if($product->created_at and $product->parent_id !== null)
                    <div class="form-group">
                        {!! Form::label('price',__('admin.price'),['class' => 'form-label']) !!}
                        {!! Form::number('price',$product->price ?? old('price'),['class' => 'form-control','step' => '0.01','min' => '0']) !!}

                        @error('price')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>
                    @endif

                    @if($product->created_at and $product->parent_id !== null)
                    <div class="form-group">
                        {!! Form::label('special_price',__('admin.special_price'),['class' => 'form-label']) !!}
                        {!! Form::number('special_price',$product->special_price ?? old('special_price'),['class' => 'form-control','step' => '0.01','min' => '0']) !!}

                        @error('special_price')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">@lang('admin.installment_price')</label>
                        <input type="number" class="form-control" name="installment_price" value="{{$product->installment_price ?? old('installment_price')}}">

                        @error('installment_price')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    {{--<div class="form-group">
                        {!! Form::label('code',__('admin.quantity'),['class' => 'form-label']) !!}
                        {!! Form::number('quantity',$product->quantity,['class' => 'form-control','min' => '0']) !!}

                        @error('code')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="form-label">@lang('admin.size')</label>
                        <input class="form-control" type="text" name="size" value="{{$product->size}}">

                        @error('size')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>--}}

                    <?php
                    $corners = [
                      'left',
                      'right'
                    ];
                    ?>
                    {{--<div class="form-group">
                        <label class="form-label">@lang('admin.corner')</label>
                        <select name="corner" class="form-control">
                            <option value=""></option>
                            @foreach($corners as $corner)
                                <option value="{{$corner}}" {{$product->corner == $corner ? 'selected':''}}>{{$corner}}</option>
                            @endforeach
                        </select>

                        @error('corner')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>--}}

                    <div class="form-group">
                        <label class="form-label">@lang('admin.video')</label>
                        <textarea name="video" class="form-control">{{$product->video ? $product->video->path : old('video')}}</textarea>
                        @error('video')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('admin.promocode')</label>
                        <select name="promocode_id" class="form-control">
                            <option value=""></option>
                            @foreach($promocodes as $promocode)
                                <option value="{{$promocode->id}}" {{$product->promocode_id == $promocode->id ? 'selected':(old('promocode_id') == $promocode->id ? 'selected' : '')}}>{{$promocode->reward}}</option>
                            @endforeach
                        </select>

                        @error('promocode')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>


                    @if($product->created_at and $product->parent_id !== null)
                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.product_stock')
                        </div>
                    </div>
                    @foreach($stocks as $stock)
                        <div class="form-group">
                            <label class="ckbox">
                                <input type="checkbox" name="stock_id[]"
                                       value="{{$stock->id}}" {{in_array($stock->id,$stock_ids) ? 'checked' : (in_array($stock->id,(old('stock_id')??[])) ? 'checked':'')}}>
                                <span>{{$stock->title}}</span>
                            </label>
                        </div>
                    @endforeach
                    @endif


                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.product_features')
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="status"
                                   value="true" {{$product->status ? 'checked' : (old('status') ? 'checked' : '')}}>
                            <span>{{__('admin.status')}}</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="popular"
                                   value="true" {{$product->popular ? 'checked' : (old('popular') ? 'checked' : '')}}>
                            <span>{{__('admin.popular')}}</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="new"
                                   value="true" {{$product->new ? 'checked' : (old('new') ? 'checked' : '')}}>
                            <span>{{__('admin.new_product')}}</span>
                        </label>
                    </div>

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="new_collection"
                                   value="true" {{$product->new_collection ? 'checked' : ''}}>
                            <span>{{__('admin.new_collection')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="bunker"
                                   value="true" {{$product->bunker ? 'checked' : ''}}>
                            <span>{{__('admin.bunker')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="day_product"
                                   value="true" {{$product->day_product ? 'checked' : ''}}>
                            <span>{{__('admin.day_product')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="day_price"
                                   value="true" {{$product->day_price ? 'checked' : ''}}>
                            <span>{{__('admin.day_price')}}</span>
                        </label>
                    </div>--}}

                    <div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="special_price_tag"
                                   value="true" {{$product->special_price_tag ? 'checked' : (old('special_price_tag') ? 'checked' : '')}}>
                            <span>{{__('admin.special_price_tag')}}</span>
                        </label>
                    </div>

                    {{--<div class="form-group">

                        {!! Form::label('sale',__('admin.sale')) !!}
                        {!! Form::number('sale',$product->sale ?? '',['step'=>'0.1','class' => 'form-control']) !!}

                        @error('sale')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror

                    </div>--}}
                    @if($product->created_at and $product->parent_id !== null)
                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.product_collection')
                        </div>
                    </div>

                    <?php
                    $set_id = $product->collections->pluck('id')->toArray();

                    ?>
                    <div class="form-group">
                        <select class="form-control" name="collection_id">
                            <option value=""></option>
                            @foreach($collections as $item)
                                <option value="{{$item->id}}" {{in_array($item->id,$set_id) ? 'selected':''}}>
                                    {{$item->title}}
                                </option>
                            @endforeach
                        </select>
                        @error('collection_id')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    @endif




                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.product_attributes')
                        </div>

                    </div>

                    <?php
                    $prod_attr = \Illuminate\Support\Arr::pluck($product->attribute_values,'integer_value','attribute_id');
                    $prod_attr_bool = \Illuminate\Support\Arr::pluck($product->attribute_values,'boolean_value','attribute_id');
                    //dd($prod_attr_bool,$prod_attr);
                    ?>
                    <?php
                    $arr = [
                        'material',
                        'brand'
                    ];
                    ?>
                    <?php
                    $size_attr  = [];
                    $attr_size_id = null;
                    ?>
                    @foreach($attributes as $item)

                        <?php
                        if ($item->code == 'size')
                        $size_attr = $item;
                        ?>
                        @if(($product->created_at and $product->parent_id == null) && in_array($item->code,$arr))
                            <div class="form-group">
                                <label class="form-label">{{$item->code}}</label>

                                @if($item->type == 'select')
                                    <select class="form-control" name="attribute[{{$item->id}}]">

                                        <option value=""></option>
                                        @foreach($item->options as $option)
                                            <?php
                                                if (isset($prod_attr[$item->id])){
                                                    if($prod_attr[$item->id] == $option->id){
                                                        $selected = ' selected';
                                                    } else $selected = '';
                                                } else $selected = '';
                                            ?>
                                            <option value="{{$option->id}}"{{$selected}}>{{$option->code}} {{$option->label}} {{$option->value}}</option>
                                        @endforeach
                                    </select>
                                @else

                                    <?php
                                    if (isset($prod_attr_bool[$item->id])){
                                        if($prod_attr_bool[$item->id]){
                                            $checked = ' checked';
                                            $val = 1;
                                        } else {
                                            $checked = '';
                                            $val = 0;
                                        }
                                    } else {
                                        $checked = '';
                                        $val = 0;
                                    }
                                    ?>

                                    <label class="ckbox">
                                        <input type="hidden" name="attribute[{{$item->id}}]" value="{{$val}}">
                                        <input class="bool_ckbox" type="checkbox"{{$checked}}>
                                        <span></span>
                                    </label>

                                @endif
                            </div>



                            @elseif(($product->created_at and $product->parent_id !== null) && !in_array($item->code,$arr))

                                <div class="form-group">
                                    <label class="form-label">{{$item->code}}</label>

                                    @if($item->code == 'size')
                                        <?php
                                        $attr_size_id = $item->id;
                                        ?>
                                        <div class="form-group">
                                            <ul id="selected_products">
                                                @foreach($item->options as $option)
                                                    <?php
                                                    if (isset($prod_attr[$item->id])){
                                                        if($prod_attr[$item->id] == $option->id){
                                                            $selected = true;
                                                        } else $selected = false;
                                                    } else $selected = false;
                                                    ?>
                                                    @if($selected)
                                                        <li>
                                                            <span>{{$option->value}}</span>
                                                            <input type="hidden" name="attribute[{{$item->id}}]" value="{{$option->id}}">
                                                            <a href="javascript:;" class="delete_product">delete</a>
                                                        </li>
                                                        @else
                                                            {{--<input type="hidden" name="attribute[{{$item->id}}]" value="">--}}
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <input class="form-control" type="text" id="search_product" name="term" value="" placeholder="Add search products">
                                            <ul id="product_list">

                                            </ul>
                                        </div>

                                    @else
                                        @if($item->type == 'select')
                                            <select class="form-control" name="attribute[{{$item->id}}]">
                                                <option value=""></option>
                                                @foreach($item->options as $option)
                                                    <?php
                                                    if (isset($prod_attr[$item->id])){
                                                        if($prod_attr[$item->id] == $option->id){
                                                            $selected = ' selected';
                                                        } else $selected = '';
                                                    } else $selected = '';
                                                    ?>
                                                    <option value="{{$option->id}}"{{$selected}}>{{$option->code}} {{$option->label}} {{$option->value}}</option>
                                                @endforeach
                                            </select>
                                        @else

                                            <?php
                                            if (isset($prod_attr_bool[$item->id])){
                                                if($prod_attr_bool[$item->id]){
                                                    $checked = ' checked';
                                                    $val = 1;
                                                } else {
                                                    $checked = '';
                                                    $val = 0;
                                                }
                                            } else {
                                                $checked = '';
                                                $val = 0;
                                            }
                                            ?>

                                            <label class="ckbox">
                                                <input type="hidden" name="attribute[{{$item->id}}]" value="{{$val}}">
                                                <input class="bool_ckbox" type="checkbox"{{$checked}}>
                                                <span></span>
                                            </label>

                                        @endif
                                    @endif


                                </div>


                        @elseif(!$product->created_at && in_array($item->code,$arr))
                            <div class="form-group">
                                <label class="form-label">{{$item->code}}</label>

                                @if($item->type == 'select')
                                    <select class="form-control" name="attribute[{{$item->id}}]">
                                        <option value=""></option>
                                        @foreach($item->options as $option)
                                            <?php
                                            if (isset($prod_attr[$item->id])){
                                                if($prod_attr[$item->id] == $option->id){
                                                    $selected = ' selected';
                                                } else $selected = '';
                                            } elseif(old('attribute.'.$item->id) == $option->id){
                                                $selected = ' selected';
                                            }
                                            else $selected = '';
                                            ?>
                                            <option value="{{$option->id}}"{{$selected}}>{{$option->code}} {{$option->label}} {{$option->value}}</option>
                                        @endforeach
                                    </select>
                                @else

                                    <?php
                                    if (isset($prod_attr_bool[$item->id])){
                                        if($prod_attr_bool[$item->id]){
                                            $checked = ' checked';
                                            $val = 1;
                                        } else {
                                            $checked = '';
                                            $val = 0;
                                        }
                                    } else {
                                        $checked = '';
                                        $val = 0;
                                    }
                                    ?>

                                    <label class="ckbox">
                                        <input type="hidden" name="attribute[{{$item->id}}]" value="{{$val}}">
                                        <input class="bool_ckbox" type="checkbox"{{$checked}}>
                                        <span></span>
                                    </label>

                                @endif
                            </div>
                            @endif
                    @endforeach





                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            {!! Form::submit($product->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>




        <!-- /row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">@lang('admin.product_image_crop_upload')</h6>
                        </div>

                        <div>
                            <p>Select a image file to crop</p>
                            <input type="file" id="inputFile" accept="image/png, image/jpeg">
                        </div>
                        <div id="actions" style="display: none;">
                            <button id="cropBtn" type="button">Crop @if($product->created_at)& Upload @endif</button>
                        </div>
                        <div id="croppieMount"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->


    <!-- /row -->
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.prouctimages')</h6>
                    </div>
                    {{--<div class="input-images"></div>--}}
                    @if ($errors->has('images'))
                        <span class="help-block">
                                            {{ $errors->first('images') }}
                                        </span>
                    @endif



                    <div class="image-uploader">
                        <div class="uploaded">

                            @foreach($product->files as $item)

                                    <div class="uploaded-image">

                                        <img src="{{asset($item->getFileUrlAttribute())}}" alt="" />

                                        <div style="position: absolute;z-index: 10;background-color: #fff">
                                            <input type="hidden" name="old_images[]"  value="{{$item->id}}">
                                            <label class="rdiobox"><input name="main" value="{{$item->id}}" name="rdio" type="radio" {{$item->main ? 'checked':''}}> <span>Main</span></label>

                                            <button type="button" class="btn" data-rm_img="{{$item->id}}">remove</button>
                                        </div>
                                    </div>



                            @endforeach
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    @if(!$product->created_at || $product->parent_id == null)
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.add_matras_variant')</h6>
                    </div>


                    <button type="button" id="add_size">add size</button>

                    <div id="variants">



                        @foreach($product->variants as $variant)

                            <?php
                            $prod_attr = \Illuminate\Support\Arr::pluck($variant->attribute_values,'integer_value','attribute_id');

                            ?>

                        <div class="row row-sm row_size">
                            <div class="col-lg">
                                <select class="form-control" name="matras[{{$variant->id}}][option_id]">

                                    @foreach($attributes as $item)
                                        @if($item->code == 'size')

                                            @foreach($item->options as $option)
                                                <?php
                                                if (isset($prod_attr[$item->id])){
                                                    if($prod_attr[$item->id] == $option->id){
                                                        $selected = ' selected';
                                                    } else $selected = '';
                                                } else $selected = '';
                                                ?>
                                                <option value="{{$option->id}}" {{$selected}}>{{$option->value}}</option>

                                            @endforeach
                                            @break
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <input class="form-control" placeholder="Price" type="number" name="matras[{{$variant->id}}][price]" value="{{$variant->price}}">
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <input class="form-control" placeholder="Special Price" type="number" name="matras[{{$variant->id}}][special_price]" value="{{$variant->special_price}}">
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <a data-id="{{$variant->id}}" class="btn delete_size" href="javascript:;">delete</a>
                            </div>
                        </div>
                        @endforeach
                    </div>





                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- row closed -->

    <!-- /row -->

    <!-- row -->

    <!-- row closed -->
    {!! Form::close() !!}



    @if($product->created_at and $product->parent_id === null)
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="main-content-label mg-b-5">
                                @lang('admin.colors')
                                <div class="form-group">
                                    <a class="btn btn-success" href="{{route('product.add-color',$product)}}">@lang('admin.add_colors')</a>
                                </div>

                                <table class="table">
                                    <tr>
                                        <th>id</th>
                                        <th>color</th>
                                        <th></th>
                                    </tr>
                                    @foreach($product->colors as $color)
                                        <tr>
                                            <td>{{$color->id}}</td>
                                            <td style="background-color: {{$color->color}}">{{$color->color}}</td>
                                            <td>
                                                <a href="{{locale_route('product.edit_color',[$product,$color->id])}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">შეცვლა</i>
                                                </a>
                                                <a href="{{locale_route('product.delete_color',[$product,$color->id])}}"
                                                   onclick="return confirm('Are you sure?')" class="pl-3">
                                                    <i class="fa fa-edit">წაშლა</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if($product->created_at and $product->parent_id == null)
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.product_variants')</h6>
                    </div>

                    <div>
                        <a class="btn btn-success" href="{{route('product.variant.create',$product)}}">@lang('admin.create_variant')</a>
                    </div>



                    <div>
                        <table class="table mg-b-0 text-md-nowrap">
                            <tr>
                                <th>id</th>
                                <th>title</th>
                                <th>attributes</th>
                                <th>price</th>
                                <th>stock</th>
                                <th></th>
                            </tr>

                            @foreach($product->variants as $variant)
                                <?php

                                $v_stock_ids = $variant->stocks->pluck("id")->toArray();
                                $result = [];

                                foreach ($variant->attribute_values as $item){
                                    $options = $item->attribute->options;
                                    $value = '';
                                    foreach ($options as $option){
                                        if($item->attribute->type == 'select'){
                                            if($item->integer_value == $option->id) {
                                                if($item->attribute->code == 'size'){
                                                    $result[$item->attribute->code] = $option->value;
                                                }
                                                elseif ($item->attribute->code == 'corner'){
                                                    $result[$item->attribute->code] = $option->code;
                                                }
                                                else {
                                                    $result[$item->attribute->code] = $option->label;
                                                }
                                            }

                                        }
                                    }

                                }
                                ?>
                                <tr>
                                    <td>
                                        {{$variant->id}}
                                    </td>
                                    <td>
                                        {{$variant->title}}
                                    </td>
                                    <td>
                                        <?php
                                        $attributes = '';

                                        foreach ($result as $key => $value){
                                            $attributes .= '<b>' . $key . '</b> : ' . $value . "\n";
                                        }
                                        ?>
                                        <pre>{!! $attributes !!}</pre>
                                    </td>
                                    <td>{!! $variant->special_price ? $variant->special_price .' <span style="text-decoration: line-through;">' . $variant->price . '</span>' : $variant->price !!}</td>
                                    <td>
                                        <?php
                                        $_stocks = '';


                                        foreach ($stocks as $_stock){
                                            if(in_array($_stock->id,$v_stock_ids)) $_checked = 'checked';
                                            else $_checked = '';
                                            $_stocks .= '<div class="form-group"><label class="ckbox">
                        <input onclick="return false" type="checkbox" name="stock_id[]" data-checkboxes="mygroup" class="custom-control-input" '. $_checked .' value="'.$_stock->id.'">
                        <span style="margin-left: 5px">'.$_stock->title.'</span>

                        </label></div>';
                                        }
                                        ?>
                                        {!! $_stocks !!}
                                    </td>
                                    <td>
                                        <a href="{{locale_route('product.edit',$variant->id)}}"
                                           class="pl-3">
                                            <i class="fa fa-edit">შეცვლა</i>
                                        </a>
                                        <a href="{{locale_route('product.destroy',$variant->id)}}"
                                           onclick="return confirm('Are you sure?')" class="pl-3">
                                            <i class="fa fa-edit">წაშლა</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')

    <!--Internal  Datepicker js -->
    <script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

    <!-- Internal Select2 js-->
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <!--Internal Fileuploads js-->
    <script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

    <!--Internal Fancy uploader js-->
    <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

    <!--Internal  Form-elements js-->
    <script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <!-- Internal TelephoneInput js-->
    <script src="{{asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
    <script src="{{asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

    <script src="{{asset('uploader/image-uploader.js')}}"></script>

    <!-- smart photo master js -->
    <script src="{{asset('assets/plugins/SmartPhoto-master/smartphoto.js')}}"></script>
    <script src="{{asset('assets/js/gallery.js')}}"></script>

    <script>
        let oldImages = $('#old_images').val();
        if (oldImages) {
            oldImages = JSON.parse(oldImages);
        }
        let imagedata = [];
        let getUrl = window.location;
        let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
        if (oldImages && oldImages.length > 0) {
            oldImages.forEach((el, key) => {
                let directory = '';
                if (el.fileable_type === 'App\\Models\\Project') {
                    directory = 'project';
                }
                imagedata.push({
                    id: el.id,
                    src: `${baseUrl}${el.path}/${el.title}`
                })
            })
            $('.input-images').imageUploader({
                //preloaded: imagedata,
                imagesInputName: 'images',
                preloadedInputName: 'old_images'
            });
        } else {
            $('.input-images').imageUploader();
        }
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        @foreach(config('translatable.locales') as $locale)
        CKEDITOR.replace('description-{{$locale}}', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        @endforeach
    </script>

    <script>
        $('[name="categories[]"]').click(function (e){
            let $this = $(this);


                let next = $this.closest('li').next('li');
                //console.log(next);
                if(next.hasClass('child')){
                    if($this.is(':checked')){

                        next.find('input[type=checkbox]').prop('checked',true);
                    } else {
                        next.find('input[type=checkbox]').prop('checked',false);
                    }
                }

                if($this.parents('li').hasClass('child')){

                    if($this.is(':checked')){

                        $this.parents('.child').prev('li').find('input[type=checkbox]').prop('checked',true);
                        //$this.parents('.child').find('input[type=checkbox]').prop('checked',true);
                    } else {
                        //$this.parents('.child').find('input[type=checkbox]').prop('checked',false);
                        $this.parents('.child').prev('li').find('input[type=checkbox]').prop('checked',false);
                    }
                }


        });

        $('.bool_ckbox').click(function (e){
            if($(this).is(':checked')){
                $(this).prev('input[type=hidden]').val(1);
            } else $(this).prev('input[type=hidden]').val(0);
        });

        $('[data-rm_img]').click(function (e){
            $(this).parents('.uploaded-image').remove();
        })
    </script>


    <script src="{{asset('admin/croppie/croppie.js')}}"></script>
    <script>
        let croppie = null;
        let croppieMount = document.getElementById('croppieMount');

        let cropBtn = document.getElementById('cropBtn');

        let inputFile = document.getElementById('inputFile');

        let actions = document.getElementById('actions');

        function cleanUpCroppie() {
            croppieMount.innerHTML = '';
            croppieMount.classList.remove('croppie-container');

            croppie = null;
        }

        inputFile.addEventListener('change', () => {
            cleanUpCroppie();

            // Our input file
            let file = inputFile.files[0];

            let reader = new FileReader();
            reader.onloadend = function(event) {
                // Get the data url of the file
                const data = event.target.result;

                // ...
            }

            reader.readAsDataURL(file);

            reader.onloadend = function(event) {
                // Get the data ulr of the file
                const data = event.target.result;

                croppie = new Croppie(croppieMount, {
                    url: data,
                    viewport: {
                        width: 800,
                        height: 500,

                    },
                    boundary: {
                        width: 1000,
                        height: 700
                    },
                    mouseWheelZoom: false,
                    enableResize: true,
                });

                // Binds the image to croppie
                croppie.bind();

                // Unhide the `actions` div element
                actions.style.display = '';
            }
        })


        cropBtn.addEventListener('click', () => {
            // Get the cropped image result from croppie
            croppie.result({
                type: 'base64',
                circle: false,
                format: 'png',
                size: 'original'
            }).then((imageResult) => {
                // Initialises a FormData object and appends the base64 image data to it
                let formData = new FormData();
                formData.append('base64_img', imageResult);
                formData.append('_token', '{{csrf_token()}}');

                document.getElementById('inp_crop_img').value = imageResult;
                // Sends a POST request to upload_cropped.php
                @if($product->created_at)
                fetch('{{route('product.crop-upload',$product)}}', {
                    method: 'POST',
                    body: formData
                }).then(() => {
                    location.reload()
                });
                @else
                alert('cropped')
                @endif
            });
        });

        let interval;

        $('#search_product').keyup(function (e){
            let val = $(this).val();

            let attr_size_id = parseInt({{$attr_size_id}})

            $('#selected_products').find('li').html(`<input type="hidden" name="attribute[${attr_size_id}]" value="">`);

            clearInterval(interval);
            interval = setTimeout(function () {
                console.log(val.length);
                if (val.length > 0) {
                    $.ajax({
                        url: '{{route('size.search.ajax')}}',
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                            term: val
                        },
                        beforeSend: function (){

                        },
                        success: function (data){
                            console.log(data);
                            $('#product_list').html(data);
                        }
                    });
                } else {
                    $('#product_list').html('');
                }
            }, 600);
        })

        $(document).on('click','[data-sel_product]',function (e){
            $('#search_product').val('');
            $('#product_list').html('');
            let id = $(this).data('sel_product');
            let title =  $(this).text();
            let attr_size_id = parseInt({{$attr_size_id}})
            let inp = `<li>
                    <span>${title}</span>
                        <input type="hidden" name="attribute[${attr_size_id}]" value="${id}">
<a href="javascript:;" class="delete_product">delete</a>
                        </li>`;
            $('#selected_products').html(inp)
        });

        $(document).on('click','.delete_product',function (e){
            let attr_size_id = parseInt({{$attr_size_id}})
            $(this).parents('li').html(`<input type="hidden" name="attribute[${attr_size_id}]" value="">`);
        });


        let size_attr = @json($size_attr);

        console.log(size_attr);

        $('#add_size').click(function (e){

            let opt = '';
            size_attr.options.forEach(function (el,i){
                opt += `<option value="${el.id}">${el.value}</option>`;
            })

            let row = `<div class="row row-sm row_size">
                            <div class="col-lg">
                                <select class="form-control" name="matras_new[option_id][]">
                                    <option value="">${opt}</option>

            </select>
        </div>
        <div class="col-lg mg-t-10 mg-lg-t-0">
            <input class="form-control" placeholder="Price" type="number" name="matras_new[price][]" value="">
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <input class="form-control" placeholder="Special Price" type="number" name="matras_new[special_price][]" value="">
                            </div>
<div class="col-lg mg-t-10 mg-lg-t-0">
                                <a class="btn delete_size" href="javascript:;">delete</a>
                            </div>
                        </div>`;


            $('#variants').append(row);
        });

        $(document).on('click','.delete_size',function (e){
           $(this).parents('.row_size').remove();
           let id = $(this).data('id');
           console.log(id);
           if(id !== undefined)
           $('#variants').append(`<input type="hidden" name="del_var[]" value="${id}">`);
        });

    </script>

@endsection
