$(document).ready(function() {
    $('#viajes_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    mainGrid();
    destinosGrid();
    actividadesGrid();
    guiasGrid();
});

function exportAll() {
    var fileName = 'reporte_viajes_' + getDateString() + '.csv';
    var dataSource = $("#main_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Viaje,Fecha de salida,Hora de salida,Fecha de regreso,Hora de regreso,Terminado\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].viaje + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_salida) + ",";
        result += data[i].hora_salida + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_regreso) + ",";
        result += data[i].hora_regreso + ",";
        result += data[i].terminado + "\n";
    }
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), fileName);
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", fileName);
        link.click();
    }
}

function exportDestinos() {
    var fileName = 'reporte_viajes_destinos_' + getDateString() + '.csv';
    var dataSource = $("#destinos_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Viaje,Fecha de salida,Hora de salida,Fecha de regreso,Hora de regreso,Terminado,Destino,Pais,Departamento,Municipio\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].viaje + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_salida) + ",";
        result += data[i].hora_salida + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_regreso) + ",";
        result += data[i].hora_regreso + ",";
        result += data[i].terminado + ",";
        result += data[i].destino + ",";
        result += data[i].pais + ",";
        result += data[i].departamento + ",";
        result += data[i].municipio + "\n";
    }
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), fileName);
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", fileName);
        link.click();
    }
}

function exportActividades() {
    var fileName = 'reporte_viajes_actividades_' + getDateString() + '.csv';
    var dataSource = $("#actividades_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Viaje,Fecha de salida,Hora de salida,Fecha de regreso,Hora de regreso,Terminado,Actividad\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].viaje + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_salida) + ",";
        result += data[i].hora_salida + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_regreso) + ",";
        result += data[i].hora_regreso + ",";
        result += data[i].terminado + ",";
        result += data[i].actividad + "\n";
    }
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), fileName);
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", fileName);
        link.click();
    }
}

function exportGuias() {
    var fileName = 'reporte_viajes_guias_' + getDateString() + '.csv';
    var dataSource = $("#guias_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Viaje,Fecha de salida,Hora de salida,Fecha de regreso,Hora de regreso,Terminado,Guia,DPI,Categoria\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].viaje + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_salida) + ",";
        result += data[i].hora_salida + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_regreso) + ",";
        result += data[i].hora_regreso + ",";
        result += data[i].terminado + ",";
        result += data[i].guia + ",";
        result += data[i].dpi + ",";
        result += data[i].categoria + "\n";
    }
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), fileName);
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", fileName);
        link.click();
    }
}

function mainGrid() {
    $("#main_grid").kendoGrid({
        dataSource: {
            data: data,
            schema: {
                model: {
                    fields: {
                        viaje: {type: "string"},
                        fecha_salida: {type: "date"},
                        fecha_regreso: {type: "date"},
                        hora_salida: {type: "string"},
                        hora_regreso: {type: "string"},
                        terminado: {type: "string"}
                    }
                }
            },
            pageSize: 10
        },
        scrollable: true,
        sortable: true,
        filterable: filterConfig,
        resizable: true,
        groupable: groupConfig,
        reorderable: true,
        navigatable: true,
        pageable: pageConfig,
        toolbar: [
            {template: kendo.template($("#all_template").html())}
        ],
        columns: [
            {field: "viaje", title: "Viaje", width: 150},
            {field: "fecha_salida", title: "Fecha de salida", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_salida", title: "Hora de salida", width: 150},
            {field: "fecha_regreso", title: "Fecha de regreso", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_regreso", title: "Hora de regreso", width: 150},
            {field: "terminado", title: "Terminado", width: 150}
        ]
    });
}

function destinosGrid() {
    $("#destinos_grid").kendoGrid({
        dataSource: {
            data: destinos_data,
            schema: {
                model: {
                    fields: {
                        viaje: {type: "string"},
                        fecha_salida: {type: "date"},
                        fecha_regreso: {type: "date"},
                        hora_salida: {type: "string"},
                        hora_regreso: {type: "string"},
                        terminado: {type: "string"},
                        destino: {type: "string"},
                        pais: {type: "string"},
                        departamento: {type: "string"},
                        municipio: {type: "string"}
                    }
                }
            },
            pageSize: 10
        },
        scrollable: true,
        sortable: true,
        filterable: filterConfig,
        resizable: true,
        groupable: groupConfig,
        reorderable: true,
        navigatable: true,
        pageable: pageConfig,
        toolbar: [
            {template: kendo.template($("#destino_template").html())}
        ],
        columns: [
            {field: "viaje", title: "Viaje", width: 150},
            {field: "fecha_salida", title: "Fecha de salida", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_salida", title: "Hora de salida", width: 150},
            {field: "fecha_regreso", title: "Fecha de regreso", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_regreso", title: "Hora de regreso", width: 150},
            {field: "terminado", title: "Terminado", width: 150},
            {field: "destino", title: "Destino", width: 150},
            {field: "pais", title: "Pais", width: 150},
            {field: "departamento", title: "Departamento", width: 150},
            {field: "municipio", title: "Municipio", width: 150}
        ]
    });
}

function actividadesGrid() {
    $("#actividades_grid").kendoGrid({
        dataSource: {
            data: actividades_data,
            schema: {
                model: {
                    fields: {
                        viaje: {type: "string"},
                        fecha_salida: {type: "date"},
                        fecha_regreso: {type: "date"},
                        hora_salida: {type: "string"},
                        hora_regreso: {type: "string"},
                        terminado: {type: "string"},
                        actividad: {type: "string"}
                    }
                }
            },
            pageSize: 10
        },
        scrollable: true,
        sortable: true,
        filterable: filterConfig,
        resizable: true,
        groupable: groupConfig,
        reorderable: true,
        navigatable: true,
        pageable: pageConfig,
        toolbar: [
            {template: kendo.template($("#actividad_template").html())}
        ],
        columns: [
            {field: "viaje", title: "Viaje", width: 150},
            {field: "fecha_salida", title: "Fecha de salida", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_salida", title: "Hora de salida", width: 150},
            {field: "fecha_regreso", title: "Fecha de regreso", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_regreso", title: "Hora de regreso", width: 150},
            {field: "terminado", title: "Terminado", width: 150},
            {field: "actividad", title: "Actividad", width: 150}
        ]
    });
}

function guiasGrid() {
    $("#guias_grid").kendoGrid({
        dataSource: {
            data: guias_data,
            schema: {
                model: {
                    fields: {
                        viaje: {type: "string"},
                        fecha_salida: {type: "date"},
                        fecha_regreso: {type: "date"},
                        hora_salida: {type: "string"},
                        hora_regreso: {type: "string"},
                        terminado: {type: "string"},
                        guia: {type: "string"},
                        dpi: {type: "string"},
                        categoria: {type: "string"}
                    }
                }
            },
            pageSize: 10
        },
        scrollable: true,
        sortable: true,
        filterable: filterConfig,
        resizable: true,
        groupable: groupConfig,
        reorderable: true,
        navigatable: true,
        pageable: pageConfig,
        toolbar: [
            {template: kendo.template($("#guia_template").html())}
        ],
        columns: [
            {field: "viaje", title: "Viaje", width: 150},
            {field: "fecha_salida", title: "Fecha de salida", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_salida", title: "Hora de salida", width: 150},
            {field: "fecha_regreso", title: "Fecha de regreso", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "hora_regreso", title: "Hora de regreso", width: 150},
            {field: "terminado", title: "Terminado", width: 150},
            {field: "guia", title: "Guia", width: 150},
            {field: "dpi", title: "DPI", width: 150},
            {field: "categoria", title: "Categoria", width: 150}
        ]
    });
}