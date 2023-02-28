<div class="row">
    <div class="{{ !empty($classPreview) ? $classPreview : 'col-md-2 col-4' }}" id="image-preview-{{ $keyId }}">
        <img class="img-fluid" src="{!!  isImage($inputValue) ? $inputValue : '/images/no-image.png'  !!}"
             alt="{{$inputValue}}">
    </div>

    <div class="{{ !empty($classInput) ? $classInput : 'col-md-7 col-8' }}">
        <div class="input-group">
             <span class="input-group-btn">
                 <a data-input="{{ $keyId }}" data-preview="image-preview-{{ $keyId }}" class="btn btn-primary lfm-{{$lfmType}}">
                     <i class="fa fa-folder-open"></i>
                     {{__('label.action.select')}}
                 </a>
                 <button onclick="resetInput('{{ $keyId }}')" class="btn btn-outline-danger" type="button">
                     <i class="fas fa-eraser"></i>
                     {{__('label.action.clear')}}
                 </button>
             </span>
            <label for="{{ $keyId }}"></label>
            <input id="{{ $keyId }}" class="form-control" type="text" name="{{$inputName}}" value="{{$inputValue}}">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;" alt="" src="">
        <p class="text-muted">{{ $note }}</p>
    </div>
</div>


