@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="/css/admin/product-admin.css">
@endsection
@section('title', __('product.update.title'))
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>@lang('product.update.table-title')</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form data-parsley-validate id="form-editor" method="POST" action="{!! route('admin.products.updateMeta', ['product' => $product['id']]) !!}" enctype="multipart/form-data" class="form-horizontal form-label-left">

            @csrf
            @method('PUT')
            @include('admin.layout.errors')

            <div class="form-group">
              @include('admin.layout.message')
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.category')</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <select name="category_id" class="select2_single form-control" tabindex="-1">
                  @foreach ( $categories as $category )
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('product.create.name')
                <span class="required">@lang('product.required')</span>
              </label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('name', $product->name) }}">
              </div>
            </div>

            <div class="form-group">
              <label for="preview" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.preview')</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <textarea class="resizable_textarea form-control" rows='5' name="preview" id="preview" required="required">{{ old('preview', $product->preview) }}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.price')
                <span class="required">@lang('product.required')</span>
              </label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="price" name="price" class="form-control col-md-7 col-xs-12" required="required" type="number" value="{{ old('price', $product->price) }}">
              </div>
            </div>

            <div class="form-group">
              <label for="quantity" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.quantity')
                <span class="required">@lang('product.required')</span>
              </label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" required="required" type="number" value="{{ old('quantity', $product->quantity) }}">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.image')
                <span class="required">@lang('product.required')</span>
              </label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div id="image" class="btn-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageInput">@lang('product.create.file-input')</label>
                  <input name="input_img[]" type="file" id="imageInput" multiple>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                @foreach ($product->images as $image)
                  <div id="img-{{ $image->id }}" class="col-lg-4 col-md-4 col-sm-6">
                    <div class="update-img"><img class="img-responsive" src="{{ $image->getImageUrlAttribute() }}" alt=""></div>
                    <button onclick="deleteImage('{{ route('admin.api.images.destroy', ['id' => $image->id]) }}', event)" class="delete-img-btn btn-danger"><i class="fa fa-trash"></i></button>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product.create.description')</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
              <!-- ckeditor description-->
                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-description">
                  <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    </ul>
                  </div>

                  <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a data-edit="fontSize 5">
                          <p style="font-size:17px">Huge</p>
                        </a>
                      </li>
                      <li>
                        <a data-edit="fontSize 3">
                          <p style="font-size:14px">Normal</p>
                        </a>
                      </li>
                      <li>
                        <a data-edit="fontSize 1">
                          <p style="font-size:11px">Small</p>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <div class="btn-group">
                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                  </div>

                  <div class="btn-group">
                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                  </div>

                  <div class="btn-group">
                    <a class="btn btn-info" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                  </div>

                  <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                    <div class="dropdown-menu input-append">
                      <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                      <button class="btn" type="button">Add</button>
                    </div>
                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                  </div>

                  <div class="btn-group">
                    <a class="btn" title="Insert picture (or just drag &amp; drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage">
                  </div>

                  <div class="btn-group">
                    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                  </div>
                </div>

                <div id="editor-description" class="editor-wrapper placeholderText" contenteditable="true">{{ old('description', $product->description) }}</div>
                <textarea name="description" id="description" hidden></textarea>

              <!-- -->
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <button class="btn btn-primary" type="reset">@lang('common.reset')</button>
                <button type="submit" onclick="submitForm(event)" class="btn btn-success">@lang('product.update.update')</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="/js/admin/product.js"></script>
@endsection
