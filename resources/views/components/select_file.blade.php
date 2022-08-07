<div class="row">
    <div class="{{ !empty($classPreview) ? $classPreview : 'col-md-2 col-4' }}" id="image-preview-{{ $keyId }}">
        <img class="img-fluid" src="{!!  isImage($inputValue) ? $inputValue : '/images/no-image.png'  !!}">
    </div>


    <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-file-archive"></i> Choose
     </a>
   </span>
        <label for="thumbnail"></label>
        <input id="thumbnail" class="form-control" type="text" name="filepath">
    </div>
    <img id="holder" style="margin-top:15px;max-height:100px;" alt="" src="">

</div>


