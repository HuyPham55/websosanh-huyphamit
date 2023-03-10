@forelse($categories as $category)
    <tr id="row-id-{{ $category->id }}">
        <td>
            <span
                class="text-primary">{{ str_repeat('___ ', (($category->level > 0) ? ($category->level - 1) : 0)) }}</span>
            {{$category->title}} ({{$category->products_count}})
        </td>
        <td>
            @if(auth()->user()->can('edit_product_categories'))
                <input type="number" value="{{ $category->sorting }}" data-item="{{ $category->id }}"
                       class="update-sorting" style="max-width: 75px;" min="0" max="e9" placeholder="0">
            @else
                {{ $category->sorting }}
            @endif
        </td>
        <td class="bt-switch">
            <input type="checkbox" class="change-status" data-field="status" data-item-id="{{ $category->id }}"
                   data-size="normal" data-on-color="success"
                   data-on-text="{{ __('label.on') }}" data-off-text="{{ __('label.off') }}"
                   {{ $category->status == 1 ? 'checked' : '' }}
                   @cannot('edit_product_categories')
                       disabled
                @endcannot
            />
        </td>
        <td>
            @can('edit_product_categories')
                @includeIf('components.buttons.edit', ['route' => route('product_categories.edit', $category->id)])
            @endcan

            @can('edit_product_categories')
                @includeIf('components.buttons.delete', ['route' => route('product_categories.delete'), 'id' => $category->id])
            @endcan
        </td>
    </tr>

    @if(!empty($category->subs))
        @includeIf('admin.product_categories.rows', ['categories' => $category->subs])
    @endif
@empty
    <tr>
        <td colspan="10" style="text-align: center"><i>No record</i></td>
    </tr>
@endforelse



