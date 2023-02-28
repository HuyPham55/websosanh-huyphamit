<div class="card">
    <div class="card-body">
        <form>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="keyword">Search</label>
                    <input title="" class="form-control mr-sm-2" value="{{request('keyword')}}" id="keyword"
                           autocomplete="off" name="keyword">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{__('label.status.status')}}</label>
                    <select type="text" name="status" id="status" class="form-control">
                        <option value="" selected>{{__('label.all')}}</option>
                        <option
                            value="1" {{request()->input('status')?"selected":""}}>{{__('label.on')}}</option>
                        <option
                            value="0" {{ !is_null(request()->input('status')) && !request()->input('status')?"selected":""}}>{{__('label.off')}}</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-outline-primary" type="submit">
                {{__('label.search')}}
            </button>
        </form>
    </div>
</div>
