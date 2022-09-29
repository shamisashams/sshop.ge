<?php

$ids = $model->categories->pluck("id")->toArray();



//dd($stock_ids);


$traverse = function ($categories, $prefix = '-') use (&$traverse,$ids) {

    $html = '<ul style="margin: initial !important;padding: initial !important;">';
    foreach ($categories as $category) {
        if(in_array($category->id,$ids)) $checked = 'checked';
        else $checked = '';
        $html .= '<li style="margin-bottom: 5px"><label class="ckbox">
                        <input type="checkbox" name="categories[]" data-checkboxes="mygroup" class="custom-control-input" '. $checked .' id="'.$category->id.'" value="'.$category->id.'">
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
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{$model->created_at ? __('admin.collection-update') : __('admin.collection-create')}}</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->
    <input name="old-images[]" id="old_images" hidden disabled value="{{$model->files}}">
    <!-- row -->
    {!! Form::model($model,['url' => $url, 'method' => $method,'files' => true]) !!}
    <input id="inp_crop_img" type="hidden" name="base64_img">
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
                                    @lang('admin.collectioninfo')
                                    </div>
                                    @foreach(config('translatable.locales') as $locale)

                                        <?php
                                        $active = '';
                                        if($loop->first) $active = 'active';
                                        ?>
                                        <div class="tab-pane {{$active}}" id="lang-{{$locale}}">
                                            <div class="form-group">
                                                <label class="form-label">@lang('admin.title')</label>
                                                <input type="text" name="{{$locale.'[title]'}}" class="form-control" placeholder="Name" value="{{$model->translate($locale)->title ?? ''}}">
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
                                                    {!! $model->translate($locale)->description ?? '' !!}
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
                                                {!! Form::text($locale.'[meta_title]',$model->translate($locale)->meta_title ?? '',['class' => 'form-control']) !!}

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
                                                {!! Form::text($locale.'[meta_description]',$model->translate($locale)->meta_keyword ?? '',['class' => 'form-control']) !!}

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
                                                {!! Form::text($locale.'[meta_keyword]',$model->translate($locale)->meta_description ?? '',['class' => 'form-control']) !!}

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
                        <h6 class="card-title mb-1">@lang('admin.collection_categories')</h6>
                    </div>
                    <div class="mb-4">


                        <?=$traverse($categories);?>

                        @if($errors->has('categories'))
                            <small class="error text-danger">{{ $errors->first('categories') }}</small>
                        @endif


                    </div>

                    <div class="form-group">
                        {!! Form::label('slug',__('admin.slug'),['class' => 'form-label']) !!}
                        <input type="text" name="slug" class="form-control" placeholder="@lang('admin.slug')" value="{{$model->slug ?? ''}}">
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
                        {!! Form::text('code',$model->code,['class' => 'form-control']) !!}

                        @error('code')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('price',__('admin.price'),['class' => 'form-label']) !!}
                        {!! Form::number('price',$model->price,['class' => 'form-control','step' => '0.01','min' => '0']) !!}

                        @error('price')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('special_price',__('admin.special_price'),['class' => 'form-label']) !!}
                        {!! Form::number('special_price',$model->special_price,['class' => 'form-control','step' => '0.01','min' => '0']) !!}

                        @error('special_price')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('video',__('admin.video'),['class' => 'form-label']) !!}
                        <textarea  name="video" class="form-control">{{$model->video ? $model->video->path : null}}</textarea>
                        @error('video')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>


                    <?php
                    $color_ids = $model->colors->pluck("id")->toArray();
                    //dd($color_ids)
                    ?>
                    <div class="form-group">
                        <label class="form-label">@lang('admin.color')</label>

                            @if($color)
                                @foreach($color->options as $option)

                                    <div class="form-group">
                                        <label class="rdiobox">
                                            <input type="radio" name="color[]"  class="custom-control-input" {{in_array($option->id,$color_ids) ? 'checked':''}} value="{{$option->id}}">
                                            <span style="margin-left: 20px;background-color: {{$option->color}};width: 80px;height: 20px">{{$option->label}}</span>

                                        </label>
                                    </div>

                                @endforeach
                            @endif

                        @error('color.*')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>



                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.product_features')
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="status"
                                   value="true" {{$model->status ? 'checked' : ''}}>
                            <span>{{__('admin.status')}}</span>
                        </label>
                    </div>

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="popular"
                                   value="true" {{$model->popular ? 'checked' : ''}}>
                            <span>{{__('admin.popular')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="new"
                                   value="true" {{$model->new ? 'checked' : ''}}>
                            <span>{{__('admin.new_product')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="new_collection"
                                   value="true" {{$model->new_collection ? 'checked' : ''}}>
                            <span>{{__('admin.new_collection')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="bunker"
                                   value="true" {{$model->bunker ? 'checked' : ''}}>
                            <span>{{__('admin.bunker')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="day_product"
                                   value="true" {{$model->day_product ? 'checked' : ''}}>
                            <span>{{__('admin.day_product')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="day_price"
                                   value="true" {{$model->day_price ? 'checked' : ''}}>
                            <span>{{__('admin.day_price')}}</span>
                        </label>
                    </div>--}}

                    {{--<div class="form-group">
                        <label class="ckbox">
                            <input type="checkbox" name="special_price_tag"
                                   value="true" {{$model->special_price_tag ? 'checked' : ''}}>
                            <span>{{__('admin.special_price_tag')}}</span>
                        </label>
                    </div>--}}

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



                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            {!! Form::submit($model->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- /row -->

    <!-- /row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.collection_image_crop_upload')</h6>
                    </div>

                    <div>
                        <p>Select a image file to crop</p>
                        <input type="file" id="inputFile" accept="image/png, image/jpeg">
                    </div>
                    <div id="actions" style="display: none;">
                        <button id="cropBtn" type="button">Crop @if($model->created_at)& Upload @endif</button>
                    </div>
                    <div id="croppieMount"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->


    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.images')</h6>
                    </div>
                    {{--<div class="input-images"></div>--}}
                    @if ($errors->has('images'))
                        <span class="help-block">
                                            {{ $errors->first('images') }}
                                        </span>
                    @endif



                    <div class="image-uploader">
                        <div class="uploaded">

                            @foreach($model->files as $item)

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

                    <br>

                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.set_image')
                        </div>
                    </div>

                    <div class="form-group">

                        <input type="file" class="dropify" name="set_image" data-default-file="{{($model->set_image) ? asset($model->set_image) : ''}}" data-height="200"  />

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- row closed -->

    <!-- /row -->

    <!-- row -->

    <!-- row closed -->
    {!! Form::close() !!}

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.products_collection')</h6>
                    </div>

                    @if($model->created_at)

                    <div class="form-group">
                        <form action="{{route('product.add-to-set',$model)}}" method="post">
                            @csrf
                            <ul id="selected_products">

                            </ul>
                            <button class="btn btn-secondary">add</button>
                        </form>

                        <input class="form-control" type="text" id="search_product" name="term" value="" placeholder="Add search products">
                        <ul id="product_list">

                        </ul>
                    </div>

                    @endif


                    <table class="table">
                        <tr>
                            <th>
                                product id
                            </th>
                            <th>
                                product title
                            </th>
                            <th>
                                product color
                            </th>
                            <th>
                                top
                            </th>
                            <th>
                                right
                            </th>
                            <th>
                                bottom
                            </th>
                            <th>
                                left
                            </th>
                            <th>

                            </th>
                        </tr>
                        {{--@dd($model->products)--}}
                        @foreach($model->products as $product)
                            <tr>
                                <td>
                                    {{$product->id}}
                                </td>
                                <td>
                                    <a href="{{route('product.edit',$product)}}">{{$product->title}}</a>
                                </td>
                                <td>
                                    <?php
                                    foreach ($product->attribute_values as $item){
                                        $options = $item->attribute->options;
                                        $value = '';
                                        foreach ($options as $option){
                                            if($item->attribute->type == 'select'){
                                                if($item->integer_value == $option->id) {
                                                    if($item->attribute->code == 'size'){
                                                        $result[$item->attribute->code] = $option->value;
                                                    }
                                                    if($item->attribute->code == 'color'){
                                                        $result[$item->attribute->code] = $option->color;
                                                    }
                                                    else {
                                                        $result[$item->attribute->code] = $option->label;
                                                    }
                                                }

                                            }
                                        }

                                    }

                                    $result;
                                    ?>
                                    <span style="background-color: {{$result['color']}};width: 25px;height: 25px;display: block"></span>
                                </td>
                                <?php
                                $coordinates = explode(' ',$product->pivot->coordinates);
                                //dd($coordinates);
                                ?>
                                <td>
                                    <input data-id="{{$product->pivot->id}}" class="form-control edit_coordinates" type="text" value="{{$coordinates[0]}}">
                                </td>
                                <td>
                                    <input data-id="{{$product->pivot->id}}" class="form-control edit_coordinates" type="text" value="{{$coordinates[1]}}">
                                </td>
                                <td>
                                    <input data-id="{{$product->pivot->id}}" class="form-control edit_coordinates" type="text" value="{{$coordinates[2]}}">
                                </td>
                                <td>
                                    <input data-id="{{$product->pivot->id}}" class="form-control edit_coordinates" type="text" value="{{$coordinates[3]}}">
                                </td>
                                <td>
                                    <a href="{{locale_route('product.edit',$product->id)}}"
                                       class="pl-3">
                                        <i class="fa fa-edit">შეცვლა</i>
                                    </a>
                                    <a href="{{locale_route('collection.destroy.product',$product->pivot->id)}}"
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
        /*$('[name="categories[]"]').click(function (e){
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


        });*/

        $('.bool_ckbox').click(function (e){
            if($(this).is(':checked')){
                $(this).prev('input[type=hidden]').val(1);
            } else $(this).prev('input[type=hidden]').val(0);
        });

        $('[data-rm_img]').click(function (e){
            $(this).parents('.uploaded-image').remove();
        })

        $('.edit_coordinates').keyup(function (e){
            let index = $('.edit_coordinates').index($(this));



            switch (index) {
                case 0:
                    if($(this).val() !== 'auto'){
                        $('.edit_coordinates').eq(2).val('auto');
                    }
                    break;
                case 1:
                    if($(this).val() !== 'auto'){
                        $('.edit_coordinates').eq(3).val('auto');
                    }
                    break;
                case 2:
                    if($(this).val() !== 'auto'){
                        $('.edit_coordinates').eq(0).val('auto');
                    }
                    break;
                case 3:
                    if($(this).val() !== 'auto'){
                        $('.edit_coordinates').eq(1).val('auto');
                    }
                    break;
            }
            if($(this).val() == ''){
                $(this).val('auto')
            }
        });

        $('.edit_coordinates').change(function (e){
            //e.preventDefault();
            let $this = $(this);
            let val = $this.val();

            let inputs = $('input[data-id="'+ $this.data('id') +'"]');



            let val_arr = [];
            let value = '';
            inputs.each(function (index,item){
                val_arr.push($(item).val());
            });
            value = val_arr.join(' ');

            //console.log(value);

            let data = {val: value, _token: '{{csrf_token()}}',id:$this.data('id')}



            $.ajax({
                url: '{{route('collection.update.coordinates')}}',
                data: data,
                dataType: 'json',
                type: 'put',
                beforeSend: function (){

                },
                success: function (data){
                    notif({
                        type: "success",
                        msg: "<b>Success: </b>Successfully Saved",
                        position: "center",
                        //autohide: false,
                        time: 3000
                    });
                },
                error: function (data){
                    console.log(data);
                    notif({
                        type: "error",
                        msg: "<b>Danger: </b>Error occurred!",
                        position: "center",
                        time: 3000,
                        //autohide: false
                    });
                }
            });
        });
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
                @if($model->created_at)
                fetch('{{route('collection.crop-upload',$model)}}', {
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


            clearInterval(interval);
            interval = setTimeout(function () {
                console.log(val.length);
                if (val.length > 0) {
                    $.ajax({
                        url: '{{route('collection.product.search.ajax')}}',
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                            term: val,
                            color: $('input[name="color[]"]:checked').val()
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
            let id = $(this).data('sel_product');
            let title =  $(this).text();
            let inp = `<li>
                    <span>${title}</span>
                        <input type="hidden" name="product_id[]" value="${id}">
<a href="javascript:;" class="delete_product">delete</a>
                        </li>`;
            $('#selected_products').append(inp)
        });

        $(document).on('click','.delete_product',function (e){
            $(this).parents('li').remove();
        });

    </script>

@endsection
