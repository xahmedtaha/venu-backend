@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-file-text-o font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">تقرير زيارات المطاعم</span>
            {{-- <span class="caption-helper">{{Translator::get('add_category_caption')}}</span> --}}
        </div>
    </div>
    <div class="portlet-body">
        {{-- <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"></label>
                    <div class="col-md-4">
                        <input type="text" name="" required class="form-control" placeholder="">
                        <span class="help-block"> A block of help text. </span>
                    </div>
                </div>
        </div> --}}
        <div id="gridContainer">

        </div>
    </div>
</div>
@endsection
@section('javascript')
    @include('layouts.adminPanel.reportScripts')
    <script>
        var dataGrid = null;
        $(document).ready(function () 
        { 
            $.ajax({
                url : '{{route("reports.visits.getVisitsData")}}',
                method : 'GET',
                headers : {
                    'accept-language' : '{{Auth::user()->lang}}'
                },
                success : function (data) 
                { 
                    initGrid(data);
                },

            });
        });
        function initGrid(datasource)
        {

            dataGrid = $("#gridContainer").dxDataGrid(
            {
                dataSource: datasource,
                columnMinWidth: 50,
                columnAutoWidth: true,
                rtlEnabled:true,
                showColumnLines: true,
                showRowLines: true,
                rowAlternationEnabled: true,
                showBorders: true,
                allowColumnResizing: true,
                columnChooser: {
                    enabled: true
                },
                columnFixing: { 
                    enabled: true
                },
                filterRow: {
                    visible: true,
                    applyFilter: "auto"
                },"export": {
                    enabled: true,
                    fileName: "زيارات المطاعم",
                    allowExportSelectedData: false ,
                    printingEnabled: true

                },
                searchPanel: {
                    visible: true,
                    width: 240,
                    placeholder: "Search..."
                },
                headerFilter: {
                    visible: true
                },paging: {
                    pageSize: 10
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [5, 10, 20],
                    showInfo: true
                },
                columns: [ 
                {
                    dataField: "name",

                    caption: "اسم المطعم",

                    alignment: "right",

                },
                {
                    dataField: "count",
                    
                    caption: "عدد الزيارات",

                    alignment: "right",
 
                }

                ]
            }).dxDataGrid('instance');
            $("#column-lines").dxCheckBox({
                text: "Show Column Lines",
                value: false,
                onValueChanged: function(data) {
                    dataGrid.option("showColumnLines", data.value);
                }
            });
            
            $("#row-lines").dxCheckBox({
                text: "Show Row Lines",
                value: true,
                onValueChanged: function(data) {
                    dataGrid.option("showRowLines", data.value);
                }
            });
            
            $("#show-borders").dxCheckBox({
                text: "Show Borders",
                value: true,
                onValueChanged: function(data) {
                    dataGrid.option("showBorders", data.value);
                }
            });
            
            $("#row-alternation").dxCheckBox({
                text: "Alternating Row Color",
                value: true,
                onValueChanged: function(data) {
                    dataGrid.option("rowAlternationEnabled", data.value);
                }
            });

            var applyFilterTypes = [{
                key: "auto",
                name: "Immediately"
            }, {
                key: "onClick",
                name: "On Button Click"
            }];
            
            var applyFilterModeEditor = $("#useFilterApplyButton").dxSelectBox({
                items: applyFilterTypes,
                value: applyFilterTypes[0].key,
                valueExpr: "key",
                displayExpr: "name",
                onValueChanged: function(data) {
                    dataGrid.option("filterRow.applyFilter", data.value);
                }
            }).dxSelectBox("instance");
        
            $("#filterRow").dxCheckBox({
                text: "Filter Row",
                value: true,
                onValueChanged: function(data) {
                    dataGrid.clearFilter();
                    dataGrid.option("filterRow.visible", data.value);
                    applyFilterModeEditor.option("disabled", !data.value);
                }
            });
            
            $("#headerFilter").dxCheckBox({
                text: "Header Filter",
                value: true,
                onValueChanged: function(data) {
                    dataGrid.clearFilter();
                    dataGrid.option("headerFilter.visible", data.value);
                }
            });
        }
    </script>
@endsection