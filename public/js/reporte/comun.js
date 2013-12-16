var filterConfig = {
    messages: {
        and: "Y",
        clear: "Limpiar filtro",
        filter: "Aplicar filtro",
        info: "Filtrar por: ",
        isFalse: "Falso",
        isTrue: "Verdadero",
        or: "O",
        selectValue: "Seleccionar categoria",
        cancel: "Cancelar",
        operator: "Selecciona operador",
        value: "Selecciona valor"

    },
    operators: {
        string: {
            eq: "Igual a",
            neq: "Diferente a",
            startsWith: "Empieza con",
            contains: "Contiene",
            doesnotcontain: "No contiene",
            endswith: "Termina con"
        },
        number: {
            eq: "Igual a",
            neq: "Diferente a",
            gte: "Mayor o igual a",
            gt: "Mayor a",
            lte: "Menor o igual a",
            lt: "Menor a"
        },
        date: {
            eq: "Igual a",
            neq: "Diferente a",
            gte: "Mayor o igual a",
            gt: "Mayor a",
            lte: "Menor o igual a",
            lt: "Menor a"
        }
    }
},
groupConfig = {
    messages: {
        empty: "Arrastra una columna para agrupar los datos"
    }
},
pageConfig = {
    refresh: true,
    pageSizes: [5, 10, 20, 40, 60, 80, 100, 200],
    buttonCount: 5,
    messages: {
        display: "Mostrando {0}-{1} de {2} elementos",
        empty: "No hay datos",
        page: "Ingresa pagina",
        of: "desde {0}",
        itemsPerPage: "elementos por pagina",
        first: "Primera pagina",
        last: "Ultima pagina",
        next: "Siguiente",
        previous: "Anterior",
        refresh: "Recargar la tabla"
    }
};
