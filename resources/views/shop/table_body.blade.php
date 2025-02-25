
    <tr>
      <td> {{ @$attributes['key']  }}</td>
      <td>{{ @$product->name }}
        <input type="hidden" name="order[product][{{ @$inventory->id }}]" value="{{ @$product->id }}">
      </td>
      <td>{{ @$inventory->unit->name }} - {{ @$inventory->unit_quantity }}
        <input type="hidden" name="order[inventory][]" value="{{ @$inventory->id }}">
      </td>
      <td >{{ @$attributes['quantity'] }}
        <input type="hidden" class="form-control"  min="1" name="order[quantity][{{ @$inventory->id }}]" value="{{ @$attributes['quantity'] }}">
      </td>
      <td>{{  number_format(@$attributes['sell_price'],2) }}
        <input type="hidden" name="order[sell_price][{{ @$inventory->id }}]" value="{{ @$attributes['sell_price'] }}">
      
      </td>
      <td>{{  number_format(@$attributes['quantity'] * @$attributes['sell_price'],2) }}
        <input type="hidden" name="order[total_price][{{ @$inventory->id }}]" value="{{ @$attributes['quantity'] * @$attributes['sell_price'] }}">
      
      </td>
      <td>
        <button  class="btn btn-danger remove_product"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
    