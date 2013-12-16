$(document).ready(function() {
    $('#cuentas_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $("#main_grid").kendoGrid({
        dataSource: {
            data: data,
            schema: {
                model: {
                    fields: {
                        alquiler_renta: {type: "date"},
                        alquiler_devolucion: {type: "date"},
                        alquiler_deposito: {type: "number"},
                        alquiler_comentario: {type: "string"},
                        viaje_nombre: {type: "string"},
                        viaje_salida: {type: "date"},
                        viaje_regreso: {type: "date"},
                        banco: {type: "string"},
                        cliente: {type: "string"},
                        cliente_dpi: {type: "string"},
                        estado: {type: "string"},
                        emisor: {type: "string"},
                        monto: {type: "number"},
                        numero_autorizacion: {type: "string"},
                        numero_cheque: {type: "string"},
                        numero_tarjeta: {type: "string"},
                        tipo: {type: "string"},
                        tipo_pago: {type: "string"}

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
            {field: "tipo", title: "Cuenta por", width: 150},
            {field: "estado", title: "Estado", width: 150},
            {field: "cliente", title: "Cliente", width: 150},
            {field: "cliente_dpi", title: "DPI", width: 150},
            {field: "monto", title: "Monto", width: 150},
            {field: "alquiler_renta", title: "Renta del equipo", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "alquiler_devolucion", title: "Devolucion del equipo", width: 170, format: "{0: dd/MM/yyyy}"},
            {field: "alquiler_deposito", title: "Deposito por el equipo", width: 180},
            {field: "alquiler_comentario", title: "Comentario del alquiler", width: 180},
            {field: "viaje_nombre", title: "Viaje", width: 150},
            {field: "viaje_salida", title: "Salida", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "viaje_regreso", title: "Regreso", width: 150, format: "{0: dd/MM/yyyy}"},
            {field: "tipo_pago", title: "Tipo de pago", width: 150},
            {field: "banco", title: "Banco", width: 150},
            {field: "numero_cheque", title: "Cheque", width: 150},
            {field: "emisor", title: "Emisor", width: 150},
            {field: "numero_tarjeta", title: "Tarjeta", width: 150},
            {field: "numero_autorizacion", title: "Autorizacion", width: 150, filterable: false}
        ]
    });
});

function exportAll() {
    var fileName = 'reporte_cuentas_' + getDateString() + '.csv';
    var dataSource = $("#main_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:text/csv;charset=utf-8,";
    result += "Cuenta por,Estado,Cliente,DPI,Monto,Renta del Equipo," +
            "Devolucion del Equipo,Deposito por el equipo,Comentario del alquiler,Viaje,Salida," +
            "Regreso,Tipo de pago,Banco,Cheque,Emisor," +
            "Tarjeta,Autorizacion\n";
    for (var i = 0; i < data.length; i++) {
        result += data[i].tipo + ",";
        result += data[i].estado + ",";
        result += data[i].cliente + ",";
        result += data[i].cliente_dpi + ",";
        result += data[i].monto + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].alquiler_renta) + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].alquiler_devolucion) + ",";
        result += data[i].alquiler_deposito + ",";
        result += data[i].alquiler_comentario + ",";
        result += data[i].viaje_nombre + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].viaje_salida) + ",";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].viaje_regreso) + ",";
        result += data[i].tipo_pago + ",";
        result += data[i].banco + ",";
        result += data[i].numero_cheque + ",";
        result += data[i].emisor + ",";
        result += data[i].numero_tarjeta + ",";
        result += data[i].numero_autorizacion + "\n";
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