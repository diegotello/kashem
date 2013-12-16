$(document).ready(function() {
    $('#clientes_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
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
            pageSize: 20
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
    result += "<table><tr><th>Primer Nombre</th><th>Segundo Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>DPI</th><th>Fecha de Nacimiento</th>" +
            "<th>Correo Electronico</th><th>Usuario de Facebook</th><th>Telefono</th><th>Direccion</th>" +
            "<th>Pais</th><th>Departamento</th><th>Municipio</th><th>Genero</th><th>Contacto de Emergencia</th>" +
            "<th>Telefono de Emergencia</th><th>Observacion General</th><th>Observacion Medica</th></tr>";
    for (var i = 0; i < data.length; i++) {
        result += "<tr>";

        result += "<td>";
        result += data[i].primer_nombre;
        result += "</td>";

        result += "<td>";
        result += data[i].segundo_nombre;
        result += "</td>";

        result += "<td>";
        result += data[i].primer_apellido;
        result += "</td>";

        result += "<td>";
        result += data[i].segundo_apellido;
        result += "</td>";

        result += "<td>";
        result += data[i].dpi;
        result += "</td>";

        result += "<td>";
        result += kendo.format("{0:dd/MM/yyyy}", data[i].fecha_nacimiento);
        result += "</td>";

        result += "<td>";
        result += data[i].correo_electronico;
        result += "</td>";

        result += "<td>";
        result += data[i].usuario_facebook;
        result += "</td>";

        result += "<td>";
        result += data[i].telefono;
        result += "</td>";

        result += "<td>";
        result += data[i].direccion;
        result += "</td>";

        result += "<td>";
        result += data[i].pais;
        result += "</td>";

        result += "<td>";
        result += data[i].departamento;
        result += "</td>";

        result += "<td>";
        result += data[i].municipio;
        result += "</td>";

        result += "<td>";
        result += data[i].genero;
        result += "</td>";

        result += "<td>";
        result += data[i].contacto_emergencia;
        result += "</td>";

        result += "<td>";
        result += data[i].telefono_emergencia;
        result += "</td>";

        result += "<td>";
        result += data[i].observacion_general;
        result += "</td>";

        result += "<td>";
        result += data[i].observacion_medica;
        result += "</td>";

        result += "</tr>";
    }
    result += "</table>";
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(new Blob([result]), 'reporte_clientes.xls');
    } else {
        //window.open(result);
        var encodedUri = encodeURI(result);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "reporte_clientes.xls");
        link.click();
    }
}