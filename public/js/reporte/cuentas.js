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
                        alquiler_deposito: {type: "string"},
                        alquiler_comentario: {type: "string"},
                        viaje_nombre: {type: "string"},
                        viaje_salida: {type: "date"},
                        viaje_regreso: {type: "date"},
                        banco: {type: "string"},
                        cliente: {type: "string"},
                        cliente_dpi: {type: "string"},
                        estado: {type: "string"},
                        emisor: {type: "string"},
                        monto: {type: "string"},
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
        filterable: true,
        resizable: true,
        pageable: {
            input: true,
            numeric: false
        },
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
    var dataSource = $("#main_grid").data("kendoGrid").dataSource;
    var filteredDataSource = new kendo.data.DataSource({
        data: dataSource.data(),
        filter: dataSource.filter(),
        sort: dataSource.sort()
    });
    filteredDataSource.read();
    var data = filteredDataSource.view();
    var result = "data:application/vnd.ms-excel,";
    result += "<table><tr><th>Cuenta por</th><th>Estado</th><th>Cliente</th><th>DPI</th><th>Monto</th><th>Renta del Equipo</th>" +
            "<th>Devolucion del Equipo</th><th>Deposito por el equipo</th><th>Comentario del alquiler</th><th>Viaje</th><th>Salida</th>" +
            "<th>Regreso</th><th>Tipo de pago</th><th>Banco</th><th>Cheque</th><th>Emisor</th>" +
            "<th>Tarjeta</th><th>Autorizacion</th></tr>";
    for (var i = 0; i < data.length; i++) {
        result += "<tr>";

        result += "<td>";
        result += data[i].tipo;
        result += "</td>";

        result += "<td>";
        result += data[i].estado;
        result += "</td>";

        result += "<td>";
        result += data[i].cliente;
        result += "</td>";

        result += "<td>";
        result += data[i].cliente_dpi;
        result += "</td>";

        result += "<td>";
        result += data[i].monto;
        result += "</td>";

        result += "<td>";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].alquiler_renta);
        result += "</td>";

        result += "<td>";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].alquiler_devolucion);
        result += "</td>";

        result += "<td>";
        result += data[i].alquiler_deposito;
        result += "</td>";

        result += "<td>";
        result += data[i].alquiler_comentario;
        result += "</td>";

        result += "<td>";
        result += data[i].viaje_nombre;
        result += "</td>";

        result += "<td>";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].viaje_salida);
        result += "</td>";

        result += "<td>";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].viaje_regreso);
        result += "</td>";

        result += "<td>";
        result += data[i].tipo_pago;
        result += "</td>";

        result += "<td>";
        result += data[i].banco;
        result += "</td>";

        result += "<td>";
        result += data[i].numero_cheque;
        result += "</td>";

        result += "<td>";
        result += data[i].emisor;
        result += "</td>";

        result += "<td>";
        result += data[i].numero_tarjeta;
        result += "</td>";

        result += "<td>";
        result += data[i].numero_autorizacion;
        result += "</td>";

        result += "</tr>";
    }
    result += "</table>";
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), 'reporte_cuentas.xls');
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "reporte_cuentas.xls");
        link.click();
    }
}