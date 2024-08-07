<tbody>
    @if ($records instanceof \Illuminate\Pagination\LengthAwarePaginator && count($records))
        @foreach ($records as $key => $record)
            <tr>
                @if ($enableMassActions)
                    <td>
                        <span class="checkbox">
                            <input type="checkbox" v-model="dataIds" @change="select" value="{{ $record->{$index} }}">

                            <label class="checkbox-view" for="checkbox"></label>
                        </span>
                    </td>
                @endif

                @foreach ($columns as $column)
                    @php
                        $columnIndex = explode('.', $column['index']);

                        $columnIndex = end($columnIndex);
                    @endphp
                    
                    @if (isset($column['wrapper']))
                        @if (isset($column['closure']) && $column['closure'] == true)
                            <td data-value="{{ $column['label'] }}">{!! $column['wrapper']($record) !!}</td>
                        @else
                            <td data-value="{{ $column['label'] }}">{{ $column['wrapper']($record) }}</td>
                        @endif
                    @else
                        @if ($column['type'] == 'price')
                            @if (isset($column['currencyCode']))
                                <td data-value="{{ $column['label'] }}">{{ core()->formatPrice($record->{$columnIndex}, $column['currencyCode']) }}</td>
                            @else
                                <td data-value="{{ $column['label'] }}">{{ core()->formatBasePrice($record->{$columnIndex}) }}</td>
                            @endif

                        @elseif ($column['type'] == 'url')
                            <td data-value="{{ $column['label'] }}"><a href="/admin/catalog/products/edit/{{$record->{$columnIndex} }}">{{$record->{$columnIndex} }}</a></td>
                        @elseif ($column['type'] == 'imagePath')
                            <td data-value="{{ $column['label'] }}"><img src="/cache/large/{{ $record->{$columnIndex} }}" style="max-height:150px; max-width:150px"></td>
                        @else
                            <td data-value="{{ $column['label'] }}">{{ $record->{$columnIndex} }}</td>
                        @endif

                        


                    @endif
                @endforeach

                @if ($enableActions)
                    <td class="actions" style="white-space: nowrap; width: 100px;" data-value="{{ __('ui::app.datagrid.actions') }}">
                        <div class="action">
                            @foreach ($actions as $action)
                                @php
                                    $toDisplay = (isset($action['condition']) && gettype($action['condition']) == 'object') ? $action['condition']() : true;
                                @endphp

                                @if ($toDisplay)
                                    <a
                                    @if ($action['method'] == 'GET')
                                        href="{{ route($action['route'], $record->{$action['index'] ?? $index}) }}"
                                    @endif

                                    @if ($action['method'] != 'GET')
                                        v-on:click="doAction($event)"
                                    @endif

                                    data-method="{{ $action['method'] }}"
                                    data-action="{{ route($action['route'], $record->{$index}) }}"
                                    data-token="{{ csrf_token() }}"

                                    @if (isset($action['target']))
                                        target="{{ $action['target'] }}"
                                    @endif

                                    @if (isset($action['title']))
                                        title="{{ $action['title'] }}"
                                    @endif>
                                        <span class="{{ $action['icon'] }}"></span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10">
                <p style="text-align: center;">{{ $norecords }}</p>
            </td>
        </tr>
    @endif
</tbody>
