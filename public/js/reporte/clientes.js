$(document).ready(function() {
    $('#clientes_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    mainGrid();
    logrosGrid();
    viajesGrid();
    alquilerGrid();
});

function exportAll() {
    var fileName = 'reporte_clientes_' + getDateString() + '.csv';
    var dataSource = $("#main_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Primer Nombre,Segundo Nombre,Primer Apellido,Segundo Apellido,DPI,Fecha de Nacimiento," +
            "Correo Electronico,Usuario de Facebook,Telefono,Direccion," +
            "Pais,Departamento,Municipio,Genero,Contacto de Emergencia," +
            "Telefono de Emergencia,Observacion General,Observacion Medica\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].primer_nombre + ",";
        result += data[i].segundo_nombre + ",";
        result += data[i].primer_apellido + ",";
        result += data[i].segundo_apellido + ",";
        result += data[i].dpi + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_nacimiento) + ",";
        result += data[i].correo_electronico + ",";
        result += data[i].usuario_facebook + ",";
        result += data[i].telefono + ",";
        result += data[i].direccion + ",";
        result += data[i].pais + ",";
        result += data[i].departamento + ",";
        result += data[i].municipio + ",";
        result += data[i].genero + ",";
        result += data[i].contacto_emergencia + ",";
        result += data[i].telefono_emergencia + ",";
        result += data[i].observacion_general + ",";
        result += data[i].observacion_medica + "\n";
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

function exportLogros() {
    var fileName = 'reporte_clientes_logros_' + getDateString() + '.csv';
    var dataSource = $("#logros_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Logro,Primer Nombre,Segundo Nombre,Primer Apellido,Segundo Apellido,DPI,Fecha de Nacimiento\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].logro + ",";
        result += data[i].primer_nombre + ",";
        result += data[i].segundo_nombre + ",";
        result += data[i].primer_apellido + ",";
        result += data[i].segundo_apellido + ",";
        result += data[i].dpi + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_nacimiento) + "\n";
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

function exportViajes() {
    var fileName = 'reporte_clientes_viajes_' + getDateString() + '.csv';
    var dataSource = $("#viajes_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Viaje,Fecha de Salida,Fecha de Regreso,Terminado,Asistencia,Primer Nombre,Segundo Nombre,Primer Apellido,Segundo Apellido,DPI,Fecha de Nacimiento\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].viaje + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_salida) + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_regreso) + ",";
        result += data[i].terminado + ",";
        result += data[i].asistencia + ",";
        result += data[i].primer_nombre + ",";
        result += data[i].segundo_nombre + ",";
        result += data[i].primer_apellido + ",";
        result += data[i].segundo_apellido + ",";
        result += data[i].dpi + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_nacimiento) + "\n";
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

function exportAlquiler() {
    var fileName = 'reporte_clientes_alquiler_' + getDateString() + '.csv';
    var dataSource = $("#alquiler_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Alquiler,Deposito,Renta,Devolucion,Equipo,Identificador,Primer Nombre,Segundo Nombre,Primer Apellido,Segundo Apellido,DPI,Fecha de Nacimiento,Comentario\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].alquiler + ",";
        result += data[i].deposito + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].renta) + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].devolucion) + ",";
        result += data[i].equipo + ",";
        result += data[i].identificador + ",";
        result += data[i].primer_nombre + ",";
        result += data[i].segundo_nombre + ",";
        result += data[i].primer_apellido + ",";
        result += data[i].segundo_apellido + ",";
        result += data[i].dpi + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_nacimiento) + ",";
        result += data[i].comentario + "\n";
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
                        primer_nombre: {type: "string"},
                        segundo_nombre: {type: "string"},
                        primer_apellido: {type: "string"},
                        segundo_apellido: {type: "string"},
                        dpi: {type: "string"},
                        fecha_nacimiento: {type: "date"},
                        correo_electronico: {type: "string"},
                        usuario_facebook: {type: "string"},
                        telefono: {type: "string"},
                        direccion: {type: "string"},
                        pais: {type: "string"},
                        departamento: {type: "string"},
                        municipio: {type: "string"},
                        genero: {type: "string"},
                        contacto_emergencia: {type: "string"},
                        telefono_emergencia: {type: "string"},
                        observacion_general: {type: "string"},
                        observacion_medica: {type: "string"}

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
            {field: "primer_nombre", title: "Primer Nombre", width: 150},
            {field: "segundo_nombre", title: "Segundo Nombre", width: 150},
            {field: "primer_apellido", title: "Primer Apellido", width: 150},
            {field: "segundo_apellido", title: "Segundo Apellido", width: 150},
            {field: "dpi", title: "DPI", width: 150},
            {field: "fecha_nacimiento", title: "Fecha de Nacimiento", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "correo_electronico", title: "Correo Electronico", width: 200},
            {field: "usuario_facebook", title: "Usuario de Facebook", width: 200},
            {field: "telefono", title: "Telefono", width: 150},
            {field: "direccion", title: "Direccion", width: 300},
            {field: "pais", title: "Pais", width: 150},
            {field: "departamento", title: "Departamento", width: 150},
            {field: "municipio", title: "Municipio", width: 150},
            {field: "genero", title: "Genero", width: 150},
            {field: "contacto_emergencia", title: "Contacto de Emergencia", width: 200},
            {field: "telefono_emergencia", title: "Telefono de Emergencia", width: 200},
            {field: "observacion_general", title: "Observacion General", width: 300, filterable: false},
            {field: "observacion_medica", title: "Observacion Medica", width: 300, filterable: false}
        ]
    });
}

function logrosGrid() {
    $("#logros_grid").kendoGrid({
        dataSource: {
            data: logros_data,
            schema: {
                model: {
                    fields: {
                        logro: {type: "string"},
                        primer_nombre: {type: "string"},
                        segundo_nombre: {type: "string"},
                        primer_apellido: {type: "string"},
                        segundo_apellido: {type: "string"},
                        dpi: {type: "string"},
                        fecha_nacimiento: {type: "date"}
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
            {template: kendo.template($("#logros_template").html())}
        ],
        columns: [
            {field: "logro", title: "Logro", width: 150},
            {field: "primer_nombre", title: "Primer Nombre", width: 150},
            {field: "segundo_nombre", title: "Segundo Nombre", width: 150},
            {field: "primer_apellido", title: "Primer Apellido", width: 150},
            {field: "segundo_apellido", title: "Segundo Apellido", width: 150},
            {field: "dpi", title: "DPI", width: 150},
            {field: "fecha_nacimiento", title: "Fecha de Nacimiento", width: 170, format: "{0: dd/MM/yyyy}"}
        ]
    });
}

function viajesGrid() {
    $("#viajes_grid").kendoGrid({
        dataSource: {
            data: viajes_data,
            schema: {
                model: {
                    fields: {
                        viaje: {type: "string"},
                        fecha_salida: {type: "date"},
                        fecha_regreso: {type: "date"},
                        terminado: {type: "string"},
                        asistencia: {type: "string"},
                        primer_nombre: {type: "string"},
                        segundo_nombre: {type: "string"},
                        primer_apellido: {type: "string"},
                        segundo_apellido: {type: "string"},
                        dpi: {type: "string"},
                        fecha_nacimiento: {type: "date"}
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
            {template: kendo.template($("#viajes_template").html())}
        ],
        columns: [
            {field: "viaje", title: "Viaje", width: 150},
            {field: "fecha_salida", title: "Fecha de Salida", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "fecha_regreso", title: "Fecha de Regreso", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "terminado", title: "Terminado", width: 150},
            {field: "asistencia", title: "Asistencia", width: 150},
            {field: "primer_nombre", title: "Primer Nombre", width: 150},
            {field: "segundo_nombre", title: "Segundo Nombre", width: 150},
            {field: "primer_apellido", title: "Primer Apellido", width: 150},
            {field: "segundo_apellido", title: "Segundo Apellido", width: 150},
            {field: "dpi", title: "DPI", width: 150},
            {field: "fecha_nacimiento", title: "Fecha de Nacimiento", width: 170, format: "{0: dd/MM/yyyy}"}
        ]
    });
}

function alquilerGrid() {
    $("#alquiler_grid").kendoGrid({
        dataSource: {
            data: alquiler_data,
            schema: {
                model: {
                    fields: {
                        alquiler: {type: "number"},
                        deposito: {type: "number"},
                        renta: {type: "date"},
                        devolucion: {type: "date"},
                        equipo: {type: "string"},
                        identificador: {type: "string"},
                        primer_nombre: {type: "string"},
                        segundo_nombre: {type: "string"},
                        primer_apellido: {type: "string"},
                        segundo_apellido: {type: "string"},
                        dpi: {type: "string"},
                        fecha_nacimiento: {type: "date"},
                        comentario: {type: "string"}
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
            {template: kendo.template($("#alquiler_template").html())}
        ],
        columns: [
            {field: "alquiler", title: "Alquiler", width: 150},
            {field: "deposito", title: "Deposito", width: 150},
            {field: "renta", title: "Renta", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "devolucion", title: "Devolucion", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "equipo", title: "Equipo", width: 150},
            {field: "identificador", title: "Identificador", width: 150},
            {field: "primer_nombre", title: "Primer Nombre", width: 150},
            {field: "segundo_nombre", title: "Segundo Nombre", width: 150},
            {field: "primer_apellido", title: "Primer Apellido", width: 150},
            {field: "segundo_apellido", title: "Segundo Apellido", width: 150},
            {field: "dpi", title: "DPI", width: 150},
            {field: "fecha_nacimiento", title: "Fecha de Nacimiento", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "comentario", title: "Comentario", width: 150, filterable: false}
        ]
    });
}